@extends('layouts.app')
@section('title','Roles')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Roles</h1>
        <p class="text-sm text-crm-muted mt-1">Manage roles and their permissions</p>
    </div>
    @can('role-create')
    <a href="{{ route('admin.roles.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-blue-500 transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">
        + New Role
    </a>
    @endcan
</div>

<div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-crm-bg2 border-b border-crm-border">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-crm-muted">#</th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-crm-muted">Role Name</th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-crm-muted">Permissions</th>
                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-crm-muted">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-crm-border">
            @forelse($roles as $i => $role)
            <tr class="hover:bg-crm-bg3/50 transition-colors">
                <td class="px-6 py-4 text-crm-muted">{{ $i + 1 }}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border
                        {{ $role->name === 'admin' ? 'bg-violet-500/10 text-violet-400 border-violet-500/20' :
                          ($role->name === 'employee' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-green-500/10 text-green-400 border-green-500/20') }}">
                        {{ ucfirst($role->name) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-crm-accent/10 text-crm-accent border border-crm-accent/20">
                        {{ $role->permissions_count }} permissions
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @can('role-list')
                        <a href="{{ route('admin.roles.show', $role) }}" class="px-2.5 py-1 rounded-crm text-xs font-medium text-crm-accent hover:bg-crm-accent/10 transition-colors">View</a>
                        @endcan
                        @can('role-edit')
                        <a href="{{ route('admin.roles.edit', $role) }}" class="px-2.5 py-1 rounded-crm text-xs font-medium text-yellow-400 hover:bg-yellow-500/10 transition-colors">Edit</a>
                        @endcan
                        @can('role-delete')
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Delete this role?')">
                            @csrf @method('DELETE')
                            <button class="px-2.5 py-1 rounded-crm text-xs font-medium text-red-400 hover:bg-red-500/10 transition-colors">Delete</button>
                        </form>
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-12 text-center text-crm-muted">No roles found. Create one to get started!</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-crm-border bg-crm-bg2/50 text-crm-muted">{{ $roles->links() }}</div>
</div>
@endsection