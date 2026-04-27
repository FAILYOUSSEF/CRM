@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Reclamations</h1>
    </div>
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-crm-bg2 border-b border-crm-border text-crm-muted uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">From</th>
                    <th class="px-6 py-4">Type</th>
                    <th class="px-6 py-4">Priority</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-crm-border">
                @forelse($reclamations as $rec)
                <tr class="hover:bg-crm-bg3/50 transition-colors group">
                    <td class="px-6 py-4 font-medium text-crm-text">{{ $rec->titre }}</td>
                    <td class="px-6 py-4 text-crm-muted">{{ $rec->user->name }}</td>
                    <td class="px-6 py-4 text-crm-muted">{{ $rec->type ?? '—' }}</td>
                    <td class="px-6 py-4 text-crm-muted">{{ $rec->priorite }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium border {{ $rec->status === 'traité' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' }}">{{ $rec->status }}</span>
                    </td>
                    <td class="px-6 py-4 flex justify-end gap-4">
                        <a href="{{ route('admin.reclamations.show', $rec) }}" class="text-crm-accent hover:text-blue-400 transition-colors font-medium">View / Reply</a>
                        <form method="POST" action="{{ route('admin.reclamations.destroy', $rec) }}" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 transition-colors font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-crm-muted">No reclamations found. Create one to get started!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6 text-crm-muted">{{ $reclamations->links() }}</div>
@endsection
