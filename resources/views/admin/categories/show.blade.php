@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-crm-text tracking-tight">{{ $category->name }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-4 py-2.5 rounded-crm hover:bg-yellow-500 hover:text-white transition-all duration-200 text-sm font-bold">Edit Category</a>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-500/10 text-gray-400 border border-gray-500/20 px-4 py-2.5 rounded-crm hover:bg-gray-500 hover:text-crm-text transition-all duration-200 text-sm font-bold">Back</a>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Category Details -->
            <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
                <h2 class="font-semibold text-crm-text mb-4 tracking-wide uppercase text-xs">Category Details</h2>
                <dl class="grid grid-cols-1 gap-4 text-sm">
                    @if($category->description)
                    <div class="bg-crm-bg3 p-3 rounded-crm">
                        <dt class="text-crm-muted mb-1 text-xs uppercase">Description</dt>
                        <dd class="text-crm-text">{{ $category->description }}</dd>
                    </div>
                    @endif
                    <div class="bg-crm-bg3 p-3 rounded-crm">
                        <dt class="text-crm-muted mb-1 text-xs uppercase">Created At</dt>
                        <dd class="text-crm-text">{{ $category->created_at?->format('M d, Y H:i A') ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Related Tickets -->
            <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm p-6">
                <h2 class="font-semibold text-crm-text mb-4 tracking-wide uppercase text-xs">Related Tickets ({{ $category->tickets()->count() }})</h2>
                @if($category->tickets()->count() > 0)
                <div class="space-y-2">
                    @foreach($category->tickets as $ticket)
                    <div class="flex items-center justify-between p-3 rounded-crm bg-crm-bg3 border border-crm-border hover:border-crm-accent/50 transition-colors group">
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-crm-text font-medium group-hover:text-crm-accent transition-colors flex-1">{{ $ticket->sujet }}</a>
                        <span class="text-xs px-2.5 py-1 rounded-full bg-crm-accent/10 text-crm-accent border border-crm-accent/20">{{ ucfirst($ticket->status) }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-crm-muted text-sm italic">No tickets assigned to this category yet.</p>
                @endif
            </div>

            <!-- Delete Action -->
            <div class="bg-red-500/10 border border-red-500/20 rounded-crm p-6">
                <h3 class="text-red-400 font-semibold mb-2">Danger Zone</h3>
                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Are you sure you want to delete this category?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm font-bold">Delete Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection

