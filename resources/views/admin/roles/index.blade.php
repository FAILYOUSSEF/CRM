@extends('layouts.app')
@section('title','Roles')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Roles</h1>
        <p class="text-sm text-crm-muted mt-1">Manage roles and their permissions</p>
    </div>
    @can('role-create')
    <a href="{{ route('admin.roles.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-black transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">
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
                    <div class="flex items-center gap-3">
                        @can('role-list')
                        <a href="{{ route('admin.roles.show', $role) }}" title="View" aria-label="View role" class="text-crm-muted hover:text-crm-accent transition-colors font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        @endcan
                        @can('role-edit')
                        <a href="{{ route('admin.roles.edit', $role) }}" title="Edit" aria-label="Edit role" class="text-crm-muted hover:text-yellow-400 transition-colors font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        @endcan
                        @can('role-delete')
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Delete this role?')">
                            @csrf @method('DELETE')
                            <button title="Delete" aria-label="Delete role" class="text-crm-muted hover:text-red-400 transition-colors font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
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
