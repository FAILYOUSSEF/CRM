@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Tickets</h1>
    </div>
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-crm-bg2 border-b border-crm-border text-crm-muted uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Subject</th>
                    <th class="px-6 py-4">Project</th>
                    <th class="px-6 py-4">From</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-crm-border">
                @forelse($tickets as $ticket)
                <tr class="hover:bg-crm-bg3/50 transition-colors group">
                    <td class="px-6 py-4 font-medium text-crm-text">{{ $ticket->sujet }}</td>
                    <td class="px-6 py-4 text-crm-muted">{{ $ticket->project->titre }}</td>
                    <td class="px-6 py-4 text-crm-muted">{{ $ticket->user->name }}</td>
                    <td class="px-6 py-4 text-crm-muted">{{ $ticket->category?->name ?? '—' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium border capitalize {{ $ticket->status === 'fermé' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' }}">
                            {{ $ticket->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 flex justify-end gap-3">
                        <a href="{{ route('admin.tickets.show', $ticket) }}" title="View / Reply" aria-label="View and reply to ticket" class="text-crm-muted hover:text-crm-accent transition-colors font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button title="Delete" aria-label="Delete ticket" class="text-crm-muted hover:text-red-400 transition-colors font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-crm-muted">No tickets found. Create one to get started!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6 text-crm-muted">{{ $tickets->links() }}</div>
@endsection


