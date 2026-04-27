@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">{{ $meeting->titre }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.meetings.edit', $meeting->id) }}" class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-4 py-2.5 rounded-crm hover:bg-yellow-500 hover:text-white transition-all duration-200 text-sm font-bold">Edit Meeting</a>
            <a href="{{ route('admin.meetings.index') }}" class="bg-gray-500/10 text-gray-400 border border-gray-500/20 px-4 py-2.5 rounded-crm hover:bg-gray-500 hover:text-crm-text transition-all duration-200 text-sm font-bold">Back to Meetings</a>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
            <h2 class="font-semibold text-crm-text mb-4 tracking-wide uppercase text-xs">Meeting Details</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-4">
                <div class="bg-crm-bg3 p-3 rounded-crm">
                    <dt class="text-crm-muted mb-1 text-xs uppercase">Scheduled At</dt>
                    <dd class="font-medium text-crm-text">{{ \Carbon\Carbon::parse($meeting->date_heure)->format('F j, Y, g:i a') }}</dd>
                </div>
                <div class="bg-crm-bg3 p-3 rounded-crm">
                    <dt class="text-crm-muted mb-1 text-xs uppercase">Type</dt>
                    <dd class="font-medium text-crm-text capitalize">{{ $meeting->type }}</dd>
                </div>
                <div class="bg-crm-bg3 p-3 rounded-crm">
                    <dt class="text-crm-muted mb-1 text-xs uppercase">Location</dt>
                    <dd class="font-medium text-crm-text">{{ $meeting->lieu ?? 'N/A' }}</dd>
                </div>
                <div class="bg-crm-bg3 p-3 rounded-crm">
                    <dt class="text-crm-muted mb-1 text-xs uppercase">Status</dt>
                    <dd class="font-medium text-crm-text">
                        <span class="capitalize px-2.5 py-1 text-xs font-semibold rounded-full border
                            @if($meeting->status == 'planifié') bg-blue-500/10 text-blue-400 border-blue-500/20
                            @elseif($meeting->status == 'terminé') bg-green-500/10 text-green-400 border-green-500/20
                            @else bg-red-500/10 text-red-400 border-red-500/20 @endif">
                            {{ $meeting->status }}
                        </span>
                    </dd>
                </div>
                @if($meeting->type === 'online' && $meeting->link)
                <div class="bg-crm-bg3 p-3 rounded-crm sm:col-span-2">
                    <dt class="text-crm-muted mb-1 text-xs uppercase">Meeting Link</dt>
                    <dd class="font-medium text-crm-text">
                        <a href="{{ $meeting->link }}" target="_blank" class="text-crm-accent hover:text-blue-400 transition-colors">{{ $meeting->link }}</a>
                    </dd>
                </div>
                @endif
            </dl>

            @if($meeting->description)
            <div class="mt-4 pt-4 border-t border-crm-border">
                <h3 class="text-crm-muted mb-2 text-xs uppercase">Description / Agenda</h3>
                <p class="text-sm text-crm-text leading-relaxed whitespace-pre-wrap">{{ $meeting->description }}</p>
            </div>
            @endif

            <div class="mt-4 pt-4 border-t border-crm-border">
                <h3 class="text-crm-muted mb-2 text-xs uppercase">Participants ({{ $meeting->participants->count() }})</h3>
                <ul class="text-crm-text space-y-2">
                    @forelse($meeting->participants as $participant)
                        <li class="py-1">
                            {{ $participant->name }}
                            <span class="text-sm text-crm-muted">({{ $participant->type_client }})</span>
                            @if($participant->pivot->response)
                                - <span class="text-xs px-2 py-1 rounded-full @if($participant->pivot->response == 'accepted') bg-green-500/10 text-green-400 @else bg-red-500/10 text-red-400 @endif">
                                    {{ ucfirst($participant->pivot->response) }}
                                </span>
                            @endif
                        </li>
                    @empty
                        <li class="text-crm-muted italic">No participants added yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="bg-red-500/10 border border-red-500/20 rounded-crm p-6">
            <h3 class="text-red-400 font-semibold mb-2">Danger Zone</h3>
            <form method="POST" action="{{ route('admin.meetings.destroy', $meeting->id) }}" onsubmit="return confirm('Are you sure you want to delete this meeting?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm font-bold">Delete Meeting</button>
            </form>
        </div>
    </div>
@endsection
