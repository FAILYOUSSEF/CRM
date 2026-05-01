@extends('layouts.app')
@section('title','Categories')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-crm-text tracking-tight">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-black transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">+ New Category</a>
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
                <td class="px-6 py-4 flex justify-end gap-3">
                    <a href="{{ route('admin.categories.edit', $cat) }}" title="Edit" aria-label="Edit category" class="text-crm-muted hover:text-yellow-400 transition-colors font-medium text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button title="Delete" aria-label="Delete category" class="text-crm-muted hover:text-red-400 transition-colors font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-12 text-center text-crm-muted">No categories found. Create one to get started!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection
