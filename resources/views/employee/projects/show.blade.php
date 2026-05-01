@extends('layouts.app')
@section('title', 'Project: ' . $project->titre)
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $project->titre }}</h1>
        <p class="text-gray-600 mb-4">Client: {{ $project->client?->name ?? 'N/A' }}</p>
        <div class="grid grid-cols-2 gap-4 text-sm mb-6">
            <div>
                <dt class="text-gray-500">Status</dt>
                <dd class="font-medium">
                    <span class="px-2 py-1 rounded text-xs font-medium
                        {{ $project->status === 'en cours' ? 'bg-blue-100 text-blue-700' : 
                          ($project->status === 'terminé' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">
                        {{ $project->status }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-gray-500">Budget</dt>
                <dd class="font-medium">{{ $project->budget ?? 'N/A' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Start Date</dt>
                <dd class="font-medium">{{ $project->date_debut ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">End Date</dt>
                <dd class="font-medium">{{ $project->date_fin ?? '—' }}</dd>
            </div>
        </div>
        @if($project->description)
        <div class="mb-6 bg-gray-50 rounded p-4">
            <p class="text-sm text-gray-700">{{ $project->description }}</p>
        </div>
        @endif
        @if($project->tasks->count())
        <div class="mt-6">
            <h3 class="font-semibold text-gray-800 mb-3">Tasks</h3>
            <ul class="text-sm text-gray-700 space-y-2">
                @foreach($project->tasks as $task)
                <li class="py-2 border-b">{{ $task->titre }} <span class="ml-2 px-2 py-0.5 rounded text-xs bg-gray-100">{{ $task->status }}</span></li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="flex gap-4">
        <a href="{{ route('employee.projects.index') }}" class="text-gray-600 hover:underline px-4 py-2">Back to Projects</a>
    </div>
</div>
@endsection
