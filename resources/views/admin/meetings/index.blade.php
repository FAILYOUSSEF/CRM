@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Meetings</h1>
        <a href="{{ route('admin.meetings.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-blue-500 transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">
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
                        <td class="px-6 py-4 flex justify-end gap-4">
                            <a href="{{ route('admin.meetings.show', $meeting->id) }}" class="text-crm-accent hover:text-blue-400 transition-colors font-medium">Show</a>
                            <a href="{{ route('admin.meetings.edit', $meeting->id) }}" class="text-yellow-400 hover:text-yellow-300 transition-colors font-medium">Edit</a>
                            <form action="{{ route('admin.meetings.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition-colors font-medium">Delete</button>
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
@endsection
