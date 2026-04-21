@extends('layouts.app')
@section('title','My Reclamations')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-crm-text">My Reclamations</h1>
    <a href="{{ route('employee.reclamations.create') }}" class="bg-crm-accent text-white px-4 py-2 rounded-crm hover:bg-blue-600 text-xs font-semibold">+ New Reclamation</a>
</div>
<div class="space-y-4">
    @forelse($reclamations as $rec)
    <div class="bg-crm-bg2 border border-crm-border rounded-crm-lg shadow-lg p-5">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="font-semibold text-crm-text">{{ $rec->titre }}</h2>
                <p class="text-xs text-crm-muted">{{ $rec->date }} &mdash; {{ $rec->type ?? 'General' }}</p>
            </div>
            <span class="px-2 py-1 rounded-crm text-xs {{ $rec->status === 'traité' ? 'bg-green-500/15 text-green-300 border border-green-500/30' : 'bg-yellow-500/15 text-yellow-300 border border-yellow-500/30' }}">{{ $rec->status }}</span>
        </div>
        @if($rec->reponce)
            <div class="mt-3 bg-green-500/10 border border-green-500/20 rounded-crm p-3 text-xs text-green-300">
                <strong>Reply:</strong> {{ $rec->reponce }}
            </div>
        @endif
    </div>
    @empty
    <p class="text-crm-muted text-center py-10">No reclamations submitted.</p>
    @endforelse
</div>
@endsection