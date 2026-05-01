<x-guest-layout>
    <div class="mb-6 text-sm text-crm-muted leading-relaxed text-center">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 font-medium text-sm text-green-400 bg-green-400/10 p-3 rounded-crm border border-green-400/20 text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-crm-muted mb-1">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
        </div>

        <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-crm text-sm font-bold text-white bg-crm-accent hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-crm-surface focus:ring-crm-accent shadow-lg shadow-crm-accent/30 transition-all duration-200 transform hover:-translate-y-0.5">
            {{ __('Email Password Reset Link') }}
        </button>
        
        <div class="text-center mt-4">
            <a class="text-sm font-medium text-crm-muted hover:text-crm-text transition-colors" href="{{ route('login') }}">
                Back to login
            </a>
        </div>
    </form>
</x-guest-layout>
