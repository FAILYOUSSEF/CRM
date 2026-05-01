@extends('layouts.app')
@section('title', 'Ticket: ' . $ticket->sujet)
@section('content')
<div class="max-w-2xl mx-auto min-w-0">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $ticket->sujet }}</h1>
        <p class="text-gray-600 mb-4">{{ $ticket->project->titre }}</p>
        <div class="grid grid-cols-2 gap-4 text-sm mb-6">
            <div>
                <dt class="text-gray-500">Status</dt>
                <dd class="font-medium">
                    <span class="px-2 py-1 rounded text-xs {{ $ticket->status === 'fermé' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-gray-500">Priority</dt>
                <dd class="font-medium">{{ ucfirst($ticket->priorite) }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Category</dt>
                <dd class="font-medium">{{ $ticket->category?->name ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Deadline</dt>
                <dd class="font-medium">{{ $ticket->deadline ?? '—' }}</dd>
            </div>
        </div>
        <div class="mb-6 bg-gray-50 rounded p-4">
            <p class="text-sm text-gray-700 break-anywhere whitespace-pre-wrap max-w-full overflow-hidden">{{ $ticket->message }}</p>
        </div>
        @if($ticket->response)
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm font-semibold text-green-700 mb-2">Admin Response</p>
            <p class="text-sm text-green-800 break-anywhere whitespace-pre-wrap max-w-full overflow-hidden">{{ $ticket->response }}</p>
        </div>
        @endif
    </div>
    <div class="flex gap-4">
        <a href="{{ route('client.tickets.index') }}" class="text-gray-600 hover:underline px-4 py-2">Back to Tickets</a>
    </div>
</div>
@endsection
