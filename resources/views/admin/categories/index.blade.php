@extends('layouts.app')
@section('title','Categories')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ New Category</a>
</div>
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-800 text-white uppercase text-xs">
            <tr><th class="px-6 py-3">Name</th><th class="px-6 py-3">Description</th><th class="px-6 py-3">Tickets</th><th class="px-6 py-3">Actions</th></tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categories as $cat)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $cat->name }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $cat->description ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $cat->tickets_count }}</td>
                <td class="px-6 py-4 flex gap-2">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="text-yellow-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">No categories.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
