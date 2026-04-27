@extends('layouts.app')
@section('title','My Tickets')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-crm-text tracking-tight">My Tickets</h1>
    <a href="{{ route('client.tickets.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-blue-500 transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">+ New Ticket</a>
</div>
<div class="space-y-4">
    @forelse($tickets as $ticket)
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="font-semibold text-crm-text text-lg">{{ $ticket->sujet }}</h2>
                <p class="text-sm text-crm-muted mt-1">{{ $ticket->project->titre }} &mdash; {{ $ticket->category?->name ?? 'Uncategorized' }}</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-medium border {{ $ticket->status === 'fermé' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' }}">{{ $ticket->status }}</span>
        </div>
        @if($ticket->response)
            <div class="bg-green-500/10 border border-green-500/20 rounded-crm p-4 text-sm text-green-400">
                <strong class="block text-green-300 mb-1">Support Reply</strong> {{ $ticket->response }}
            </div>
        @endif
    </div>
    @empty
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-12 text-center">
        <p class="text-crm-muted">No tickets submitted.</p>
    </div>
    @endforelse
</div>
@endsection