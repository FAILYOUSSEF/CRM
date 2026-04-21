@extends('layouts.app')
@section('title','Reclamation')
@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Reclamation: {{ $reclamation->titre }}</h1>
<div class="max-w-2xl space-y-6">
    <div class="bg-white rounded-lg shadow p-6 text-sm">
        <dl class="grid grid-cols-2 gap-3 mb-4">
            <div><dt class="text-gray-500">From</dt><dd class="font-medium">{{ $reclamation->user->name }}</dd></div>
            <div><dt class="text-gray-500">Date</dt><dd class="font-medium">{{ $reclamation->date ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">Type</dt><dd class="font-medium">{{ $reclamation->type ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">Priority</dt><dd class="font-medium">{{ $reclamation->priorite }}</dd></div>
            <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $reclamation->status }}</dd></div>
        </dl>
        <div class="bg-gray-50 rounded p-3 text-gray-700">{{ $reclamation->description }}</div>
    </div>
    @if($reclamation->reponce)
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-sm">
        <p class="font-semibold text-green-700 mb-1">Your reply</p>
        <p class="text-green-800">{{ $reclamation->reponce }}</p>
    </div>
    @endif
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="font-semibold text-gray-700 mb-3">Reply</h2>
        <form method="POST" action="{{ route('admin.reclamations.reply', $reclamation) }}">
            @csrf
            <textarea name="reponce" rows="4" required placeholder="Type your reply..." class="w-full border border-gray-300 rounded px-3 py-2 text-sm mb-3">{{ old('reponce', $reclamation->reponce) }}</textarea>
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 text-sm">Send Reply</button>
        </form>
    </div>
</div>
@endsection