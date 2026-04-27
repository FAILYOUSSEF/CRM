@extends('layouts.app')
@section('title','Meetings')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-crm-text tracking-tight">Available Meetings</h1>
    <a href="{{ route('client.meetings.request') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-blue-500 transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">+ Request Meeting</a>
</div>
<div class="grid gap-4">
    @forelse($meetings as $meeting)
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="font-semibold text-crm-text text-lg">{{ $meeting->titre }}</h2>
                <p class="text-sm text-crm-muted mt-1">{{ $meeting->date_heure->format('d/m/Y H:i') }} &mdash; {{ ucfirst($meeting->type) }}</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-medium border {{ $meeting->status === 'terminé' ? 'bg-gray-500/10 text-gray-400 border-gray-500/20' : 'bg-green-500/10 text-green-400 border-green-500/20' }}">
                {{ $meeting->status }}
            </span>
        </div>
        @if($meeting->description)
            <p class="mt-3 text-sm text-crm-muted">{{ $meeting->description }}</p>
        @endif
        @if($meeting->link)
            <p class="mt-3"><a href="{{ $meeting->link }}" target="_blank" class="text-crm-accent hover:text-blue-400 text-sm font-medium transition-colors">Join Online Meeting →</a></p>
        @endif
    </div>
    @empty
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-12 text-center">
        <p class="text-crm-muted">No meetings available.</p>
    </div>
    @endforelse
</div>
@endsection
