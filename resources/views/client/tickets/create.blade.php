@extends('layouts.app')
@section('title','New Ticket')
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('client.tickets.index') }}" class="text-crm-muted hover:text-crm-accent transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="text-2xl font-bold text-crm-text">Submit a Ticket</h1>
</div>

@if($projects->isEmpty())
<div class="bg-crm-bg2 border border-crm-border rounded-crm p-6 max-w-2xl">
    <div class="flex items-start gap-4">
        <svg class="w-6 h-6 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M12 3a9 9 0 110 18 9 9 0 010-18z"/></svg>
        <div>
            <h3 class="text-sm font-semibold text-crm-text mb-1">No Completed Projects</h3>
            <p class="text-sm text-crm-muted">You can only submit tickets for completed projects. Once a project is marked as completed, you'll be able to submit tickets related to it.</p>
            <a href="{{ route('client.projects.index') }}" class="inline-block mt-4 text-crm-accent hover:text-crm-accent/80 text-sm font-medium transition-colors">Browse your projects →</a>
        </div>
    </div>
</div>
@else
<div class="bg-crm-bg2 border border-crm-border rounded-crm p-6 max-w-2xl">
    <form method="POST" action="{{ route('client.tickets.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-medium text-crm-muted mb-1.5">Subject *</label>
            <input name="sujet" value="{{ old('sujet') }}" required class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text placeholder-crm-muted outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Project *</label>
                <select name="project_id" required class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                    <option value="">— Select —</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}" {{ old('project_id') == $p->id ? 'selected' : '' }}>{{ $p->titre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Category</label>
                <select name="category_id" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                    <option value="">— None —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Priority</label>
                <select name="priorite" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                    <option value="faible">Faible</option>
                    <option value="moyenne" selected>Moyenne</option>
                    <option value="haute">Haute</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
        </div>
        <div>
            <label class="block text-xs font-medium text-crm-muted mb-1.5">Message *</label>
            <textarea name="message" rows="4" required class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text placeholder-crm-muted outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">{{ old('message') }}</textarea>
        </div>
        <div class="flex items-center gap-3 pt-4 border-t border-crm-border">
            <button type="submit" class="px-5 py-2.5 bg-crm-accent hover:bg-crm-accent/90 text-white text-sm font-medium rounded-crm transition-colors">Submit Ticket</button>
            <a href="{{ route('client.tickets.index') }}" class="px-5 py-2.5 text-crm-muted hover:text-crm-text text-sm transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endif
@endsection