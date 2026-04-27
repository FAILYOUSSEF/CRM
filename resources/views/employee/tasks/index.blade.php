@extends('layouts.app')
@section('title','My Tasks')
@section('content')
<h1 class="text-2xl font-bold text-crm-text tracking-tight mb-6">My Tasks</h1>
<div class="grid gap-4">
    @forelse($tasks as $task)
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="font-semibold text-crm-text text-lg">{{ $task->titre }}</h2>
                <p class="text-sm text-crm-muted mt-1">{{ $task->project->titre }} &mdash; Deadline: {{ $task->date_fin ?? 'N/A' }}</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-medium border
                {{ $task->status === 'terminé' ? 'bg-green-500/10 text-green-400 border-green-500/20' :
                  ($task->status === 'en cours' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-crm-bg3 text-crm-muted border-crm-border') }}">
                {{ $task->status }}
            </span>
        </div>
        @if($task->description)
            <p class="text-sm text-crm-muted mb-4">{{ $task->description }}</p>
        @endif
        <form method="POST" action="{{ route('employee.tasks.update', $task) }}" class="flex items-center gap-3">
            @csrf @method('PATCH')
            <select name="status" class="border border-crm-border bg-crm-bg3 rounded-crm text-crm-text text-sm px-3 py-2 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all">
                @foreach(['à faire','en cours','terminé'] as $s)
                    <option value="{{ $s }}" {{ $task->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <input name="commentaire" value="{{ $task->commentaire }}" placeholder="Add comment..." class="flex-1 border border-crm-border bg-crm-bg3 rounded-crm text-crm-text placeholder-crm-muted/50 text-sm px-3 py-2 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all">
            <button type="submit" class="bg-crm-accent text-white px-4 py-2 rounded-crm hover:bg-blue-500 transition-colors font-medium text-sm">Update</button>
        </form>
    </div>
    @empty
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-12 text-center">
        <p class="text-crm-muted">No tasks assigned to you.</p>
    </div>
    @endforelse
</div>
<div class="mt-6 text-crm-muted">{{ $tasks->links() }}</div>
@endsection
