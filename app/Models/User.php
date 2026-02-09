<?php

namespace App\Models;

use App\Enum\UserStatusEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, InteractsWithMedia, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'country',
        'is_active',
        'avatar',
        'role_id',
    ];
    protected $attributes = [
        'is_active' => UserStatusEnum::ACTIVE,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => UserStatusEnum::class,
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        if ($this->hasMedia('avatar')) {
            return $this->getFirstMediaUrl('avatar', 's3');
        }

        return "https://ui-avatars.com/api/?name={$this->first_name} {$this->last_name}&background=fff&color=333&size=128&bold=true&length=2";
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->useFallbackPath(public_path('/images/default-avatar.png'))
            ->useFallbackUrl('https://placehold.net/avatar.svg');
    }
}
