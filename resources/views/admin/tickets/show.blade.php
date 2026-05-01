@extends('layouts.app')
@section('title', 'Ticket: '.$ticket->sujet)
@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Ticket: {{ $ticket->sujet }}</h1>
<div class="max-w-2xl space-y-6 min-w-0">
    <div class="bg-white rounded-lg shadow p-6">
        <dl class="grid grid-cols-2 gap-3 text-sm mb-4">
            <div><dt class="text-gray-500">From</dt><dd class="font-medium">{{ $ticket->user->name }}</dd></div>
            <div><dt class="text-gray-500">Project</dt><dd class="font-medium">{{ $ticket->project->titre }}</dd></div>
            <div><dt class="text-gray-500">Category</dt><dd class="font-medium">{{ $ticket->category?->name ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $ticket->status }}</dd></div>
            <div><dt class="text-gray-500">Priority</dt><dd class="font-medium">{{ $ticket->priorite }}</dd></div>
            <div><dt class="text-gray-500">Deadline</dt><dd class="font-medium">{{ $ticket->deadline ?? '—' }}</dd></div>
        </dl>
        <div class="text-sm text-gray-700 bg-gray-50 rounded p-3 break-anywhere whitespace-pre-wrap max-w-full overflow-hidden">{{ $ticket->message }}</div>
    </div>
    @if($ticket->response)
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <p class="text-sm font-semibold text-green-700 mb-1">Your reply</p>
        <p class="text-sm text-green-800 break-anywhere whitespace-pre-wrap max-w-full overflow-hidden">{{ $ticket->response }}</p>
    </div>
    @endif
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="font-semibold text-gray-700 mb-3">Reply to Ticket</h2>
        <form method="POST" action="{{ route('admin.tickets.reply', $ticket) }}">
            @csrf
            <textarea name="response" rows="4" required placeholder="Type your reply..." class="w-full max-w-full border border-gray-300 rounded px-3 py-2 text-sm mb-3 break-anywhere whitespace-pre-wrap overflow-x-hidden" wrap="soft">{{ old('response', $ticket->response) }}</textarea>
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 text-sm">Send Reply & Close</button>
        </form>
    </div>
</div>
@endsection
