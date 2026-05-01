@extends('layouts.app')
@section('title','Users')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-crm-text tracking-tight">Users</h1>
    <a href="{{ route('admin.users.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-black transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">+ New User</a>
</div>

<!-- Dashboard Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Total Users -->
    <div class="bg-crm-surface border border-crm-border rounded-crm p-5 shadow-sm flex items-center justify-between transition-transform hover:-translate-y-1 duration-300">
        <div>
            <p class="text-sm font-medium text-crm-muted mb-1">Total Users</p>
            <h3 class="text-3xl font-bold text-crm-text">{{ $totalUsers ?? 0 }}</h3>
        </div>
        <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>
    <!-- Active Users -->
    <div class="bg-crm-surface border border-crm-border rounded-crm p-5 shadow-sm flex items-center justify-between transition-transform hover:-translate-y-1 duration-300">
        <div>
            <p class="text-sm font-medium text-crm-muted mb-1">Active Accounts</p>
            <h3 class="text-3xl font-bold text-crm-text">{{ $activeUsersCount ?? 0 }}</h3>
        </div>
        <div class="p-3 bg-green-500/10 rounded-xl text-green-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
    <!-- New This Month -->
    <div class="bg-crm-surface border border-crm-border rounded-crm p-5 shadow-sm flex items-center justify-between transition-transform hover:-translate-y-1 duration-300">
        <div>
            <p class="text-sm font-medium text-crm-muted mb-1">New This Month</p>
            <h3 class="text-3xl font-bold text-crm-text">{{ $newUsersCount ?? 0 }}</h3>
        </div>
        <div class="p-3 bg-violet-500/10 rounded-xl text-violet-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>

<!-- Faceted Search & Filter -->
<div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm mb-6 p-4">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users by name or email..." class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors placeholder-crm-muted">
        </div>
        <div class="w-full md:w-48">
            <select name="role" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="employee" {{ request('role') === 'employee' ? 'selected' : '' }}>Employee</option>
                <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Client</option>
            </select>
        </div>
        <div class="w-full md:w-48">
            <select name="status" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="bg-crm-accent hover:bg-crm-accent/90 text-white px-5 py-2.5 rounded-crm transition-colors text-sm font-medium">Filter</button>
            @if(request('search') || request('role') || request('status'))
                <a href="{{ route('admin.users.index') }}" class="text-crm-muted hover:text-crm-text px-4 py-2.5 text-sm transition-colors">Clear</a>
            @endif
        </div>
    </form>
</div>

<div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-crm-bg2 border-b border-crm-border text-crm-muted uppercase text-xs font-semibold">
            <tr>
                <th class="px-6 py-4">
                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_dir' => request('sort_by') === 'name' && request('sort_dir') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-crm-text transition-colors group">
                        Name
                        <span class="text-crm-muted group-hover:text-crm-text transition-colors">
                            @if(request('sort_by') === 'name')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('sort_dir') === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                            @else
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-50 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                            @endif
                        </span>
                    </a>
                </th>
                <th class="px-6 py-4">
                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'email', 'sort_dir' => request('sort_by') === 'email' && request('sort_dir') === 'asc' ? 'desc' : 'asc']) }}" class="flex items-center gap-1 hover:text-crm-text transition-colors group">
                        Email
                        <span class="text-crm-muted group-hover:text-crm-text transition-colors">
                            @if(request('sort_by') === 'email')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ request('sort_dir') === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path></svg>
                            @else
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-50 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                            @endif
                        </span>
                    </a>
                </th>
                <th class="px-6 py-4">Role</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-crm-border">
            @forelse($users as $user)
            <tr class="hover:bg-crm-bg3/50 transition-colors group">
                <td class="px-6 py-4 font-medium text-crm-text">{{ $user->name }}</td>
                <td class="px-6 py-4 text-crm-muted">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium border
                        {{ $user->type_client === 'admin' ? 'bg-violet-500/10 text-violet-400 border-violet-500/20' :
                          ($user->type_client === 'employee' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-green-500/10 text-green-400 border-green-500/20') }}">
                        {{ ucfirst($user->type_client) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium border {{ $user->status === 'active' ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20' }}">{{ $user->status }}</span>
                </td>
                <td class="px-6 py-4 flex justify-end gap-3">
                    <a href="{{ route('admin.users.show', $user) }}" title="View" aria-label="View user" class="text-crm-muted hover:text-crm-accent transition-colors font-medium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    <a href="{{ route('admin.users.edit', $user) }}" title="Edit" aria-label="Edit user" class="text-crm-muted hover:text-yellow-400 transition-colors font-medium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete user?')">
                        @csrf @method('DELETE')
                        <button title="Delete" aria-label="Delete user" class="text-crm-muted hover:text-red-400 transition-colors font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-12 text-center text-crm-muted">No users found. Create one to get started!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6 text-crm-muted">
    {{ $users->links() }}
</div>
@endsection
