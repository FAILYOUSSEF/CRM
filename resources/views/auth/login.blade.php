<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CRM - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-crm-text antialiased bg-crm-bg selection:bg-crm-accent selection:text-white">
    <div class="flex min-h-screen">
        
        <!-- Left Side: Branding / Showcase -->
        <div class="hidden lg:flex lg:w-1/2 bg-crm-bg2 relative overflow-hidden items-center justify-center border-r border-crm-border">
            <!-- Abstract Background Elements -->
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-crm-accent/20 blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-500/20 blur-[100px] pointer-events-none"></div>

            <div class="relative z-10 p-12 flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-crm-accent to-indigo-600 rounded-crm-lg flex items-center justify-center shadow-lg shadow-crm-accent/30 mb-8">
                    <svg class="w-12 h-12 text-crm-text" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight text-crm-text sm:text-5xl mb-4">
                    Welcome to CRM
                </h1>
                <p class="text-lg text-crm-muted max-w-md">
                    Manage your projects, tickets, and team collaboration in one unified, powerful workspace.
                </p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative">
            <!-- Mobile Background Elements -->
            <div class="lg:hidden absolute top-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-crm-accent/10 blur-[80px] pointer-events-none"></div>

            <div class="w-full max-w-md z-10 space-y-8">
                
                <!-- Mobile Logo -->
                <div class="text-center lg:hidden mb-8 flex flex-col items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-crm-accent to-indigo-600 rounded-crm flex items-center justify-center shadow-lg mb-4">
                        <svg class="w-8 h-8 text-crm-text" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                <h2 class="text-3xl font-extrabold text-crm-text">CRM</h2>
                </div>

                <!-- Form Card -->
                <div class="bg-crm-surface p-8 sm:p-10 rounded-crm-lg shadow-2xl border border-crm-border">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-crm-text mb-2">Sign in to your account</h2>
                        <p class="text-sm text-crm-muted">Enter your credentials to access the dashboard.</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 font-medium text-sm text-green-400 bg-green-400/10 p-3 rounded-crm border border-green-400/20">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-crm-muted mb-1">{{ __('Email Address') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-crm-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                    class="block w-full pl-10 bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5"
                                    placeholder="admin@example.com" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-crm-muted mb-1">{{ __('Password') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-crm-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="password" type="password" name="password" required autocomplete="current-password"
                                    class="block w-full pl-10 bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5"
                                    placeholder="••••••••" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center cursor-pointer group">
                                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-crm-border text-crm-accent shadow-sm focus:ring-crm-accent focus:ring-offset-0 bg-crm-bg3 group-hover:border-crm-accent transition-colors">
                                <span class="ml-2 text-sm text-crm-muted group-hover:text-crm-text transition-colors">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-crm-accent hover:text-blue-400 transition-colors focus:outline-none focus:underline">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-crm text-sm font-bold text-white bg-crm-accent hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-crm-surface focus:ring-crm-accent shadow-lg shadow-crm-accent/30 transition-all duration-200 transform hover:-translate-y-0.5">
                                {{ __('Log in') }}
                                <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Footer Copyright -->
                <p class="text-center text-xs text-crm-muted mt-8">
                    &copy; {{ date('Y') }} CRM. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
