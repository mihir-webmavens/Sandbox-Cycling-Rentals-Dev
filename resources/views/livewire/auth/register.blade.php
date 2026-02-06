<x-layouts::auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!--First Name -->
            <flux:input name="first_name" :label="__('First Name')" type="text" :value="old('first_name')" required
                autofocus autocomplete="first_name" :placeholder="__('First Name')" />

            <!-- Last name -->
            <flux:input name="last_name" :label="__('Last Name')" type="text" :value="old('last_name')" required
                autofocus autocomplete="last_name" :placeholder="__('Last Name')" />
            <!-- Phone -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end ">

                <!-- Country -->
                <div class="w-full sm:w-1/4">

                    <flux:field>
                        <flux:label>Country</flux:label>
                        <flux:select name="country">
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
                    {{-- <flux:input name="phone" :label="__('Phone Number')" type="text" :value="old('phone')" required
                        autocomplete="tel" :placeholder="__('Phone Number')" /> --}}

                        <flux:field>
                            <flux:label>Phone Number</flux:label>
                            <flux:input name="phone" type="tel" placeholder="123-456-7890" :value="old('phone')" required autocomplete="tel"/>
                        </flux:field>
                </div>

            </div>
            <flux:error name="phone" />
            <flux:error name="country" />

            <!-- Email Address -->
            <flux:input name="email" :label="__('Email address')" :value="old('email')" type="email" required
                autocomplete="email" placeholder="email@example.com" />

            <!-- Password -->
            <flux:input name="password" :label="__('Password')" type="password" required autocomplete="new-password"
                :placeholder="__('Password')" viewable />

            <!-- Confirm Password -->
            <flux:input name="password_confirmation" :label="__('Confirm password')" type="password" required
                autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>