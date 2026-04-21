@extends('layouts.app')
@section('title','Edit Project')
@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Edit: {{ $project->titre }}</h1>
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input name="titre" value="{{ old('titre', $project->titre) }}" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">{{ old('description', $project->description) }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="date_duree" value="{{ old('date_duree', $project->date_duree) }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="date_fin" value="{{ old('date_fin', $project->date_fin) }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    @foreach(['en cours','terminé','annulé'] as $s)
                        <option value="{{ $s }}" {{ $project->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                <select name="priorite" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    @foreach(['faible','moyenne','haute'] as $p)
                        <option value="{{ $p }}" {{ $project->priorite === $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Budget</label>
                <input type="number" step="0.01" name="budget" value="{{ old('budget', $project->budget) }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                <select name="client_id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    <option value="">— None —</option>
                    @foreach($clients as $c)
                        <option value="{{ $c->id }}" {{ $project->client_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Assign Employees</label>
            <div class="border border-gray-300 rounded p-3 grid grid-cols-2 gap-2 max-h-40 overflow-y-auto">
                @foreach($employees as $emp)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="employees[]" value="{{ $emp->id }}"
                            {{ $project->employees->contains($emp->id) ? 'checked' : '' }}>
                        {{ $emp->name }}
                    </label>
                @endforeach
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 text-sm">Save Changes</button>
            <a href="{{ route('admin.projects.index') }}" class="text-gray-600 hover:underline text-sm py-2">Cancel</a>
        </div>
    </form>
</div>
@endsection