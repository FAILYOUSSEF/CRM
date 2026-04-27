@extends('layouts.app')
@section('title','Categories')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-crm-text tracking-tight">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-blue-500 transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">+ New Category</a>
</div>
<div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-crm-bg2 border-b border-crm-border text-crm-muted uppercase text-xs font-semibold">
            <tr><th class="px-6 py-4">Name</th><th class="px-6 py-4">Description</th><th class="px-6 py-4">Tickets</th><th class="px-6 py-4 text-right">Actions</th></tr>
        </thead>
        <tbody class="divide-y divide-crm-border">
            @forelse($categories as $cat)
            <tr class="hover:bg-crm-bg3/50 transition-colors group">
                <td class="px-6 py-4 font-medium text-crm-text">{{ $cat->name }}</td>
                <td class="px-6 py-4 text-crm-muted">{{ $cat->description ?? '—' }}</td>
                <td class="px-6 py-4 text-crm-muted">{{ $cat->tickets_count }}</td>
                <td class="px-6 py-4 flex justify-end gap-4">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="text-yellow-400 hover:text-yellow-300 transition-colors font-medium">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-300 transition-colors font-medium">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-12 text-center text-crm-muted">No categories found. Create one to get started!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
