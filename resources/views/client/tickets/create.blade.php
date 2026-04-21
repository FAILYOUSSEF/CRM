@extends('layouts.app')
@section('title','New Ticket')
@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-6">Submit a Ticket</h1>
<div class="bg-white rounded-lg shadow p-6 max-w-xl">
    <form method="POST" action="{{ route('client.tickets.store') }}" class="space-y-4">
        @csrf
        <div><label class="block text-sm font-medium text-gray-800 mb-1">Subject *</label>
            <input name="sujet" value="{{ old('sujet') }}" required class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white"></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-800 mb-1">Project *</label>
                <select name="project_id" required class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white">
                    <option value="">— Select —</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}" {{ old('project_id') == $p->id ? 'selected' : '' }}>{{ $p->titre }}</option>
                    @endforeach
                </select></div>
            <div><label class="block text-sm font-medium text-gray-800 mb-1">Category</label>
                <select name="category_id" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white">
                    <option value="">— None —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-800 mb-1">Priority</label>
                <select name="priorite" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white">
                    <option value="faible">Faible</option><option value="moyenne" selected>Moyenne</option><option value="haute">Haute</option>
                </select></div>
            <div><label class="block text-sm font-medium text-gray-800 mb-1">Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white"></div>
        </div>
        <div><label class="block text-sm font-medium text-gray-800 mb-1">Message *</label>
            <textarea name="message" rows="4" required class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white">{{ old('message') }}</textarea></div>
        <div class="flex gap-3">
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 text-sm">Submit Ticket</button>
            <a href="{{ route('client.tickets.index') }}" class="text-gray-600 hover:underline text-sm py-2">Cancel</a>
        </div>
    </form>
</div>
@endsection