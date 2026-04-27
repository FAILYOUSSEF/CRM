@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-crm-text tracking-tight">{{ $task->titre }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.tasks.edit', $task) }}" class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-4 py-2.5 rounded-crm hover:bg-yellow-500 hover:text-white transition-all duration-200 text-sm font-bold">Edit Task</a>
                <a href="{{ route('admin.tasks.index') }}" class="bg-gray-500/10 text-gray-400 border border-gray-500/20 px-4 py-2.5 rounded-crm hover:bg-gray-500 hover:text-crm-text transition-all duration-200 text-sm font-bold">Back</a>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Task Details -->
            <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
                <h2 class="font-semibold text-crm-text mb-4 tracking-wide uppercase text-xs">Task Details</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-4">
                    <div class="bg-crm-bg3 p-3 rounded-crm">
                        <dt class="text-crm-muted mb-1 text-xs uppercase">Status</dt>
                        <dd class="font-medium text-crm-text">{{ ucfirst($task->status) }}</dd>
                    </div>
                    <div class="bg-crm-bg3 p-3 rounded-crm">
                        <dt class="text-crm-muted mb-1 text-xs uppercase">Priority</dt>
                        <dd class="font-medium text-crm-text">{{ ucfirst($task->priorite) }}</dd>
                    </div>
                    <div class="bg-crm-bg3 p-3 rounded-crm">
                        <dt class="text-crm-muted mb-1 text-xs uppercase">Start Date</dt>
                        <dd class="font-medium text-crm-text">{{ $task->date_debut ?? '—' }}</dd>
                    </div>
                    <div class="bg-crm-bg3 p-3 rounded-crm">
                        <dt class="text-crm-muted mb-1 text-xs uppercase">End Date</dt>
                        <dd class="font-medium text-crm-text">{{ $task->date_fin ?? '—' }}</dd>
                    </div>
                    <div class="bg-crm-bg3 p-3 rounded-crm">
                        <dt class="text-crm-muted mb-1 text-xs uppercase">Duration</dt>
                        <dd class="font-medium text-crm-text">{{ $task->duree ?? '—' }}</dd>
                    </div>
                    <div class="bg-crm-bg3 p-3 rounded-crm">
                        <dt class="text-crm-muted mb-1 text-xs uppercase">Assigned To</dt>
                        <dd class="font-medium text-crm-text">{{ $task->employee?->name ?? '—' }}</dd>
                    </div>
                    <div class="bg-crm-bg3 p-3 rounded-crm">
                        <dt class="text-crm-muted mb-1 text-xs uppercase">Project</dt>
                        <dd class="font-medium text-crm-text">
                            @if($task->project)
                                <a href="{{ route('admin.projects.show', $task->project) }}" class="text-crm-accent hover:text-blue-400 transition-colors">{{ $task->project->titre }}</a>
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                </dl>

                @if($task->description)
                <div class="mt-4 pt-4 border-t border-crm-border">
                    <h3 class="text-crm-muted mb-2 text-xs uppercase">Description</h3>
                    <p class="text-sm text-crm-text leading-relaxed whitespace-pre-wrap">{{ $task->description }}</p>
                </div>
                @endif

                @if($task->commentaire)
                <div class="mt-4 pt-4 border-t border-crm-border">
                    <h3 class="text-crm-muted mb-2 text-xs uppercase">Comments</h3>
                    <p class="text-sm text-crm-text leading-relaxed whitespace-pre-wrap">{{ $task->commentaire }}</p>
                </div>
                @endif
            </div>

            <!-- Delete Action -->
            <div class="bg-red-500/10 border border-red-500/20 rounded-crm p-6">
                <h3 class="text-red-400 font-semibold mb-2">Danger Zone</h3>
                <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" onsubmit="return confirm('Are you sure you want to delete this task?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm font-bold">Delete Task</button>
                </form>
            </div>
        </div>
    </div>
@endsection


