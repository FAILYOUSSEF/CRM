@extends('layouts.app')
@section('title','New Reclamation')
@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-6">Submit a Reclamation</h1>
<div class="bg-white rounded-lg shadow p-6 max-w-xl">
    <form method="POST" action="{{ route('employee.reclamations.store') }}" class="space-y-4" x-data="{ type: '{{ old('type', 'bug') }}' }">
        @csrf
        <div><label class="block text-sm font-medium text-gray-800 mb-1">Title *</label>
            <input name="titre" value="{{ old('titre') }}" required class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white"></div>
        <div><label class="block text-sm font-medium text-gray-800 mb-1">Type</label>
            <select name="type" x-model="type" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white">
                <option value="bug" {{ old('type') == 'bug' ? 'selected' : '' }}>Bug</option>
                <option value="meeting" {{ old('type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
            </select></div>
        <div x-show="type === 'other'" x-cloak><label class="block text-sm font-medium text-gray-800 mb-1">Other Type Details</label>
            <input name="type_other" value="{{ old('type_other') }}" placeholder="If 'Other', please specify..." class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white"></div>
        <div><label class="block text-sm font-medium text-gray-800 mb-1">Priority</label>
            <select name="priorite" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white">
                <option value="faible">Faible</option><option value="moyenne" selected>Moyenne</option><option value="haute">Haute</option>
            </select></div>
        <div><label class="block text-sm font-medium text-gray-800 mb-1">Description *</label>
            <textarea name="description" rows="4" required class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white">{{ old('description') }}</textarea></div>
        <div class="flex gap-3">
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 text-sm">Submit</button>
            <a href="{{ route('employee.reclamations.index') }}" class="text-gray-600 hover:underline text-sm py-2">Cancel</a>
        </div>
    </form>
</div>
@endsection
