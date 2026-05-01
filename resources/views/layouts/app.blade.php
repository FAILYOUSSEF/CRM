<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CRM Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style id="crm-wrap-fix">
        main, main * { min-width: 0; }
        main p, main dd, main td, main textarea, .break-anywhere {
            overflow-wrap: anywhere !important;
            word-break: break-word !important;
        }
        main textarea {
            max-width: 100% !important;
            overflow-x: hidden !important;
            resize: vertical;
            white-space: pre-wrap;
        }
    </style></head>
<body class="font-sans text-crm-text antialiased bg-crm-bg selection:bg-crm-accent selection:text-white flex h-screen overflow-hidden" 
      x-data="{ 
          sidebarOpen: false,
          darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
      }" 
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
    
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-black/50 md:hidden" @click="sidebarOpen = false" style="display: none;"></div>
    
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 w-sidebar bg-crm-bg2 border-r border-crm-border flex flex-col z-30 transition-transform duration-300 md:relative md:translate-x-0">
        
        <!-- Logo Area -->
        <div class="h-topbar flex items-center px-6 border-b border-crm-border shrink-0">
            <div class="w-8 h-8 bg-gradient-to-br from-crm-accent to-indigo-600 rounded-crm flex items-center justify-center shadow-lg mr-3">
                <svg class="w-4 h-4 text-crm-text" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </div>
            <span class="text-xl font-bold text-crm-text tracking-wider">CRM<span class="text-crm-accent">.</span></span>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            
            <!-- Dashboard Link (Dynamic Active State) -->
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-crm-accent hover:bg-crm-bg3 group' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>

            @php
                // Determine the route prefix based on user role (e.g., 'admin.', 'employee.', 'client.')
                $prefix = '';
                if (auth()->check()) {
                    if (auth()->user()->isAdmin()) $prefix = 'admin.';
                    elseif (auth()->user()->isEmployee()) $prefix = 'employee.';
                    elseif (auth()->user()->isClient()) $prefix = 'client.';
                }
            @endphp

            <!-- Projects Link -->
            @if(Route::has($prefix.'projects.index'))
                <a href="{{ route($prefix.'projects.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'projects.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-crm-accent hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'projects.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    Projects
                </a>
            @endif

            <!-- Tasks Link -->
            @if(Route::has($prefix.'tasks.index'))
                <a href="{{ route($prefix.'tasks.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'tasks.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-crm-accent hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'tasks.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Tasks
                </a>
            @endif
            
            <!-- Tickets Link -->
            @if(Route::has($prefix.'tickets.index'))
                <a href="{{ route($prefix.'tickets.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'tickets.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-crm-accent hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'tickets.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    Tickets
                </a>
            @endif

            <!-- Categories Link -->
            @if(Route::has($prefix.'categories.index'))
                <a href="{{ route($prefix.'categories.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'categories.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-crm-accent hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'categories.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Categories
                </a>
            @endif

            <!-- Meetings Link -->
            @if(Route::has($prefix.'meetings.index'))
                <a href="{{ route($prefix.'meetings.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'meetings.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-crm-accent hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'meetings.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Meetings
                </a>
            @endif

            <!-- Reclamations Link -->
            @if(Route::has($prefix.'reclamations.index'))
                <a href="{{ route($prefix.'reclamations.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'reclamations.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-crm-accent hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'reclamations.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Reclamations
                </a>
            @endif

            <!-- Users Link (Admin Only) -->
            @if(Route::has($prefix.'users.index') && auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route($prefix.'users.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'users.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-crm-accent hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'users.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-1a3 3 0 00-5.356-1.857M17 20H7m10 0v-1c0-.656-.126-1.283-.356-1.857M7 20H2v-1a3 3 0 015.356-1.857M7 20v-1c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path></svg>
                    Users
                </a>
            @endif

            <!-- Roles Link (Admin Only) -->
            @if(Route::has($prefix.'roles.index') && auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route($prefix.'roles.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'roles.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-crm-accent hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'roles.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048 4 4 0 010-8.048M3 8H1m8-6v2m8 0v-2m5 6h2M9 20H7a4 4 0 01-4-4v-3h4m0 0h4m-4 0v4m8-4a4 4 0 01 4 4v3h-4m0 0h-4m0 0v-4"></path></svg>
                    Roles
                </a>
            @endif
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- Topbar -->
        <header class="h-topbar bg-crm-bg2 border-b border-crm-border flex items-center justify-between px-6 z-10 shadow-sm shrink-0">
            
            <!-- Mobile Menu Button -->
            <button @click="sidebarOpen = true" class="md:hidden text-crm-muted hover:text-crm-text focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Search Bar -->
            <div class="hidden sm:flex items-center flex-1 ml-4 md:ml-0">
                <div class="relative w-full max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-crm-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Search..." class="block w-full pl-10 pr-3 py-2 border border-transparent rounded-crm bg-crm-bg3 text-sm placeholder-crm-muted text-crm-text focus:outline-none focus:bg-crm-bg3 focus:border-crm-border focus:ring-1 focus:ring-crm-accent sm:text-sm transition-colors">
                </div>
            </div>

            <!-- Right Side Topbar Actions -->
            <div class="flex items-center space-x-4 ml-4">
                
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="text-crm-muted hover:text-crm-accent transition-colors focus:outline-none" title="Toggle Light/Dark Mode">
                    <!-- Sun Icon (shows in Dark Mode) -->
                    <svg x-show="darkMode" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon Icon (shows in Light Mode) -->
                    <svg x-show="!darkMode" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative pl-4 border-l border-crm-border" x-data="{ profileOpen: false }" @click.outside="profileOpen = false">
                    <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 cursor-pointer focus:outline-none w-full text-left">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-crm-text">{{ Auth::user()->name ?? 'User Name' }}</p>
                            <p class="text-xs text-crm-muted capitalize">{{ Auth::user()->type_client ?? 'Admin' }}</p>
                        </div>
                        <div class="h-9 w-9 rounded-full bg-crm-accent flex items-center justify-center text-white font-bold shadow-sm shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="profileOpen" x-transition.opacity.duration.200ms class="absolute right-0 mt-3 w-48 bg-crm-bg2 border border-crm-border rounded-crm shadow-xl py-1 z-50" style="display: none;">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-crm-muted hover:text-crm-text hover:bg-crm-bg3 transition-colors">Profile</a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-400/10 transition-colors">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Page Content -->
        <main class="flex-1 overflow-y-auto bg-crm-bg p-6">
            <div data-flash-alerts class="fixed right-6 top-20 z-50 w-full max-w-sm space-y-3">
                @foreach (['success' => 'green', 'error' => 'red', 'warning' => 'yellow', 'status' => 'blue'] as $flashKey => $flashColor)
                    @if (session($flashKey))
                        <div data-flash-alert class="rounded-crm border bg-crm-surface px-4 py-3 shadow-xl transition-all duration-300
                            {{ $flashColor === 'green' ? 'border-green-500/30 text-green-500' : '' }}
                            {{ $flashColor === 'red' ? 'border-red-500/30 text-red-500' : '' }}
                            {{ $flashColor === 'yellow' ? 'border-yellow-500/30 text-yellow-500' : '' }}
                            {{ $flashColor === 'blue' ? 'border-blue-500/30 text-blue-500' : '' }}">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full
                                    {{ $flashColor === 'green' ? 'bg-green-500/10' : '' }}
                                    {{ $flashColor === 'red' ? 'bg-red-500/10' : '' }}
                                    {{ $flashColor === 'yellow' ? 'bg-yellow-500/10' : '' }}
                                    {{ $flashColor === 'blue' ? 'bg-blue-500/10' : '' }}">
                                    @if ($flashColor === 'green')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    @elseif ($flashColor === 'red')
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" /></svg>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold capitalize">{{ $flashKey === 'status' ? 'Notice' : $flashKey }}</p>
                                    <p class="mt-0.5 text-sm text-crm-text break-anywhere">{{ session($flashKey) }}</p>
                                </div>
                                <button type="button" data-flash-close class="rounded-crm p-1 text-crm-muted hover:bg-crm-bg3 hover:text-crm-text" aria-label="Close alert">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>
                    @endif
                @if ($errors->any())
                    <div data-flash-alert class="rounded-crm border border-red-500/30 bg-crm-surface px-4 py-3 text-red-500 shadow-xl transition-all duration-300">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-500/10">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold">Please check the form</p>
                                <p class="mt-0.5 text-sm text-crm-text">Some fields need your attention.</p>
                            </div>
                            <button type="button" data-flash-close class="rounded-crm p-1 text-crm-muted hover:bg-crm-bg3 hover:text-crm-text" aria-label="Close alert">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                @endif                @endforeach
            </div>

            <!-- Slot for page specific content -->
            @yield('content')
        </main>
    </div>

    <div data-confirm-modal class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 px-4 py-6" aria-hidden="true">
        <div data-confirm-backdrop class="absolute inset-0"></div>
        <div class="relative w-full max-w-md rounded-crm border border-crm-border bg-crm-bg2 shadow-2xl">
            <div class="flex items-start gap-4 p-6">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-500/10 text-red-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="text-lg font-bold text-crm-text">Confirm action</h2>
                    <p data-confirm-message class="mt-2 text-sm leading-6 text-crm-muted">Are you sure?</p>
                </div>
                <button type="button" data-confirm-cancel class="rounded-crm p-1 text-crm-muted hover:bg-crm-bg3 hover:text-crm-text" aria-label="Cancel">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="flex justify-end gap-3 border-t border-crm-border px-6 py-4">
                <button type="button" data-confirm-cancel class="rounded-crm border border-crm-border px-4 py-2 text-sm font-semibold text-crm-muted transition-colors hover:bg-crm-bg3 hover:text-crm-text">Cancel</button>
                <button type="button" data-confirm-ok class="rounded-crm bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-red-600/20 transition-colors hover:bg-red-500">Delete</button>
            </div>
        </div>
    </div>

    <div data-create-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 px-4 py-6 sm:px-6" aria-hidden="true">
        <div data-create-modal-backdrop class="absolute inset-0"></div>
        <div class="relative w-full max-w-4xl max-h-[90vh] overflow-hidden rounded-crm border border-crm-border bg-crm-bg shadow-2xl">
            <div class="flex items-center justify-between border-b border-crm-border bg-crm-bg2 px-5 py-4">
                <h2 data-create-modal-title class="text-lg font-bold text-crm-text">Create</h2>
                <button type="button" data-create-modal-close class="rounded-crm p-2 text-crm-muted transition-colors hover:bg-crm-bg3 hover:text-crm-text" aria-label="Close popup">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div data-create-modal-body class="max-h-[calc(90vh-4rem)] overflow-y-auto p-6"></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const setupFlashAlerts = () => {
                document.querySelectorAll('[data-flash-alert]').forEach((alert) => {
                    const close = alert.querySelector('[data-flash-close]');
                    const dismiss = () => {
                        alert.classList.add('translate-x-6', 'opacity-0');
                        setTimeout(() => alert.remove(), 300);
                    };
                    close?.addEventListener('click', dismiss);
                    setTimeout(dismiss, 4500);
                });
            };

            const setupStyledConfirm = () => {
                const confirmModal = document.querySelector('[data-confirm-modal]');
                const confirmMessage = document.querySelector('[data-confirm-message]');
                const confirmOk = document.querySelector('[data-confirm-ok]');
                const confirmCancel = document.querySelectorAll('[data-confirm-cancel], [data-confirm-backdrop]');
                let pendingForm = null;

                if (!confirmModal || !confirmMessage || !confirmOk) return;

                const readConfirmMessage = (form) => {
                    const inline = form.getAttribute('onsubmit') || '';
                    const match = inline.match(/confirm\((['"])(.*?)\1\)/);
                    return form.dataset.confirmMessage || (match ? match[2] : 'Are you sure?');
                };

                document.querySelectorAll('form[onsubmit*="confirm"]').forEach((form) => {
                    form.dataset.confirmMessage = readConfirmMessage(form);
                    form.removeAttribute('onsubmit');
                });

                const closeConfirm = () => {
                    confirmModal.classList.add('hidden');
                    confirmModal.classList.remove('flex');
                    confirmModal.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('overflow-hidden');
                    pendingForm = null;
                };

                document.addEventListener('submit', (event) => {
                    const form = event.target.closest('form[data-confirm-message]');
                    if (!form || form.dataset.confirmApproved === 'true') return;

                    event.preventDefault();
                    pendingForm = form;
                    confirmMessage.textContent = form.dataset.confirmMessage || 'Are you sure?';
                    confirmOk.textContent = confirmMessage.textContent.toLowerCase().includes('delete') ? 'Delete' : 'Confirm';
                    confirmModal.classList.remove('hidden');
                    confirmModal.classList.add('flex');
                    confirmModal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('overflow-hidden');
                }, true);

                confirmOk.addEventListener('click', () => {
                    if (!pendingForm) return;
                    const form = pendingForm;
                    form.dataset.confirmApproved = 'true';
                    closeConfirm();
                    form.submit();
                });

                confirmCancel.forEach((button) => button.addEventListener('click', closeConfirm));
                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && !confirmModal.classList.contains('hidden')) closeConfirm();
                });
            };

            setupFlashAlerts();
            setupStyledConfirm();
            const modal = document.querySelector('[data-create-modal]');
            const title = document.querySelector('[data-create-modal-title]');
            const body = document.querySelector('[data-create-modal-body]');
            const closeButtons = document.querySelectorAll('[data-create-modal-close], [data-create-modal-backdrop]');

            if (!modal || !body || !title) return;

            const openModal = () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
                body.innerHTML = '';
            };

            const isCreateLink = (link) => {
                if (!link || !link.href) return false;
                const url = new URL(link.href, window.location.origin);
                if (url.origin !== window.location.origin) return false;
                return /\/(create|request)\/?$/.test(url.pathname);
            };

            const prepareModalContent = (fragment) => {
                const pageTitle = fragment.querySelector('h1');
                title.textContent = pageTitle ? pageTitle.textContent.trim() : 'Create';

                fragment.querySelectorAll('a').forEach((link) => {
                    const label = link.textContent.trim().toLowerCase();
                    if (label === 'cancel' || label === 'back') {
                        link.setAttribute('href', '#');
                        link.addEventListener('click', (event) => {
                            event.preventDefault();
                            closeModal();
                        });
                    }
                });

                fragment.querySelectorAll('[class*="max-w-3xl"]').forEach((panel) => {
                    panel.classList.remove('max-w-3xl');
                });

                return fragment.innerHTML;
            };

            document.addEventListener('click', async (event) => {
                const link = event.target.closest('a');
                if (!isCreateLink(link)) return;

                event.preventDefault();
                title.textContent = link.textContent.trim().replace(/^\+\s*/, '') || 'Create';
                body.innerHTML = '<div class="py-10 text-center text-sm text-crm-muted">Loading...</div>';
                openModal();

                try {
                    const response = await fetch(link.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    });

                    if (!response.ok) throw new Error('Unable to load form');

                    const html = await response.text();
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    const main = doc.querySelector('main') || doc.body;
                    body.innerHTML = prepareModalContent(main.cloneNode(true));
                } catch (error) {
                    window.location.href = link.href;
                }
            });

            body.addEventListener('submit', (event) => {
                const form = event.target.closest('form');
                if (!form) return;

                const submitButton = form.querySelector('[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-70', 'cursor-wait');
                }
            });
            closeButtons.forEach((button) => button.addEventListener('click', closeModal));
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });
        });
    </script>
</body>
</html>
