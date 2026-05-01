@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Edit: {{ $project->titre }}</h1>
        <p class="text-sm text-crm-muted mt-1">Update the details for this project below.</p>
    </div>

    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6 sm:p-8 max-w-3xl">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-crm-muted mb-1">Title *</label>
                <input name="titre" value="{{ old('titre', $project->titre) }}" required class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5">
            </div>
            <div>
                <label class="block text-sm font-medium text-crm-muted mb-1">Description</label>
                <textarea name="description" rows="3" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5">{{ old('description', $project->description) }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-crm-muted mb-1">Start Date</label>
                    <input type="date" name="date_duree" value="{{ old('date_duree', $project->date_duree) }}" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5 [color-scheme:dark]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-crm-muted mb-1">End Date</label>
                    <input type="date" name="date_fin" value="{{ old('date_fin', $project->date_fin) }}" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5 [color-scheme:dark]">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-crm-muted mb-1">Status</label>
                    <select name="status" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5">
                        @foreach(['en cours','terminé','annulé'] as $s)
                            <option value="{{ $s }}" {{ $project->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-crm-muted mb-1">Priority</label>
                    <select name="priorite" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5">
                        @foreach(['faible','moyenne','haute'] as $p)
                            <option value="{{ $p }}" {{ $project->priorite === $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-crm-muted mb-1">Budget</label>
                    <input type="number" step="0.01" name="budget" value="{{ old('budget', $project->budget) }}" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-crm-muted mb-1">Client</label>
                    <select name="client_id" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5">
                        <option value="">— None —</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}" {{ $project->client_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-crm-muted mb-2">Assign Employees</label>
                <div class="border border-crm-border bg-crm-bg3 rounded-crm p-4 grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-48 overflow-y-auto custom-scrollbar">
                    @foreach($employees as $emp)
                        <label class="flex items-center gap-3 text-sm text-crm-text cursor-pointer group">
                            <input type="checkbox" name="employees[]" value="{{ $emp->id }}"
                                {{ $project->employees->contains($emp->id) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-crm-border text-crm-accent shadow-sm focus:ring-crm-accent focus:ring-offset-0 focus:ring-offset-crm-surface bg-crm-bg2 group-hover:border-crm-accent transition-colors">
                            {{ $emp->name }}
                        </label>
                    @endforeach
                </div>
            </div>
            
            <div class="flex items-center gap-4 pt-4 border-t border-crm-border mt-6">
                <button type="submit" class="bg-crm-accent text-white px-5 py-2.5 rounded-crm hover:bg-black font-bold transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5">
                    Save Changes
                </button>
                <a href="{{ route('admin.projects.index') }}" class="text-crm-muted hover:text-crm-text transition-colors text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
@endsection
