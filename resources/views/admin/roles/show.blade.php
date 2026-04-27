@extends('layouts.app')
@section('title','Role Details')
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.roles.index') }}" class="text-crm-muted hover:text-crm-accent transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="text-2xl font-bold text-crm-text">Role: {{ ucfirst($role->name) }}</h1>
</div>

<div class="bg-crm-bg2 border border-crm-border rounded-crm p-6 max-w-2xl">
    <h2 class="text-sm font-semibold text-crm-text mb-4">Permissions assigned</h2>

    @if($rolePermissions->count())
    {{-- Group permissions by prefix --}}
    @php $grouped = $rolePermissions->groupBy(fn($p) => explode('-', $p->name)[0]); @endphp
    <div class="space-y-4">
        @foreach($grouped as $group => $perms)
        <div class="bg-crm-bg3 border border-crm-border rounded-crm p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-crm-accent mb-3">{{ ucfirst($group) }}</p>
            <div class="flex flex-wrap gap-2">
                @foreach($perms as $perm)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-crm-accent/15 text-crm-accent">
                    {{ $perm->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-sm text-crm-muted italic">No permissions assigned to this role.</p>
    @endif

    <div class="mt-6 pt-4 border-t border-crm-border flex gap-3">
        @can('role-edit')
        <a href="{{ route('admin.roles.edit', $role) }}" class="px-4 py-2 bg-yellow-500/10 hover:bg-yellow-500/20 text-yellow-400 text-sm font-medium rounded-crm border border-yellow-500/20 transition-colors">Edit Role</a>
        @endcan
        <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 text-crm-muted hover:text-crm-text text-sm transition-colors">Back to Roles</a>
    </div>
</div>
@endsection