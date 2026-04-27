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
</head>
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
            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-white hover:bg-crm-bg3 group' }}">
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
                <a href="{{ route($prefix.'projects.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'projects.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-white hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'projects.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    Projects
                </a>
            @endif

            <!-- Tasks Link -->
            @if(Route::has($prefix.'tasks.index'))
                <a href="{{ route($prefix.'tasks.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'tasks.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-white hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'tasks.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Tasks
                </a>
            @endif
            
            <!-- Tickets Link -->
            @if(Route::has($prefix.'tickets.index'))
                <a href="{{ route($prefix.'tickets.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'tickets.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-white hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'tickets.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    Tickets
                </a>
            @endif

            <!-- Categories Link -->
            @if(Route::has($prefix.'categories.index'))
                <a href="{{ route($prefix.'categories.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'categories.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-white hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'categories.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Categories
                </a>
            @endif

            <!-- Meetings Link -->
            @if(Route::has($prefix.'meetings.index'))
                <a href="{{ route($prefix.'meetings.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'meetings.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-white hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'meetings.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Meetings
                </a>
            @endif

            <!-- Reclamations Link -->
            @if(Route::has($prefix.'reclamations.index'))
                <a href="{{ route($prefix.'reclamations.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'reclamations.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-white hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'reclamations.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Reclamations
                </a>
            @endif

            <!-- Users Link (Admin Only) -->
            @if(Route::has($prefix.'users.index') && auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route($prefix.'users.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'users.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-white hover:bg-crm-bg3 group' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix.'users.*') ? '' : 'text-crm-muted group-hover:text-crm-accent transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-1a3 3 0 00-5.356-1.857M17 20H7m10 0v-1c0-.656-.126-1.283-.356-1.857M7 20H2v-1a3 3 0 015.356-1.857M7 20v-1c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path></svg>
                    Users
                </a>
            @endif

            <!-- Roles Link (Admin Only) -->
            @if(Route::has($prefix.'roles.index') && auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route($prefix.'roles.index') }}" class="flex items-center px-3 py-2.5 rounded-crm font-medium transition-colors {{ request()->routeIs($prefix.'roles.*') ? 'bg-crm-accent/10 text-crm-accent' : 'text-crm-muted hover:text-white hover:bg-crm-bg3 group' }}">
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

                <!-- Notifications -->
                <button class="text-crm-muted hover:text-crm-accent transition-colors relative focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-crm-bg2"></span>
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
            <!-- Slot for page specific content -->
            @yield('content')
        </main>
    </div>

</body>
</html>