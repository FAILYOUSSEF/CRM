@extends('layouts.app')
@section('title','My Tickets')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">My Tickets</h1>
    <a href="{{ route('client.tickets.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ New Ticket</a>
</div>
<div class="space-y-4">
    @forelse($tickets as $ticket)
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="font-semibold text-gray-800">{{ $ticket->sujet }}</h2>
                <p class="text-sm text-gray-500">{{ $ticket->project->titre }} &mdash; {{ $ticket->category?->name ?? 'Uncategorized' }}</p>
            </div>
            <span class="px-2 py-1 rounded text-xs {{ $ticket->status === 'fermé' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $ticket->status }}</span>
        </div>
        @if($ticket->reponce)
            <div class="mt-3 bg-green-50 border border-green-200 rounded p-3 text-sm text-green-800">
                <strong>Reply:</strong> {{ $ticket->reponce }}
            </div>
        @endif
    </div>
    @empty
    <p class="text-gray-400 text-center py-10">No tickets submitted.</p>
    @endforelse
</div>
@endsection