@extends('layouts.app')
@section('title', 'User Details')
@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-crm-muted hover:text-crm-accent transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="text-2xl font-bold text-crm-text">User Details</h1>
</div>

<div class="bg-crm-bg2 border border-crm-border rounded-crm p-6 max-w-2xl">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <label class="block text-xs font-semibold text-crm-muted mb-2">Name</label>
            <p class="text-lg text-crm-text font-medium">{{ $user->name }}</p>
        </div>
        <div>
            <label class="block text-xs font-semibold text-crm-muted mb-2">Email</label>
            <p class="text-lg text-crm-text font-medium">{{ $user->email }}</p>
        </div>
        <div>
            <label class="block text-xs font-semibold text-crm-muted mb-2">Roles</label>
            <div class="flex flex-wrap gap-2">
                @forelse($user->getRoleNames() as $role)
                    <span class="bg-crm-accent/20 text-crm-accent text-xs font-medium px-2.5 py-1 rounded-crm">{{ ucfirst($role) }}</span>
                @empty
                    <p class="text-crm-muted text-sm">No role assigned</p>
                @endforelse
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-crm-muted mb-2">Member Since</label>
            <p class="text-lg text-crm-text font-medium">{{ $user->created_at->format('F j, Y') }}</p>
        </div>
        <div>
            <label class="block text-xs font-semibold text-crm-muted mb-2">Type</label>
            <p class="text-lg text-crm-text font-medium capitalize">{{ $user->type_client }}</p>
        </div>
        <div>
            <label class="block text-xs font-semibold text-crm-muted mb-2">Status</label>
            <p class="text-lg font-medium capitalize">
                <span class="px-3 py-1 rounded-crm {{ $user->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">{{ $user->status }}</span>
            </p>
        </div>
    </div>

    <div class="flex items-center gap-3 pt-4 border-t border-crm-border">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="px-5 py-2.5 bg-crm-accent hover:bg-crm-accent/90 text-white text-sm font-medium rounded-crm transition-colors">Edit User</a>
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-5 py-2.5 bg-red-500/20 hover:bg-red-500/30 text-red-400 text-sm font-medium rounded-crm transition-colors">Delete User</button>
        </form>
    </div>
</div>
@endsection