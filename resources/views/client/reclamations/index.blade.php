@extends('layouts.app')

@section('title', 'My Reclamations')

@section('content')

<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">My Reclamations</h1>
        <p class="text-sm text-crm-muted mt-1">Submit and track your complaints and requests</p>
    </div>
    <a href="{{ route('client.reclamations.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-blue-500 transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        New Reclamation
    </a>
</div>

<!-- Dashboard Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-crm-surface border border-crm-border rounded-crm p-4 shadow-sm">
        <p class="text-sm font-medium text-crm-muted mb-1">Total Reclamations</p>
        <h3 class="text-2xl font-bold text-crm-text">{{ $reclamations->total() }}</h3>
    </div>
    <div class="bg-crm-surface border border-crm-border rounded-crm p-4 shadow-sm">
        <p class="text-sm font-medium text-crm-muted mb-1">Pending</p>
        <h3 class="text-2xl font-bold text-yellow-400">{{ $reclamations->where('status', 'en attente')->count() }}</h3>
    </div>
    <div class="bg-crm-surface border border-crm-border rounded-crm p-4 shadow-sm">
        <p class="text-sm font-medium text-crm-muted mb-1">Resolved</p>
        <h3 class="text-2xl font-bold text-green-400">{{ $reclamations->where('status', 'résolu')->count() }}</h3>
    </div>
    <div class="bg-crm-surface border border-crm-border rounded-crm p-4 shadow-sm">
        <p class="text-sm font-medium text-crm-muted mb-1">High Priority</p>
        <h3 class="text-2xl font-bold text-red-400">{{ $reclamations->where('priorite', 'haute')->count() }}</h3>
    </div>
</div>

<!-- Faceted Filter -->
<div x-data="filterPanel()" class="bg-crm-surface border border-crm-border rounded-crm shadow-sm mb-6">
    <!-- Header with Toggle -->
    <div class="px-5 py-4 border-b border-crm-border flex items-center justify-between cursor-pointer" @click="open = !open">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-crm-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <h3 class="font-semibold text-crm-text">Advanced Filters</h3>
            <span x-show="activeFiltersCount > 0" class="bg-crm-accent text-white text-xs px-2.5 py-1 rounded-full font-bold" x-text="activeFiltersCount"></span>
        </div>
        <svg class="w-5 h-5 text-crm-muted transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>

    <!-- Filter Content -->
    <div x-show="open" x-transition class="p-5 space-y-6">
        <form method="GET" action="{{ route('client.reclamations.index') }}" id="filterForm" class="space-y-6">
            <!-- Search Input -->
            <div>
                <label class="block text-sm font-medium text-crm-text mb-2">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by title or description..."
                       class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors placeholder-crm-muted" />
            </div>

            <!-- Filters Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-crm-text mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status
                    </label>
                    <select name="status" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                        <option value="">— All Status —</option>
                        @foreach($filterOptions['status'] ?? [] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Priority Filter -->
                <div>
                    <label class="block text-sm font-medium text-crm-text mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Priority
                    </label>
                    <select name="priorite" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                        <option value="">— All Priorities —</option>
                        @foreach($filterOptions['priority'] ?? [] as $priority)
                            <option value="{{ $priority }}" {{ request('priorite') == $priority ? 'selected' : '' }}>
                                {{ ucfirst($priority) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-crm-text mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Type
                    </label>
                    <select name="type" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                        <option value="">— All Types —</option>
                        @foreach($filterOptions['types'] ?? [] as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Date Range -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-crm-text mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        From Date
                    </label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-crm-text mb-2">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors" />
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex gap-3 pt-4 border-t border-crm-border">
                <button type="submit" class="flex-1 bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-blue-500 transition-colors font-medium text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Apply Filters
                </button>
                <a href="{{ route('client.reclamations.index') }}" class="flex-1 bg-crm-bg3 text-crm-muted px-4 py-2.5 rounded-crm hover:bg-crm-bg2 transition-colors font-medium text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Results Info Bar -->
<div class="bg-crm-bg3 border border-crm-border rounded-crm px-5 py-3 mb-4 flex items-center justify-between">
    <div class="text-sm text-crm-muted">
        Showing <span class="font-semibold text-crm-text">{{ $reclamations->count() }}</span> of <span class="font-semibold text-crm-text">{{ $reclamations->total() }}</span> reclamations
        @if(request()->hasAny(['search', 'status', 'priorite', 'type', 'date_from', 'date_to']))
            <span class="ml-2 text-crm-accent">with active filters</span>
        @endif
    </div>
</div>

<!-- Reclamations Grid -->
<div class="space-y-4 mb-6">
    @forelse($reclamations as $rec)
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6 group hover:border-crm-accent/50 transition-colors">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <a href="{{ route('client.reclamations.show', $rec->id) }}" class="font-semibold text-lg text-crm-text group-hover:text-crm-accent transition-colors">{{ $rec->titre }}</a>
                <p class="text-sm text-crm-muted mt-2 space-y-1">
                    <span class="block">{{ $rec->date ?? 'N/A' }} &mdash; <strong>Type:</strong> {{ ucfirst($rec->type ?? 'General') }}</span>
                </p>
            </div>
            <div class="flex flex-col gap-2 items-end">
                <span class="px-2.5 py-1 rounded-full text-xs font-medium border 
                    {{ $rec->status === 'résolu' ? 'bg-green-500/10 text-green-400 border-green-500/20' :
                      ($rec->status === 'traité' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' :
                        'bg-yellow-500/10 text-yellow-400 border-yellow-500/20') }}">
                    {{ ucfirst($rec->status) }}
                </span>
                <span class="px-2.5 py-1 rounded text-xs font-medium
                    {{ $rec->priorite === 'haute' ? 'bg-red-500/10 text-red-400' :
                      ($rec->priorite === 'moyenne' ? 'bg-yellow-500/10 text-yellow-400' :
                        'bg-green-500/10 text-green-400') }}">
                    {{ ucfirst($rec->priorite) }}
                </span>
            </div>
        </div>

        @if($rec->response)
            <div class="bg-green-500/10 border border-green-500/20 rounded-crm p-4 text-sm text-green-400 mb-4">
                <strong class="block text-green-300 mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Support Reply
                </strong>
                <p>{{ $rec->response }}</p>
            </div>
        @endif

        <a href="{{ route('client.reclamations.show', $rec->id) }}" class="inline-flex items-center gap-2 text-crm-accent hover:text-blue-400 transition-colors text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            View Details
        </a>
    </div>
    @empty
    <div class="bg-crm-surface border-2 border-dashed border-crm-border rounded-crm p-12 text-center">
        <svg class="w-12 h-12 mx-auto text-crm-muted/30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <p class="text-crm-muted font-medium text-lg mb-3">No reclamations submitted yet.</p>
        <a href="{{ route('client.reclamations.create') }}" class="text-crm-accent font-medium hover:text-blue-400 transition-colors inline-block text-sm">Create your first reclamation →</a>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $reclamations->links() }}
</div>

<script>
function filterPanel() {
    return {
        open: @js(request()->hasAny(['search', 'status', 'priorite', 'type', 'date_from', 'date_to'])),
        get activeFiltersCount() {
            return [
                '{{ request("search") }}',
                '{{ request("status") }}',
                '{{ request("priorite") }}',
                '{{ request("type") }}',
                '{{ request("date_from") }}',
                '{{ request("date_to") }}'
            ].filter(v => v).length;
        }
    }
}
</script>

@endsection