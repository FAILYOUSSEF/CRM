@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('employee.meetings.index') }}" class="text-gray-500 hover:text-gray-900 bg-white border border-gray-200 px-3 py-2 rounded-lg shadow-sm transition-all hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Meeting Details</h1>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-card class="p-8">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900">{{ $meeting->titre }}</h2>
                    <p class="text-sm text-gray-500 mt-2 flex items-center gap-2 font-medium">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($meeting->date_heure)->format('F j, Y \a\t g:i A') }}
                    </p>
                </div>
                
                @php
                    $myResponse = $meeting->participants->where('id', auth()->id())->first()->pivot->response ?? 'pending';
                @endphp

                <div>
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wide uppercase shadow-sm border
                        {{ $myResponse === 'accepted' ? 'bg-green-50 text-green-700 border-green-200' : ($myResponse === 'refused' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-amber-50 text-amber-700 border-amber-200') }}">
                        Status: {{ $myResponse }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-100">
                    <div>
                        <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Meeting Type</span>
                        <span class="text-sm font-semibold text-gray-900">{{ ucfirst($meeting->type) }}</span>
                    </div>
                    @if($meeting->type === 'online' && $meeting->link)
                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Meeting Link</span>
                            <a href="{{ $meeting->link }}" target="_blank" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 hover:underline flex items-center gap-1 transition-colors">
                                Join Online Meeting <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    @elseif($meeting->type === 'presentiel' && $meeting->lieu)
                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Location</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $meeting->lieu }}</span>
                        </div>
                    @endif
                </div>
                
                <div>
                    <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description & Agenda</span>
                    <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $meeting->description ?? 'No description provided.' }}</div>
                </div>
            </div>

            @if($myResponse === 'pending')
                <div class="border-t border-gray-100 pt-6 mt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h3 class="text-sm font-bold text-gray-900">Will you attend this meeting?</h3>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('employee.meetings.respond', $meeting->id) }}" method="POST" class="inline-block">
                            @csrf <input type="hidden" name="response" value="refused">
                            <button type="submit" class="bg-white text-red-600 border border-red-200 px-5 py-2.5 rounded-lg shadow-sm hover:bg-red-50 transition-all duration-200 text-sm font-bold">Decline</button>
                        </form>
                        <form action="{{ route('employee.meetings.respond', $meeting->id) }}" method="POST" class="inline-block">
                            @csrf <input type="hidden" name="response" value="accepted">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg shadow-sm hover:shadow-md hover:bg-indigo-700 transform hover:-translate-y-0.5 transition-all duration-200 text-sm font-bold">Accept Meeting</button>
                        </form>
                    </div>
                </div>
            @endif
        </x-card>
    </div>
@endsection
