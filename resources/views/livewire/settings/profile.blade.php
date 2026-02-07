<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile information.')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">

            <div class="flex items-center gap-4">

                <div class="w-18 h-16 rounded-full overflow-hidden">
                    @if ($avatarUrl)
                        <img src="{{ $this->avatarPreview() }}" alt="{{ auth()->user()->name }}"
                            class="w-full h-full object-cover">
                    @endif

                </div>

                <flux:input type="file" wire:model="avatar" accept="image/png, image/jpeg, image/webp" />

            </div>
            @error('avatar')
                <div
                    class="mt-3 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/30 dark:text-red-300">

                    <!-- icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 flex-shrink-0" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 4h.01M10.29 3.86l-7.6 13.16A2 2 0 004.4 20h15.2a2 2 0 001.71-2.98L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>

                    <!-- text -->
                    <span>{{ $message }}</span>

                </div>
            @enderror




            <flux:input wire:model="first_name" :label="__('First Name')" type="text" required autofocus
                autocomplete="first-name" />
            <flux:input wire:model="last_name" :label="__('Last Name')" type="text" required autofocus
                autocomplete="last-name" />
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end ">

                <!-- Country -->
                <div class="w-full sm:w-1/4">

                    <flux:field>
                        <flux:label>Country</flux:label>
                        <flux:select name="country" wire:model="country">
                            <flux:select.option value="IN">India</flux:select.option>
                            <flux:select.option value="CA">Canada</flux:select.option>
                            <flux:select.option value="US">United States</flux:select.option>
                            <flux:select.option value="ES">Spain</flux:select.option>
                            <flux:select.option value="CN">China</flux:select.option>
                        </flux:select>
                    </flux:field>

                </div>

                <!-- Phone -->
                <div class="w-full sm:flex-1">

                    <flux:field>
                        <flux:label>Phone Number</flux:label>
                        <flux:input name="phone" wire:model="phone" type="tel" placeholder="123-456-7890"
                            :value="old('phone')" required autocomplete="tel" />
                    </flux:field>
                </div>

            </div>

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer"
                                wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:settings.delete-user-form />
        @endif
    </x-settings.layout>
</section>
