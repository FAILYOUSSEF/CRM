@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">{{ $project->titre }}</h1>
        <a href="{{ route('admin.projects.edit', $project) }}" class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-4 py-2.5 rounded-crm hover:bg-yellow-500 hover:text-white transition-all duration-200 shadow-sm text-sm font-bold">
            Edit Project
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Details & Tasks -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Details Card -->
            <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
                <h2 class="font-semibold text-crm-text mb-4 tracking-wide uppercase text-xs">Project Details</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Status</dt><dd class="font-medium text-crm-text">{{ ucfirst($project->status) }}</dd></div>
                    <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Priority</dt><dd class="font-medium text-crm-text">{{ ucfirst($project->priorite) }}</dd></div>
                    <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Budget</dt><dd class="font-medium text-crm-text">{{ $project->budget ? number_format($project->budget,2).' MAD' : '—' }}</dd></div>
                    <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Client</dt><dd class="font-medium text-crm-text">{{ $project->client?->name ?? '—' }}</dd></div>
                    <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Start Date</dt><dd class="font-medium text-crm-text">{{ $project->date_duree ?? '—' }}</dd></div>
                    <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">End Date</dt><dd class="font-medium text-crm-text">{{ $project->date_fin ?? '—' }}</dd></div>
                </dl>
                @if($project->description)
                    <div class="mt-4 pt-4 border-t border-crm-border">
                        <h3 class="text-crm-muted mb-2 text-xs uppercase">Description</h3>
                        <p class="text-sm text-crm-text leading-relaxed">{{ $project->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Tasks Card -->
            <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
                <h2 class="font-semibold text-crm-text mb-4 tracking-wide uppercase text-xs">Tasks ({{ $project->tasks->count() }})</h2>
                <div class="space-y-2">
                    @forelse($project->tasks as $task)
                        <div class="flex items-center justify-between p-3 rounded-crm bg-crm-bg3 border border-crm-border text-sm hover:border-crm-accent/50 transition-colors">
                            <span class="text-crm-text font-medium">{{ $task->titre }}</span>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-crm-accent/10 text-crm-accent border border-crm-accent/20">{{ ucfirst($task->status) }}</span>
                        </div>
                    @empty
                        <p class="text-crm-muted text-sm italic">No tasks assigned to this project yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Team & Tickets -->
        <div class="space-y-6">
            
            <!-- Team Card -->
            <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
                <h2 class="font-semibold text-crm-text mb-4 tracking-wide uppercase text-xs">Assigned Team</h2>
                <div class="space-y-3">
                    @forelse($project->employees as $emp)
                        <div class="flex items-center gap-3 p-2 text-sm">
                            <span class="w-8 h-8 rounded-full bg-crm-accent/20 text-crm-accent border border-crm-accent/30 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ strtoupper(substr($emp->name,0,1)) }}
                            </span>
                            <span class="text-crm-text font-medium">{{ $emp->name }}</span>
                        </div>
                    @empty
                        <p class="text-crm-muted text-sm italic">No employees assigned.</p>
                    @endforelse
                </div>
            </div>

            <!-- Tickets Card -->
            <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
                <h2 class="font-semibold text-crm-text mb-4 tracking-wide uppercase text-xs">Related Tickets ({{ $project->tickets->count() }})</h2>
                <div class="space-y-2">
                    @forelse($project->tickets as $ticket)
                        <div class="text-sm p-3 bg-crm-bg3 rounded-crm border border-crm-border hover:border-crm-accent/50 transition-colors group">
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-crm-text font-medium group-hover:text-crm-accent transition-colors block truncate">
                                {{ $ticket->sujet }}
                            </a>
                        </div>
                    @empty
                        <p class="text-crm-muted text-sm italic">No tickets raised for this project.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
