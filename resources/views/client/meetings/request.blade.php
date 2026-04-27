@extends('layouts.app')
@section('title','Request a Meeting')
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('client.meetings.index') }}" class="text-crm-muted hover:text-crm-accent transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="text-2xl font-bold text-crm-text">Request a Meeting</h1>
</div>

<div class="bg-crm-bg2 border border-crm-border rounded-crm p-6 max-w-2xl">
    <form method="POST" action="{{ route('client.meetings.storeRequest') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-medium text-crm-muted mb-1.5">Purpose *</label>
            <input name="titre" value="{{ old('titre') }}" required class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text placeholder-crm-muted outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors" placeholder="e.g., Project Discussion, Support...">
            @error('titre') <div class="text-red-400 text-xs">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-xs font-medium text-crm-muted mb-1.5">Preferred Date</label>
            <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            @error('preferred_date') <div class="text-red-400 text-xs">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block text-xs font-medium text-crm-muted mb-1.5">Additional Notes</label>
            <textarea name="description" rows="4" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text placeholder-crm-muted outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors" placeholder="Any additional details...">{{ old('description') }}</textarea>
        </div>
        <div class="flex items-center gap-3 pt-4 border-t border-crm-border">
            <button type="submit" class="px-5 py-2.5 bg-crm-accent hover:bg-crm-accent/90 text-white text-sm font-medium rounded-crm transition-colors">Send Request</button>
            <a href="{{ route('client.meetings.index') }}" class="px-5 py-2.5 text-crm-muted hover:text-crm-text text-sm transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
