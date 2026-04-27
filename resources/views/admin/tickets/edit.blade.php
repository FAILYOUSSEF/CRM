@extends('layouts.app')
@section('title','Edit Ticket')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-900">Edit Ticket</h1>
    <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="sujet" class="block mb-1 font-semibold text-gray-800">Subject</label>
            <input type="text" name="sujet" id="sujet" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white" required value="{{ old('sujet', $ticket->sujet) }}">
            @error('sujet') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="project_id" class="block mb-1 font-semibold text-gray-800">Project</label>
            <select name="project_id" id="project_id" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" required>
                <option value="">-- Select Project --</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ old('project_id', $ticket->project_id) == $project->id ? 'selected' : '' }}>{{ $project->titre }}</option>
                @endforeach
            </select>
            @error('project_id') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="category_id" class="block mb-1 font-semibold text-gray-800">Category (Optional)</label>
            <select name="category_id" id="category_id" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="priorite" class="block mb-1 font-semibold text-gray-800">Priority</label>
            <select name="priorite" id="priorite" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" required>
                <option value="faible" {{ old('priorite', $ticket->priorite) == 'faible' ? 'selected' : '' }}>Low</option>
                <option value="moyen" {{ old('priorite', $ticket->priorite) == 'moyen' ? 'selected' : '' }}>Medium</option>
                <option value="urgent" {{ old('priorite', $ticket->priorite) == 'urgent' ? 'selected' : '' }}>High</option>
            </select>
            @error('priorite') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="message" class="block mb-1 font-semibold text-gray-800">Description / Message</label>
            <textarea name="message" id="message" rows="4" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white">{{ old('message', $ticket->message) }}</textarea>
            @error('message') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="deadline" class="block mb-1 font-semibold text-gray-800">Deadline (Optional)</label>
            <input type="date" name="deadline" id="deadline" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" value="{{ old('deadline', $ticket->deadline) }}">
            @error('deadline') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block mb-1 font-semibold text-gray-800">Status</label>
            <select name="status" id="status" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 bg-white" required>
                <option value="ouvert" {{ old('status', $ticket->status) == 'ouvert' ? 'selected' : '' }}>Open</option>
                <option value="fermé" {{ old('status', $ticket->status) == 'fermé' ? 'selected' : '' }}>Closed</option>
            </select>
            @error('status') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>

        @if($ticket->response)
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded">
            <label class="block mb-1 font-semibold text-gray-800">Response</label>
            <p class="text-gray-700">{{ $ticket->response }}</p>
        </div>
        @endif

        <div class="flex gap-2">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Update Ticket</button>
            <a href="{{ route('admin.tickets.index') }}" class="text-gray-600 hover:underline py-2">Cancel</a>
        </div>
    </form>
</div>
@endsection
