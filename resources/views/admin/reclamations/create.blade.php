@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Create New Reclamation</h1>
        <p class="text-sm text-crm-muted mt-1">File a new reclamation on behalf of a user.</p>
    </div>

    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6 sm:p-8 max-w-2xl">
        <form method="POST" action="{{ route('admin.reclamations.store') }}" class="space-y-6">
        @csrf
        <div>
            <label for="titre" class="block text-sm font-medium text-crm-muted mb-1">Title</label>
            <input type="text" name="titre" id="titre" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" required value="{{ old('titre') }}">
            @error('titre') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-crm-muted mb-1">Type</label>
            <select name="type" id="type" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" required onchange="handleTypeChange()">
                <option value="">-- Select Type --</option>
                <option value="billing" @selected(old('type') == 'billing')>Billing</option>
                <option value="product" @selected(old('type') == 'product')>Product/Service</option>
                <option value="delivery" @selected(old('type') == 'delivery')>Delivery</option>
                <option value="quality" @selected(old('type') == 'quality')>Quality</option>
                <option value="other" @selected(old('type') == 'other')>Other</option>
            </select>
            @error('type') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div id="type_other_div" style="display: {{ old('type') == 'other' ? 'block' : 'none' }};">
            <label for="type_other" class="block text-sm font-medium text-crm-muted mb-1">Other Type (Please specify)</label>
            <input type="text" name="type_other" id="type_other" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" value="{{ old('type_other') }}">
            @error('type_other') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="priorite" class="block text-sm font-medium text-crm-muted mb-1">Priority</label>
            <select name="priorite" id="priorite" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" required>
                <option value="faible" @selected(old('priorite') == 'faible')>Low</option>
                <option value="moyenne" @selected(old('priorite') == 'moyenne')>Medium</option>
                <option value="haute" @selected(old('priorite') == 'haute')>High</option>
                <option value="critique" @selected(old('priorite') == 'critique')>Critical</option>
            </select>
            @error('priorite') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-crm-muted mb-1">Description</label>
            <textarea name="description" id="description" rows="4" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text placeholder-crm-muted/50 focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5">{{ old('description') }}</textarea>
            @error('description') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="assigned_to" class="block text-sm font-medium text-crm-muted mb-1">Assign To (Optional)</label>
            <select name="assigned_to" id="assigned_to" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5">
                <option value="">-- Not Assigned --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('assigned_to') == $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('assigned_to') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-crm-muted mb-1">Status</label>
            <select name="status" id="status" class="block w-full bg-crm-bg3 border border-crm-border rounded-crm text-crm-text focus:ring-2 focus:ring-crm-accent focus:border-crm-accent transition-all duration-200 sm:text-sm py-2.5" required>
                <option value="en attente" @selected(old('status') == 'en attente')>Pending</option>
                <option value="traité" @selected(old('status') == 'traité')>Treated</option>
                <option value="resolu" @selected(old('status') == 'resolu')>Resolved</option>
            </select>
            @error('status') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-crm-border mt-6">
            <button type="submit" class="bg-crm-accent text-white px-5 py-2.5 rounded-crm hover:bg-black font-bold transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5">
                Create Reclamation
            </button>
            <a href="{{ route('admin.reclamations.index') }}" class="text-crm-muted hover:text-crm-text transition-colors text-sm font-medium">Cancel</a>
        </div>
        </form>
    </div>

    <script>
    function handleTypeChange() {
        const typeSelect = document.getElementById('type');
        const typeOtherDiv = document.getElementById('type_other_div');
        if (typeSelect.value === 'other') {
            typeOtherDiv.style.display = 'block';
        } else {
            typeOtherDiv.style.display = 'none';
        }
    }
    </script>
@endsection

