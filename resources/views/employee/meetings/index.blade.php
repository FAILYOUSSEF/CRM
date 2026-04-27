@extends('layouts.app')
@section('title','My Meetings')
@section('content')
<h1 class="text-2xl font-bold text-crm-text tracking-tight mb-6">My Meetings</h1>
<div class="grid gap-4">
    @forelse($meetings as $meeting)
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="font-semibold text-crm-text text-lg">{{ $meeting->titre }}</h2>
                <p class="text-sm text-crm-muted mt-1">{{ $meeting->date_heure->format('d/m/Y H:i') }} &mdash; {{ ucfirst($meeting->type) }}</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-medium border {{ $meeting->status === 'terminé' ? 'bg-gray-500/10 text-gray-400 border-gray-500/20' : 'bg-green-500/10 text-green-400 border-green-500/20' }}">
                {{ $meeting->status }}
            </span>
        </div>
        @if($meeting->description)
            <p class="text-sm text-crm-muted mb-4">{{ $meeting->description }}</p>
        @endif
        @if($meeting->link)
            <p><a href="{{ $meeting->link }}" target="_blank" class="text-crm-accent hover:text-blue-400 text-sm font-medium transition-colors">Join Online Meeting →</a></p>
        @endif
    </div>
    @empty
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-12 text-center">
        <p class="text-crm-muted">No meetings scheduled.</p>
    </div>
    @endforelse
</div>
@endsection
