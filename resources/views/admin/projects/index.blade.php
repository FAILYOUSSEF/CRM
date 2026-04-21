@extends('layouts.app')
@section('title','Projects')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Projects</h1>
    <a href="{{ route('admin.projects.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ New Project</a>
</div>
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-800 text-white uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Title</th>
                <th class="px-6 py-3">Client</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Priority</th>
                <th class="px-6 py-3">Deadline</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($projects as $project)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $project->titre }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $project->client?->name ?? '—' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-medium
                        {{ $project->status === 'terminé' ? 'bg-green-100 text-green-700' :
                          ($project->status === 'annulé'  ? 'bg-red-100 text-red-700' :
                                                            'bg-blue-100 text-blue-700') }}">
                        {{ $project->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-800">{{ $project->priorite }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $project->date_fin ?? '—' }}</td>
                <td class="px-6 py-4 flex gap-2">
                    <a href="{{ route('admin.projects.show', $project) }}"   class="text-indigo-600 hover:underline">View</a>
                    <a href="{{ route('admin.projects.edit', $project) }}"   class="text-yellow-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No projects yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $projects->links() }}</div>
@endsection