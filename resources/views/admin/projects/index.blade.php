@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-blue-500 transition-all duration-200 shadow-lg shadow-crm-accent/30 transform hover:-translate-y-0.5 text-sm font-bold">
            + New Project
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-crm-surface border border-crm-border rounded-crm shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-crm-bg2 border-b border-crm-border text-crm-muted uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Client</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Priority</th>
                    <th class="px-6 py-4">Deadline</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-crm-border">
                @forelse($projects as $project)
                <tr class="hover:bg-crm-bg3/50 transition-colors group">
                    <td class="px-6 py-4 font-medium text-crm-text">{{ $project->titre }}</td>
                    <td class="px-6 py-4 text-crm-muted">{{ $project->client?->name ?? '—' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium border
                            {{ $project->status === 'terminé' ? 'bg-green-500/10 text-green-400 border-green-500/20' :
                              ($project->status === 'annulé'  ? 'bg-red-500/10 text-red-400 border-red-500/20' :
                                                                'bg-crm-accent/10 text-crm-accent border-crm-accent/20') }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-crm-muted">{{ $project->priorite }}</td>
                    <td class="px-6 py-4 text-crm-muted">{{ $project->date_fin ?? '—' }}</td>
                    <td class="px-6 py-4 flex justify-end gap-4">
                        <a href="{{ route('admin.projects.show', $project) }}" class="text-crm-muted hover:text-crm-accent transition-colors font-medium">View</a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-crm-muted hover:text-yellow-400 transition-colors font-medium">Edit</a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Are you sure you want to delete this project?')">
                            @csrf @method('DELETE')
                            <button class="text-crm-muted hover:text-red-400 transition-colors font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-crm-muted">No projects found. Create one to get started!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 text-crm-muted">
        {{ $projects->links() }}
    </div>
@endsection