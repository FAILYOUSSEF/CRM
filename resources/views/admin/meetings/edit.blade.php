@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Edit Meeting</h1>
    </div>

    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6 sm:p-8 max-w-xl">
        <form method="POST" action="{{ route('admin.meetings.update', $meeting->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="titre" class="block text-sm font-medium text-crm-muted mb-1">Title</label>
            <input type="text" name="titre" id="titre" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" required value="{{ old('titre', $meeting->titre) }}">
            @error('titre') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-crm-muted mb-1">Description / Agenda</label>
            <textarea name="description" id="description" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5">{{ old('description', $meeting->description) }}</textarea>
            @error('description') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="date_heure" class="block text-sm font-medium text-crm-muted mb-1">Scheduled Time</label>
            <input type="datetime-local" name="date_heure" id="date_heure" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5 [color-scheme:dark]" required value="{{ old('date_heure', \Carbon\Carbon::parse($meeting->date_heure)->format('Y-m-d\TH:i')) }}">
            @error('date_heure') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="lieu" class="block text-sm font-medium text-crm-muted mb-1">Location</label>
            <input type="text" name="lieu" id="lieu" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" value="{{ old('lieu', $meeting->lieu) }}">
            @error('lieu') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="type" class="block text-sm font-medium text-crm-muted mb-1">Type</label>
            <select name="type" id="type" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" required>
                <option value="online" @selected(old('type', $meeting->type) == 'online')>Online</option>
                <option value="presentiel" @selected(old('type', $meeting->type) == 'presentiel')>In-Person</option>
            </select>
            @error('type') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="link" class="block text-sm font-medium text-crm-muted mb-1">Meeting Link (if online)</label>
            <input type="url" name="link" id="link" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" value="{{ old('link', $meeting->link) }}">
            @error('link') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="participants" class="block text-sm font-medium text-crm-muted mb-1">Participants</label>
            <select name="participants[]" id="participants" multiple class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(in_array($user->id, old('participants', $current ?? [])))>{{ $user->name }} ({{ $user->type_client }})</option>
                @endforeach
            </select>
            <p class="text-xs text-crm-muted mt-1">Hold Ctrl/Cmd to select multiple participants</p>
            @error('participants') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-crm-muted mb-1">Status</label>
            <select name="status" id="status" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" required>
                <option value="planifié" @selected(old('status', $meeting->status) == 'planifié')>Scheduled</option>
                <option value="terminé" @selected(old('status', $meeting->status) == 'terminé')>Completed</option>
                <option value="annulé" @selected(old('status', $meeting->status) == 'annulé')>Canceled</option>
            </select>
            @error('status') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="flex items-center gap-4 pt-4 border-t border-crm-border mt-6">
            <button type="submit" class="bg-crm-accent text-white px-5 py-2.5 rounded-crm hover:bg-blue-500 font-bold transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5">
                Update Meeting
            </button>
            <a href="{{ route('admin.meetings.index') }}" class="text-crm-muted hover:text-crm-text transition-colors text-sm font-medium">Cancel</a>
        </div>
        </form>
    </div>
@endsection
