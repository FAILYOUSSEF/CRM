<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('client.projects.index') }}" class="text-gray-500 hover:text-gray-900 bg-white border border-gray-200 px-3 py-2 rounded-lg shadow-sm transition-all hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Project Overview</h1>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <x-card class="p-8">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $project->titre }}</h2>
                    <p class="text-sm text-gray-500 mt-2 flex items-center gap-2 font-medium">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Timeline: {{ $project->date_debut ?? 'TBD' }} &mdash; {{ $project->date_fin ?? 'TBD' }}
                    </p>
                </div>
                
                <div>
                    <span class="px-4 py-2 rounded-full text-xs font-bold tracking-wide uppercase shadow-sm border 
                        {{ $project->status === 'terminé' ? 'bg-green-50 text-green-700 border-green-200' : ($project->status === 'en cours' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-gray-50 text-gray-700 border-gray-200') }}">
                        Status: {{ $project->status }}
                    </span>
                </div>
            </div>

            <div class="mb-10">
                <div class="flex justify-between text-sm font-bold text-gray-800 mb-2">
                    <span>Project Progress</span>
                    <span>{{ $project->progress ?? 0 }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden shadow-inner">
                    <div class="bg-indigo-600 h-3 rounded-full transition-all duration-500" style="width: {{ $project->progress ?? 0 }}%"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 flex flex-col gap-1">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Priority</span>
                    <span class="text-sm font-semibold text-gray-900">{{ ucfirst($project->priorite) }}</span>
                </div>
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 flex flex-col gap-1">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Budget</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $project->budget ? '$' . number_format($project->budget, 2) : 'N/A' }}</span>
                </div>
                @if($project->ficher)
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 flex flex-col gap-1 justify-center">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Attachment</span>
                    <a href="{{ asset('storage/' . $project->ficher) }}" target="_blank" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:underline flex items-center gap-1 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download File
                    </a>
                </div>
                @endif
            </div>
            
            <div>
                <span class="block text-sm font-bold text-gray-900 mb-3 border-b border-gray-100 pb-2">Description</span>
                <div class="text-base text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $project->description ?? 'No detailed description provided for this project.' }}</div>
            </div>
        </x-card>
    </div>
</x-app-layout>
