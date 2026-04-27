<x-guest-layout>
    <div class="mb-6 text-sm text-crm-muted leading-relaxed text-center">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 font-medium text-sm text-green-400 bg-green-400/10 p-3 rounded-crm border border-green-400/20 text-center">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            
            <button type="submit" class="flex justify-center items-center py-2.5 px-6 border border-transparent rounded-crm text-sm font-bold text-white bg-crm-accent hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-crm-surface focus:ring-crm-accent shadow-lg shadow-crm-accent/30 transition-all duration-200 transform hover:-translate-y-0.5">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm font-medium text-crm-muted hover:text-crm-text transition-colors focus:outline-none focus:underline">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
