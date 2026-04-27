@extends('layouts.app')
@section('title','My Reclamations')
@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-crm-text tracking-tight">My Reclamations</h1>
    <a href="{{ route('client.reclamations.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-blue-500 transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold flex items-center gap-2">
        + New Reclamation
    </a>
</div>

<div class="space-y-4">
    @forelse($reclamations as $rec)
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6 group hover:border-crm-accent/50 transition-colors">
        <div class="flex items-start justify-between mb-4">
            <div>
                <a href="{{ route('client.reclamations.show', $rec->id) }}" class="font-semibold text-lg text-crm-text group-hover:text-crm-accent transition-colors">{{ $rec->titre }}</a>
                <p class="text-sm text-crm-muted mt-2 flex items-center gap-2">
                    {{ $rec->date ?? 'N/A' }} &bull; {{ ucfirst($rec->type ?? 'General') }}
                </p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold tracking-wide border {{ $rec->status === 'traité' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' }}">{{ ucfirst($rec->status) }}</span>
        </div>
        @if($rec->response)
            <div class="bg-green-500/10 border border-green-500/20 rounded-crm p-4 text-sm text-green-400 flex items-start gap-3">
                <div>
                    <strong class="block text-green-300 mb-1">Support Reply</strong>
                    {{ $rec->response }}
                </div>
            </div>
        @endif
    </div>
    @empty
    <div class="bg-crm-surface border-2 border-dashed border-crm-border rounded-crm p-12 text-center">
        <p class="text-crm-muted text-lg mb-3">No reclamations submitted yet.</p>
        <a href="{{ route('client.reclamations.create') }}" class="text-crm-accent font-medium hover:text-blue-400 transition-colors inline-block text-sm">Create your first one →</a>
    </div>
    @endforelse
</div>

@endsection
