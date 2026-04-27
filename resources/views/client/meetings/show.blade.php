@extends('layouts.app')
@section('title', $meeting->titre)
@section('content')

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('client.meetings.index') }}" class="text-crm-muted hover:text-crm-accent bg-crm-bg2 border border-crm-border px-3 py-2 rounded-crm shadow-sm transition-all hover:shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Meeting Details</h1>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <div class="bg-crm-bg2 border border-crm-border rounded-crm p-8">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-crm-text">{{ $meeting->titre }}</h2>
                    <p class="text-sm text-crm-muted mt-2 flex items-center gap-2 font-medium">
                        <svg class="w-4 h-4 text-crm-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($meeting->date_heure)->format('F j, Y \a\t g:i A') }}
                    </p>
                </div>
                
                @php
                    $myResponse = $meeting->participants->where('id', auth()->id())->first()->pivot->response ?? 'pending';
                @endphp

                <div>
                    <span class="px-3.5 py-1.5 rounded-crm text-xs font-bold tracking-wide uppercase shadow-sm border
                        {{ $myResponse === 'accepted' ? 'bg-green-500/20 text-green-400 border-green-500/20' : ($myResponse === 'refused' ? 'bg-red-500/20 text-red-400 border-red-500/20' : 'bg-yellow-500/20 text-yellow-400 border-yellow-500/20') }}">
                        Status: {{ $myResponse }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-4 bg-crm-bg3 p-6 rounded-crm border border-crm-border">
                    <div>
                        <span class="block text-xs font-bold text-crm-muted uppercase tracking-wider mb-1">Meeting Type</span>
                        <span class="text-sm font-semibold text-crm-text">{{ ucfirst($meeting->type) }}</span>
                    </div>
                    @if($meeting->type === 'online' && $meeting->link)
                        <div>
                            <span class="block text-xs font-bold text-crm-muted uppercase tracking-wider mb-1">Meeting Link</span>
                            <a href="{{ $meeting->link }}" target="_blank" class="text-sm font-semibold text-crm-accent hover:text-crm-accent/80 hover:underline flex items-center gap-1 transition-colors">
                                Join Online Meeting <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    @elseif($meeting->type === 'presentiel' && $meeting->lieu)
                        <div>
                            <span class="block text-xs font-bold text-crm-muted uppercase tracking-wider mb-1">Location</span>
                            <span class="text-sm font-semibold text-crm-text">{{ $meeting->lieu }}</span>
                        </div>
                    @endif
                </div>
                
                <div>
                    <span class="block text-xs font-bold text-crm-muted uppercase tracking-wider mb-2">Description & Agenda</span>
                    <div class="text-sm text-crm-text/80 leading-relaxed whitespace-pre-wrap">{{ $meeting->description ?? 'No description provided.' }}</div>
                </div>
            </div>

            @if($myResponse === 'pending')
                <div class="border-t border-crm-border pt-6 mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h3 class="text-sm font-bold text-crm-text">Will you attend this meeting?</h3>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('client.meetings.respond', $meeting->id) }}" method="POST" class="inline-block">
                            @csrf <input type="hidden" name="response" value="refused">
                            <button type="submit" class="bg-crm-bg2 text-red-400 border border-red-500/20 px-5 py-2.5 rounded-crm shadow-sm hover:bg-red-500/10 transition-all duration-200 text-sm font-bold">Decline</button>
                        </form>
                        <form action="{{ route('client.meetings.respond', $meeting->id) }}" method="POST" class="inline-block">
                            @csrf <input type="hidden" name="response" value="accepted">
                            <button type="submit" class="bg-crm-accent text-white px-6 py-2.5 rounded-crm shadow-sm hover:shadow-md hover:bg-crm-accent/90 transform hover:-translate-y-0.5 transition-all duration-200 text-sm font-bold">Accept Meeting</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
    </div>
@endsection
