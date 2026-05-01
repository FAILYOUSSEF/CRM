@extends('layouts.app')

@section('content')
    <!-- Header with Stats -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-crm-text tracking-tight">Projects</h1>
            <p class="text-sm text-crm-muted mt-1">Manage and track all your projects</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-black transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Project
        </a>
    </div>

    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-crm-surface border border-crm-border rounded-crm p-4 shadow-sm">
            <p class="text-sm font-medium text-crm-muted mb-1">Total Projects</p>
            <h3 class="text-2xl font-bold text-crm-text">{{ $projects->total() }}</h3>
        </div>
        <div class="bg-crm-surface border border-crm-border rounded-crm p-4 shadow-sm">
            <p class="text-sm font-medium text-crm-muted mb-1">In Progress</p>
            <h3 class="text-2xl font-bold text-blue-400">{{ $projects->where('status', 'en cours')->count() }}</h3>
        </div>
        <div class="bg-crm-surface border border-crm-border rounded-crm p-4 shadow-sm">
            <p class="text-sm font-medium text-crm-muted mb-1">Completed</p>
            <h3 class="text-2xl font-bold text-green-400">{{ $projects->where('status', 'terminé')->count() }}</h3>
        </div>
        <div class="bg-crm-surface border border-crm-border rounded-crm p-4 shadow-sm">
            <p class="text-sm font-medium text-crm-muted mb-1">Cancelled</p>
            <h3 class="text-2xl font-bold text-red-400">{{ $projects->where('status', 'annulé')->count() }}</h3>
        </div>
    </div>

    <!-- Faceted Filter Component -->
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
            <form method="GET" action="{{ route('admin.projects.index') }}" id="filterForm" class="space-y-6">
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

                    <!-- Client Filter -->
                    <div>
                        <label class="block text-sm font-medium text-crm-text mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zM7 10a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                            Client
                        </label>
                        <select name="client_id" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                            <option value="">— All Clients —</option>
                            @foreach($filterOptions['clients'] ?? [] as $id => $name)
                                <option value="{{ $id }}" {{ request('client_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div>
                        <label class="block text-sm font-medium text-crm-text mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date Range
                        </label>
                        <div class="flex gap-2">
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="flex-1 bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors" />
                            <span class="text-crm-muted flex items-center px-2">to</span>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="flex-1 bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors" />
                        </div>
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex gap-3 pt-4 border-t border-crm-border">
                    <button type="submit" class="flex-1 bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-black transition-colors font-medium text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="flex-1 bg-crm-bg3 text-crm-muted px-4 py-2.5 rounded-crm hover:bg-crm-bg2 transition-colors font-medium text-sm flex items-center justify-center gap-2">
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
            Showing <span class="font-semibold text-crm-text">{{ $projects->count() }}</span> of <span class="font-semibold text-crm-text">{{ $projects->total() }}</span> projects
            @if(request()->hasAny(['search', 'status', 'priorite', 'client_id', 'date_from', 'date_to']))
                <span class="ml-2 text-crm-accent">with active filters</span>
            @endif
        </div>
        <div class="text-xs text-crm-muted">
            Page {{ $projects->currentPage() }} of {{ $projects->lastPage() }}
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-crm-bg2 border-b border-crm-border text-crm-muted uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Client</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Priority</th>
                    <th class="px-6 py-4">Progress</th>
                    <th class="px-6 py-4">Deadline</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-crm-border">
                @forelse($projects as $project)
                <tr class="hover:bg-crm-bg3/50 transition-colors group">
                    <td class="px-6 py-4 font-medium text-crm-text">{{ $project->titre }}</td>
                    <td class="px-6 py-4 text-crm-muted">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-crm-bg3 text-crm-text">
                            {{ $project->client?->name ?? '—' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium border
                            {{ $project->status === 'terminé' ? 'bg-green-500/10 text-green-400 border-green-500/20' :
                              ($project->status === 'annulé'  ? 'bg-red-500/10 text-red-400 border-red-500/20' :
                                                                'bg-blue-500/10 text-blue-400 border-blue-500/20') }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium
                            {{ $project->priorite === 'haute' ? 'bg-red-500/10 text-red-400' :
                              ($project->priorite === 'moyenne' ? 'bg-yellow-500/10 text-yellow-400' :
                                                                   'bg-green-500/10 text-green-400') }}">
                            {{ ucfirst($project->priorite) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-crm-bg3 rounded-full h-1.5">
                                <div class="bg-{{ $project->progress_color }}-400 h-1.5 rounded-full" style="width: {{ $project->progress ?? 0 }}%"></div>
                            </div>
                            <span class="text-xs font-medium text-crm-muted">{{ $project->progress ?? 0 }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-crm-muted text-sm">{{ $project->date_fin ? \Carbon\Carbon::parse($project->date_fin)->format('M d, Y') : '—' }}</td>
                    <td class="px-6 py-4 flex justify-end gap-3">
                        <a href="{{ route('admin.projects.show', $project) }}" class="text-crm-muted hover:text-crm-accent transition-colors font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-crm-muted hover:text-yellow-400 transition-colors font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Are you sure you want to delete this project?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-crm-muted hover:text-red-400 transition-colors font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-crm-muted">
                    <div class="space-y-2">
                        <svg class="w-12 h-12 mx-auto text-crm-muted/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="font-medium">No projects found</p>
                        <p class="text-sm">Try adjusting your filters or <a href="{{ route('admin.projects.create') }}" class="text-crm-accent hover:underline">create a new project</a></p>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $projects->links() }}
    </div>
</div>

<script>
function filterPanel() {
    return {
        open: @js(request()->hasAny(['search', 'status', 'priorite', 'client_id', 'date_from', 'date_to'])),
        get activeFiltersCount() {
            return [
                '{{ request("search") }}',
                '{{ request("status") }}',
                '{{ request("priorite") }}',
                '{{ request("client_id") }}',
                '{{ request("date_from") }}',
                '{{ request("date_to") }}'
            ].filter(v => v).length;
        }
    }
}
</script>

@endsection
