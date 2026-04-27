@extends('layouts.app')
@section('title','My Projects')
@section('content')
<h1 class="text-2xl font-bold text-crm-text tracking-tight mb-6">My Projects</h1>
<div class="grid gap-4">
    @forelse($projects as $project)
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6 group hover:border-crm-accent/50 transition-colors">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="font-semibold text-crm-text text-lg group-hover:text-crm-accent transition-colors">{{ $project->titre }}</h2>
                <p class="text-sm text-crm-muted mt-1">{{ $project->client?->name ?? 'N/A' }}</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-medium border
                {{ $project->status === 'en cours' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 
                  ($project->status === 'terminé' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-crm-bg3 text-crm-muted border-crm-border') }}">
                {{ $project->status }}
            </span>
        </div>
        @if($project->description)
            <p class="text-sm text-crm-muted mb-4">{{ $project->description }}</p>
        @endif
        <div class="flex gap-2">
            <a href="{{ route('employee.projects.show', $project) }}" class="text-crm-accent hover:text-blue-400 transition-colors font-medium text-sm">View Details →</a>
        </div>
    </div>
    @empty
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-12 text-center">
        <p class="text-crm-muted">No projects assigned.</p>
    </div>
    @endforelse
</div>
@endsection
