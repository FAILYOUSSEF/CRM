@extends('layouts.app')
@section('title','My Projects')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-crm-text tracking-tight mb-4">My Projects</h1>
    <form method="GET" action="{{ route('client.projects.index') }}" class="flex gap-3">
        <input type="text" name="search" placeholder="Search projects..." value="{{ request('search') }}" 
            class="flex-1 px-4 py-2 border border-crm-border bg-crm-bg3 rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all">
        <button type="submit" class="px-6 py-2 bg-crm-accent text-white rounded-crm hover:bg-blue-500 transition-colors font-medium">
            Search
        </button>
    </form>
</div>

<div class="grid gap-6">
    @forelse($projects as $project)
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div class="flex-1">
                <a href="{{ route('client.projects.show', $project) }}" class="block group">
                    <h2 class="text-xl font-bold text-crm-text group-hover:text-crm-accent transition-colors">
                        {{ $project->titre }}
                    </h2>
                </a>
                
                <p class="text-sm text-crm-muted mt-2 flex items-center gap-2 font-medium">
                    {{ $project->date_debut ?? 'TBD' }} — {{ $project->date_fin ?? 'TBD' }}
                </p>

                @if($project->description)
                <p class="mt-3 text-sm text-crm-muted line-clamp-2">{{ $project->description }}</p>
                @endif

                <!-- Progress Bar -->
                <div class="mt-4">
                    <div class="flex justify-between text-xs font-semibold text-crm-muted mb-1">
                        <span>Progress</span>
                        <span>{{ $project->progress ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-crm-bg3 rounded-full h-2 overflow-hidden border border-crm-border">
                        <div class="bg-crm-accent h-2 rounded-full transition-all" style="width: {{ $project->progress ?? 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 md:items-end md:justify-between md:h-full shrink-0">
                <!-- Status Badge -->
                <span class="px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase whitespace-nowrap border
                    {{ $project->status === 'terminé' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 
                       ($project->status === 'en cours' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 
                       'bg-crm-bg3 text-crm-muted border-crm-border') }}">
                    {{ $project->status }}
                </span>

                <!-- View Details Button -->
                <a href="{{ route('client.projects.show', $project) }}" 
                    class="px-4 py-2 bg-crm-accent text-white rounded-crm hover:bg-blue-500 transition-colors text-sm font-medium text-center">
                    View Details
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-12 text-center">
        <p class="text-crm-muted text-lg">No projects yet. You'll see your projects here once they're assigned.</p>
    </div>
    @endforelse
</div>

@if($projects->hasPages())
<div class="mt-8">
    {{ $projects->links() }}
</div>
@endif

@endsection
