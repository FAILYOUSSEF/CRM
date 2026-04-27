@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Reclamation: {{ $reclamation->titre }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.reclamations.edit', $reclamation) }}" class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-4 py-2.5 rounded-crm hover:bg-yellow-500 hover:text-white transition-all duration-200 text-sm font-bold">Edit</a>
            <a href="{{ route('admin.reclamations.index') }}" class="bg-gray-500/10 text-gray-400 border border-gray-500/20 px-4 py-2.5 rounded-crm hover:bg-gray-500 hover:text-crm-text transition-all duration-200 text-sm font-bold">Back</a>
        </div>
    </div>

    <div class="max-w-3xl space-y-6">
        <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
            <h2 class="font-semibold text-crm-text mb-4 tracking-wide uppercase text-xs">Reclamation Details</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-4">
                <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">From</dt><dd class="font-medium text-crm-text">{{ $reclamation->user->name }}</dd></div>
                <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Date</dt><dd class="font-medium text-crm-text">{{ $reclamation->created_at->format('M d, Y') }}</dd></div>
                <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Type</dt><dd class="font-medium text-crm-text capitalize">{{ $reclamation->type ?? '—' }}</dd></div>
                <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Priority</dt><dd class="font-medium text-crm-text capitalize">{{ $reclamation->priorite }}</dd></div>
                <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Status</dt><dd class="font-medium text-crm-text"><span class="px-2.5 py-1 rounded-full text-xs font-medium border {{ $reclamation->status === 'traité' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' }}">{{ $reclamation->status }}</span></dd></div>
                <div class="bg-crm-bg3 p-3 rounded-crm"><dt class="text-crm-muted mb-1 text-xs uppercase">Assigned To</dt><dd class="font-medium text-crm-text">{{ $reclamation->assignedTo?->name ?? 'Not Assigned' }}</dd></div>
            </dl>
            <div class="mt-4 pt-4 border-t border-crm-border">
                <h3 class="text-crm-muted mb-2 text-xs uppercase">Description</h3>
                <p class="text-sm text-crm-text leading-relaxed whitespace-pre-wrap">{{ $reclamation->description }}</p>
            </div>
            @if($reclamation->response)
            <div class="mt-4 pt-4 border-t border-crm-border">
                <h3 class="text-crm-muted mb-2 text-xs uppercase">Response</h3>
                <p class="text-sm text-crm-text leading-relaxed whitespace-pre-wrap">{{ $reclamation->response }}</p>
            </div>
            @endif
        </div>

        <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
            <h2 class="font-semibold text-crm-text mb-3 tracking-wide uppercase text-xs">Assign to Employee</h2>
            <form method="POST" action="{{ route('admin.reclamations.assign', $reclamation) }}">
                @csrf
                <div class="flex gap-2">
                    <select name="assigned_to" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" required>
                        <option value="">Select Employee...</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" @selected($reclamation->assigned_to == $emp->id)>{{ $emp->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-crm-accent text-white px-5 py-2.5 rounded-crm hover:bg-blue-500 font-bold transition-all duration-200 text-sm">Assign</button>
                </div>
            </form>
        </div>

        <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
            <h2 class="font-semibold text-crm-text mb-3 tracking-wide uppercase text-xs">Reply</h2>
            <form method="POST" action="{{ route('admin.reclamations.reply', $reclamation) }}">
                @csrf
                <textarea name="response" rows="4" required placeholder="Type your reply..." class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5 mb-3">{{ old('response', $reclamation->response) }}</textarea>
                <button type="submit" class="bg-crm-accent text-white px-5 py-2.5 rounded-crm hover:bg-blue-500 font-bold transition-all duration-200 text-sm">Send Reply</button>
            </form>
        </div>

        <div class="bg-red-500/10 border border-red-500/20 rounded-crm p-6">
            <h3 class="text-red-400 font-semibold mb-2">Danger Zone</h3>
            <form method="POST" action="{{ route('admin.reclamations.destroy', $reclamation) }}" onsubmit="return confirm('Are you sure you want to delete this reclamation?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm font-bold">Delete Reclamation</button>
            </form>
        </div>
    </div>
@endsection
