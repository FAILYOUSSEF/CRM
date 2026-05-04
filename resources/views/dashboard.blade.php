@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-crm-text tracking-tight">Dashboard Overview</h1>
            <p class="text-sm text-crm-muted mt-1">Welcome back, {{ Auth::user()->name ?? 'Admin' }}! Here is what's happening today.</p>
        </div>
        <div class="hidden sm:flex gap-3">
            <a href="{{ route('admin.projects.create') }}" class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm">New Project</a>
            <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm shadow-indigo-600/20">Add User</a>
        </div>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm shadow-gray-200/50 flex items-center gap-4 hover:border-indigo-200 transition-colors">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Active Projects</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $projectCount }}</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm shadow-gray-200/50 flex items-center gap-4 hover:border-amber-200 transition-colors">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Pending Tasks</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $taskCount }}</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm shadow-gray-200/50 flex items-center gap-4 hover:border-red-200 transition-colors">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Open Tickets</h3>
                <p class="text-2xl font-bold text-red-600">{{ $ticketCount }}</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm shadow-gray-200/50 flex items-center gap-4 hover:border-emerald-200 transition-colors">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-1a3 3 0 00-5.356-1.857M17 20H7m10 0v-1c0-.656-.126-1.283-.356-1.857M7 20H2v-1a3 3 0 015.356-1.857M7 20v-1c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-gray-500 text-sm font-medium">Active Users</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $clientCount }} <span class="text-xs text-gray-400 font-normal border-l border-gray-300 pl-1 ml-1">{{ $employeeCount }} Staff</span></p>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Tickets -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm shadow-gray-200/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h2 class="font-bold text-gray-900">Recent Open Tickets</h2>
                <a href="{{ route('admin.tickets.index', ['status' => 'ouvert']) }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">View All</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($recentTickets as $ticket)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 mb-1">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="hover:text-indigo-600 transition-colors">{{ $ticket->sujet }}</a>
                                </h3>
                                <p class="text-xs text-gray-500">{{ $ticket->user->name ?? 'Unknown' }} • Project: {{ $ticket->project->titre ?? 'N/A' }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium border bg-red-50 text-red-600 border-red-200">
                                {{ $ticket->priorite }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">No open tickets at the moment.</div>
                @endforelse
            </div>
        </div>

        <!-- Pending Meeting Requests -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm shadow-gray-200/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h2 class="font-bold text-gray-900">Pending Meeting Requests</h2>
                <a href="{{ route('admin.meetings.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">Manage All</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($pendingMeetings as $req)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 mb-1">{{ $req->titre }}</h3>
                                <p class="text-xs text-gray-500">Requested by: <span class="font-medium text-gray-700">{{ $req->requester->name ?? 'Unknown' }}</span></p>
                                @if($req->preferred_date)
                                    <p class="text-xs text-gray-500 mt-1">Preferred Date: {{ \Carbon\Carbon::parse($req->preferred_date)->format('d M Y') }}</p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('admin.meetings.acceptRequest', $req) }}">
                                    @csrf <button type="submit" class="text-emerald-600 bg-emerald-50 hover:bg-emerald-100 p-2 rounded-lg transition-colors border border-emerald-200" title="Accept"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                                </form>
                                <form method="POST" action="{{ route('admin.meetings.refuseRequest', $req) }}">
                                    @csrf <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors border border-red-200" title="Refuse"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">No pending meeting requests.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
