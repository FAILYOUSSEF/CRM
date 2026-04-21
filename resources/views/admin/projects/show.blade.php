@extends('layouts.app')
@section('title', $project->titre)
@section('content')
<div class="mb-4 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-800">{{ $project->titre }}</h1>
    <a href="{{ route('admin.projects.edit', $project) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">Edit</a>
</div>
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold text-gray-700 mb-3">Details</h2>
            <dl class="grid grid-cols-2 gap-3 text-sm">
                <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $project->status }}</dd></div>
                <div><dt class="text-gray-500">Priority</dt><dd class="font-medium">{{ $project->priorite }}</dd></div>
                <div><dt class="text-gray-500">Budget</dt><dd class="font-medium">{{ $project->budget ? number_format($project->budget,2).' MAD' : '—' }}</dd></div>
                <div><dt class="text-gray-500">Client</dt><dd class="font-medium">{{ $project->client?->name ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">Start</dt><dd class="font-medium">{{ $project->date_duree ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">End</dt><dd class="font-medium">{{ $project->date_fin ?? '—' }}</dd></div>
            </dl>
            @if($project->description)
                <p class="mt-4 text-sm text-gray-600">{{ $project->description }}</p>
            @endif
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold text-gray-700 mb-3">Tasks ({{ $project->tasks->count() }})</h2>
            @forelse($project->tasks as $task)
                <div class="flex items-center justify-between py-2 border-b last:border-0 text-sm">
                    <span>{{ $task->titre }}</span>
                    <span class="px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-700">{{ $task->status }}</span>
                </div>
            @empty
                <p class="text-gray-400 text-sm">No tasks.</p>
            @endforelse
        </div>
    </div>
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold text-gray-700 mb-3">Team</h2>
            @forelse($project->employees as $emp)
                <div class="flex items-center gap-2 py-1 text-sm">
                    <span class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">{{ strtoupper(substr($emp->name,0,1)) }}</span>
                    {{ $emp->name }}
                </div>
            @empty
                <p class="text-gray-400 text-sm">No employees assigned.</p>
            @endforelse
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold text-gray-700 mb-3">Tickets ({{ $project->tickets->count() }})</h2>
            @forelse($project->tickets as $ticket)
                <div class="text-sm py-1 border-b last:border-0">
                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-indigo-600 hover:underline">{{ $ticket->sujet }}</a>
                </div>
            @empty
                <p class="text-gray-400 text-sm">No tickets.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection