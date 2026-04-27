@extends('layouts.app')
@section('title', 'Reclamation: ' . $reclamation->titre)
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('client.reclamations.index') }}" class="text-gray-500 hover:text-gray-800 flex items-center gap-2 text-sm font-medium transition-colors bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Reclamations
        </a>
    </div>
    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/40 p-8 mb-6 border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 {{ $reclamation->status === 'traité' ? 'bg-green-500' : 'bg-yellow-400' }}"></div>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 tracking-tight">{{ $reclamation->titre }}</h1>
        
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-sm mb-8 bg-gray-50 p-5 rounded-2xl border border-gray-100">
            <div class="flex flex-col gap-1">
                <dt class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Status</dt>
                <dd>
                    <span class="inline-flex items-center uppercase px-2.5 py-1 rounded-full text-xs font-bold tracking-wide {{ $reclamation->status === 'traité' ? 'bg-green-100 text-green-700 ring-1 ring-inset ring-green-600/20' : 'bg-yellow-100 text-yellow-700 ring-1 ring-inset ring-yellow-600/20' }}">
                        @if($reclamation->status === 'traité')
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        @endif
                        {{ $reclamation->status }}
                    </span>
                </dd>
            </div>
            <div class="flex flex-col gap-1">
                <dt class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Priority</dt>
                <dd class="font-bold text-gray-900">{{ ucfirst($reclamation->priorite) }}</dd>
            </div>
            <div class="flex flex-col gap-1">
                <dt class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Type</dt>
                <dd class="font-bold text-gray-900">{{ $reclamation->type_display }}</dd>
            </div>
            <div class="flex flex-col gap-1">
                <dt class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Date</dt>
                <dd class="font-bold text-gray-900">{{ $reclamation->date ?? '—' }}</dd>
            </div>
        </div>
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-3 border-b border-gray-100 pb-2">Description</h3>
            <p class="text-base text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $reclamation->description }}</p>
        </div>
        @if($reclamation->response)
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6 shadow-inner relative mt-4">
            <div class="absolute -top-4 -left-3 bg-green-100 rounded-full p-2 border-4 border-white">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <p class="text-xs font-extrabold text-green-800 uppercase tracking-wider mb-2 ml-4">Support Response</p>
            <p class="text-sm text-green-900 leading-relaxed ml-4">{{ $reclamation->response }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
