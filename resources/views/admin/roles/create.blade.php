@extends('layouts.app')
@section('title','New Role')
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.roles.index') }}" class="text-crm-muted hover:text-crm-accent transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="text-2xl font-bold text-crm-text">New Role</h1>
</div>

<div class="bg-crm-bg2 border border-crm-border rounded-crm p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-6">
        @csrf
        <div>
            <label class="block text-xs font-medium text-crm-muted mb-1.5">Role Name *</label>
            <input name="name" value="{{ old('name') }}" required placeholder="e.g. manager"
                class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text placeholder-crm-muted outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
        </div>

        <div>
            <label class="block text-xs font-medium text-crm-muted mb-3">Permissions</label>
            <div class="space-y-4">
                @foreach($permissions as $group => $perms)
                <div class="bg-crm-bg3 border border-crm-border rounded-crm p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-crm-accent mb-3">{{ ucfirst($group) }}</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($perms as $perm)
                        <label class="flex items-center gap-2.5 text-sm text-crm-text cursor-pointer hover:text-crm-accent group">
                            <input type="checkbox" name="permission[]" value="{{ $perm->name }}"
                                {{ in_array($perm->name, old('permission', [])) ? 'checked' : '' }}
                                class="w-3.5 h-3.5 accent-crm-accent rounded">
                            <span class="group-hover:text-crm-accent transition-colors">{{ $perm->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-crm-border">
            <button type="submit" class="px-5 py-2.5 bg-crm-accent hover:bg-black text-white text-sm font-medium rounded-crm transition-colors">Create Role</button>
            <a href="{{ route('admin.roles.index') }}" class="px-5 py-2.5 text-crm-muted hover:text-crm-text text-sm transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
