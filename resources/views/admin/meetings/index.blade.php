@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Meetings</h1>
        <a href="{{ route('admin.meetings.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-black transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">
            Schedule Meeting
        </a>
    </div>

    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-crm-bg2 border-b border-crm-border text-crm-muted uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Participants</th>
                    <th class="px-6 py-4">Scheduled At</th>
                    <th class="px-6 py-4">Type</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-crm-border">
                @forelse ($meetings as $meeting)
                    <tr class="hover:bg-crm-bg3/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-crm-text">{{ $meeting->titre }}</td>
                        <td class="px-6 py-4 text-crm-muted text-sm">{{ $meeting->participants->count() }} participant(s)</td>
                        <td class="px-6 py-4 text-crm-muted">{{ \Carbon\Carbon::parse($meeting->date_heure)->format('M d, Y H:i A') }}</td>
                        <td class="px-6 py-4 text-crm-muted capitalize">{{ $meeting->type }}</td>
                        <td class="px-6 py-4">
                            <span class="capitalize px-2.5 py-1 rounded-full text-xs font-semibold border
                                @if($meeting->status == 'planifié') bg-blue-500/10 text-blue-400 border-blue-500/20
                                @elseif($meeting->status == 'terminé') bg-green-500/10 text-green-400 border-green-500/20
                                @else bg-red-500/10 text-red-400 border-red-500/20 @endif">
                                {{ $meeting->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex justify-end gap-3">
                            <a href="{{ route('admin.meetings.show', $meeting->id) }}" title="View" aria-label="View meeting" class="text-crm-muted hover:text-crm-accent transition-colors font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.meetings.edit', $meeting->id) }}" title="Edit" aria-label="Edit meeting" class="text-crm-muted hover:text-yellow-400 transition-colors font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.meetings.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" aria-label="Delete meeting" class="text-crm-muted hover:text-red-400 transition-colors font-medium text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-crm-muted">No meetings found. Create one to get started!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6 text-crm-muted">
        {{ $meetings->links() }}
    </div>

    <!-- Pending Meeting Requests Section -->
    <div class="mt-8 bg-crm-surface border border-crm-border rounded-crm shadow-sm overflow-hidden">
        <div class="bg-crm-bg2 border-b border-crm-border px-6 py-4">
            <h2 class="text-lg font-bold text-crm-text">Pending Meeting Requests</h2>
        </div>
        <div class="divide-y divide-crm-border">
            @forelse($requests as $req)
                <div class="p-6 hover:bg-crm-bg3/50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-crm-text mb-2">{{ $req->titre }}</h3>
                            <p class="text-xs text-crm-muted mb-1">Requested by: <span class="font-medium text-crm-text">{{ $req->requester->name ?? 'Unknown' }}</span></p>
                            @if($req->description)
                                <p class="text-xs text-crm-muted mb-2">{{ $req->description }}</p>
                            @endif
                            @if($req->preferred_date)
                                <p class="text-xs text-crm-muted">Preferred Date: <span class="font-medium text-crm-text">{{ \Carbon\Carbon::parse($req->preferred_date)->format('d M Y') }}</span></p>
                            @endif
                        </div>
                        <div class="flex gap-2 ml-4">
                            <form method="POST" action="{{ route('admin.meetings.acceptRequest', $req) }}">
                                @csrf
                                <button type="submit" title="Accept" class="bg-green-500/10 hover:bg-green-500/20 text-green-500 px-3 py-2 rounded-crm transition-colors border border-green-500/30 text-xs font-medium">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Accept
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.meetings.refuseRequest', $req) }}">
                                @csrf
                                <button type="submit" title="Refuse" class="bg-red-500/10 hover:bg-red-500/20 text-red-500 px-3 py-2 rounded-crm transition-colors border border-red-500/30 text-xs font-medium">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Refuse
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-crm-muted text-sm">No pending meeting requests.</div>
            @endforelse
        </div>
    </div>
@endsection
