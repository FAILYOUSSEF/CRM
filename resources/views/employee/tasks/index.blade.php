@extends('layouts.app')
@section('title','My Tasks')
@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">My Tasks</h1>
<div class="grid gap-4">
    @forelse($tasks as $task)
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="font-semibold text-gray-800">{{ $task->titre }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $task->project->titre }} &mdash; Deadline: {{ $task->date_fin ?? 'N/A' }}</p>
            </div>
            <span class="px-2 py-1 rounded text-xs font-medium
                {{ $task->status === 'terminé' ? 'bg-green-100 text-green-700' :
                  ($task->status === 'en cours' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                {{ $task->status }}
            </span>
        </div>
        @if($task->description)
            <p class="mt-2 text-sm text-gray-600">{{ $task->description }}</p>
        @endif
        <form method="POST" action="{{ route('employee.tasks.update', $task) }}" class="mt-4 flex items-center gap-3">
            @csrf @method('PATCH')
            <select name="status" class="border border-gray-300 rounded px-3 py-1.5 text-sm">
                @foreach(['à faire','en cours','terminé'] as $s)
                    <option value="{{ $s }}" {{ $task->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <input name="commentaire" value="{{ $task->commentaire }}" placeholder="Add comment..." class="flex-1 border border-gray-300 rounded px-3 py-1.5 text-sm">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-1.5 rounded hover:bg-indigo-700 text-sm">Update</button>
        </form>
    </div>
    @empty
    <p class="text-gray-400 text-center py-10">No tasks assigned to you.</p>
    @endforelse
</div>
<div class="mt-4">{{ $tasks->links() }}</div>
@endsection
