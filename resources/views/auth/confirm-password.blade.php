<x-guest-layout>
    <div class="mb-6 text-sm text-crm-muted text-center leading-relaxed">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-crm-muted mb-1">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-crm text-sm font-bold text-white bg-crm-accent hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-crm-surface focus:ring-crm-accent shadow-lg shadow-crm-accent/30 transition-all duration-200 transform hover:-translate-y-0.5">
                {{ __('Confirm Password') }}
            </button>
        </div>
        
        <div class="text-center">
            <a class="text-sm font-medium text-crm-muted hover:text-crm-text transition-colors" href="{{ url()->previous() }}">Cancel</a>
        </div>
    </form>
</x-guest-layout>
