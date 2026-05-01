<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-crm-text mb-2">Create an account</h2>
        <p class="text-sm text-crm-muted">Enter your details to register.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-crm-muted mb-1">{{ __('Name') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-xs" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-crm-muted mb-1">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-crm-muted mb-1">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-crm-muted mb-1">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div class="flex items-center justify-between pt-4">
            <a class="text-sm font-medium text-crm-accent hover:text-blue-400 transition-colors focus:outline-none focus:underline" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="inline-flex justify-center items-center py-2 px-6 border border-transparent rounded-crm text-sm font-bold text-white bg-crm-accent hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-crm-surface focus:ring-crm-accent shadow-lg shadow-crm-accent/30 transition-all duration-200 transform hover:-translate-y-0.5">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
