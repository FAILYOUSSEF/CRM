@extends('layouts.app')
@section('title', 'Task: ' . $task->titre)
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $task->titre }}</h1>
        <p class="text-gray-600 mb-4">{{ $task->project->titre }}</p>
        <div class="grid grid-cols-2 gap-4 text-sm mb-6">
            <div>
                <dt class="text-gray-500">Status</dt>
                <dd class="font-medium">
                    <span class="px-2 py-1 rounded text-xs font-medium
                        {{ $task->status === 'terminé' ? 'bg-green-100 text-green-700' :
                          ($task->status === 'en cours' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                        {{ ucfirst($task->status) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-gray-500">Priority</dt>
                <dd class="font-medium">{{ ucfirst($task->priorite) }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Start Date</dt>
                <dd class="font-medium">{{ $task->date_debut ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">End Date</dt>
                <dd class="font-medium">{{ $task->date_fin ?? '—' }}</dd>
            </div>
        </div>
        @if($task->description)
        <div class="mb-6 bg-gray-50 rounded p-4">
            <p class="text-sm text-gray-700">{{ $task->description }}</p>
        </div>
        @endif
        @if($task->commentaire)
        <div class="mb-6 bg-blue-50 rounded p-4">
            <p class="text-sm font-semibold text-blue-700 mb-1">Your Comment</p>
            <p class="text-sm text-blue-800">{{ $task->commentaire }}</p>
        </div>
        @endif
    </div>
    <div class="flex gap-4">
        <a href="{{ route('employee.tasks.index') }}" class="text-gray-600 hover:underline px-4 py-2">Back to Tasks</a>
    </div>
</div>
@endsection
