@extends('layouts.app')
@section('title','Create Task')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-900">Create New Task</h1>
    <form method="POST" action="{{ route('admin.tasks.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Title</label>
            <input type="text" name="titre" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white" required value="{{ old('titre') }}">
            @error('titre') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Description</label>
            <textarea name="description" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Project</label>
            <select name="project_id" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" required>
                <option value="">Select Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->titre }}</option>
                @endforeach
            </select>
            @error('project_id') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Employee</label>
            <select name="employee_id" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white">
                <option value="">Unassigned</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Priority</label>
            <select name="priorite" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" required>
                <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                <option value="moyenne" {{ old('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
            </select>
            @error('priorite') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Status</label>
            <select name="status" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" required>
                <option value="à faire" {{ old('status') == 'à faire' ? 'selected' : '' }}>À faire</option>
                <option value="en cours" {{ old('status') == 'en cours' ? 'selected' : '' }}>En cours</option>
                <option value="terminé" {{ old('status') == 'terminé' ? 'selected' : '' }}>Terminé</option>
            </select>
            @error('status') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Start Date</label>
            <input type="date" name="date_debut" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" value="{{ old('date_debut') }}">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Duration (days)</label>
            <input type="number" name="duree" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" value="{{ old('duree') }}">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">End Date</label>
            <input type="date" name="date_fin" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" value="{{ old('date_fin') }}">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Comment</label>
            <textarea name="commentaire" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white">{{ old('commentaire') }}</textarea>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Create Task</button>
        <a href="{{ route('admin.tasks.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection