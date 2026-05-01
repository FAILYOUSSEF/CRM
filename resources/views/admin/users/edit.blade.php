@extends('layouts.app')
@section('title','Edit User')
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.users.index') }}" class="text-crm-muted hover:text-crm-accent transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="text-2xl font-bold text-crm-text">Edit: {{ $user->name }}</h1>
</div>

<div class="bg-crm-bg2 border border-crm-border rounded-crm p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Full Name *</label>
                <input name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">New Password <span class="text-crm-muted text-opacity-70">(leave blank to keep)</span></label>
                <input type="password" name="password"
                    class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Type *</label>
                <select name="type_client" required class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                    @foreach(['admin','employee','client'] as $t)
                        <option value="{{ $t }}" {{ $user->type_client===$t?'selected':'' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Status</label>
                <select name="status" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
                    <option value="active" {{ $user->status==='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ $user->status==='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
        </div>

        {{-- Spatie Role assignment --}}
        <div>
            <label class="block text-xs font-medium text-crm-muted mb-1.5">Roles *</label>
            <div class="bg-crm-bg3 border border-crm-border rounded-crm p-3 flex flex-wrap gap-3">
                @foreach($roles as $roleName)
                <label class="flex items-center gap-2 text-sm text-crm-text cursor-pointer hover:text-crm-accent">
                    <input type="checkbox" name="roles[]" value="{{ $roleName }}"
                        {{ array_key_exists($roleName, $userRole) ? 'checked' : '' }}
                        class="w-3.5 h-3.5 accent-crm-accent">
                    {{ ucfirst($roleName) }}
                </label>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Phone</label>
                <input name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Salary (MAD)</label>
                <input type="number" step="0.01" name="salaire" value="{{ old('salaire', $user->salaire) }}"
                    class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">CIN</label>
                <input name="cin" value="{{ old('cin', $user->cin) }}" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Contract Type</label>
                <input name="type_contrat" value="{{ old('type_contrat', $user->type_contrat) }}" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Address</label>
                <input name="addresse" value="{{ old('addresse', $user->addresse) }}" class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-3.5 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-crm-muted mb-1.5">Contract File</label>
                <input type="file" name="fichier_de_contrat" class="text-sm text-crm-muted">
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-crm-border">
            <button type="submit" class="px-5 py-2.5 bg-crm-accent hover:bg-crm-accent/90 text-white text-sm font-medium rounded-crm transition-colors">Save Changes</button>
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-crm-muted hover:text-crm-text text-sm transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
