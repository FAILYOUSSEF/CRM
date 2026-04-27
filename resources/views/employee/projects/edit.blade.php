@extends('layouts.app')
@section('title','Edit Project')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-900">Edit Project</h1>
    <form method="POST" action="{{ route('employee.projects.update', $project) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Status</label>
            <select name="status" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" required>
                <option value="à faire" {{ old('status', $project->status) == 'à faire' ? 'selected' : '' }}>À faire</option>
                <option value="en cours" {{ old('status', $project->status) == 'en cours' ? 'selected' : '' }}>En cours</option>
                <option value="terminé" {{ old('status', $project->status) == 'terminé' ? 'selected' : '' }}>Terminé</option>
            </select>
            @error('status') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Progress (%)</label>
            <input type="number" name="progress" min="0" max="100" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" value="{{ old('progress', $project->progress) }}">
            @error('progress') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Update Project</button>
        <a href="{{ route('employee.projects.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection
