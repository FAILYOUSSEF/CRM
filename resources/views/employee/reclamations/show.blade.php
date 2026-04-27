@extends('layouts.app')
@section('title', 'Reclamation: ' . $reclamation->titre)
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $reclamation->titre }}</h1>
        <div class="grid grid-cols-2 gap-4 text-sm mb-6">
            <div>
                <dt class="text-gray-500">Status</dt>
                <dd class="font-medium">
                    <span class="px-2 py-1 rounded text-xs {{ $reclamation->status === 'traité' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($reclamation->status) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-gray-500">Priority</dt>
                <dd class="font-medium">{{ ucfirst($reclamation->priorite) }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Type</dt>
                <dd class="font-medium">{{ $reclamation->type_display }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Date</dt>
                <dd class="font-medium">{{ $reclamation->date ?? '—' }}</dd>
            </div>
        </div>
        <div class="mb-6 bg-gray-50 rounded p-4">
            <p class="text-sm text-gray-700">{{ $reclamation->description }}</p>
        </div>
        @if($reclamation->response)
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm font-semibold text-green-700 mb-2">Admin Response</p>
            <p class="text-sm text-green-800">{{ $reclamation->response }}</p>
        </div>
        @endif
    </div>
    <div class="flex gap-4">
        <a href="{{ route('employee.reclamations.index') }}" class="text-gray-600 hover:underline px-4 py-2">Back to Reclamations</a>
    </div>
</div>
@endsection
