<?php

namespace App\Livewire\Settings;

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use ProfileValidationRules, WithFileUploads;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public string $country = '';
    public $avatar;
    public $avatarUrl;

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:10240', // 10MB Max
        ]);
    }

    public function avatarPreview()
    {
        if ($this->avatar instanceof TemporaryUploadedFile) {
            return $this->avatar->temporaryUrl();
        }

        return $this->avatarUrl;
    }

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->first_name = Auth::user()->first_name;
        $this->last_name = Auth::user()->last_name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone;
        $this->country = Auth::user()->country;
        $this->avatarUrl = Auth::user()->getFirstMediaUrl('avatar');
    }

    public function profileRules($userId)
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $userId,
            ],
            'phone' => [
                'nullable',
                'digits_between:10,12',
                'unique:users,phone,' . $userId,
            ],
            'country' => ['required', 'string', 'in:IN,CA,US,ES,CN'],
            'avatar'  => 'image|max:10240', // 10MB Max
        ];
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        if ($this->avatar instanceof TemporaryUploadedFile) {
            $user->addMedia($this->avatar)
                ->toMediaCollection('avatar');
        }

        unset($validated['avatar']);
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        $this->avatarUrl = $user->getFirstMediaUrl('avatar'); // ✅ update url
        $this->avatar = $this->avatarUrl;

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}
