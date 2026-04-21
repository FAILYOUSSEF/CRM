@extends('layouts.app')
@section('title','Reclamations')
@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Reclamations</h1>
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-800 text-white uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Title</th>
                <th class="px-6 py-3">From</th>
                <th class="px-6 py-3">Type</th>
                <th class="px-6 py-3">Priority</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($reclamations as $rec)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $rec->titre }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $rec->user->name }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $rec->type ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $rec->priorite }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs {{ $rec->status === 'traité' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $rec->status }}</span>
                </td>
                <td class="px-6 py-4 flex gap-2">
                    <a href="{{ route('admin.reclamations.show', $rec) }}" class="text-indigo-600 hover:underline">View / Reply</a>
                    <form method="POST" action="{{ route('admin.reclamations.destroy', $rec) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No reclamations.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $reclamations->links() }}</div>
@endsection