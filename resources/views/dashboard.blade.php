@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Dashboard</h1>
        <p class="text-sm text-crm-muted mt-1">Welcome back, {{ Auth::user()->name ?? 'User' }}!</p>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-crm-surface border border-crm-border rounded-crm p-6 shadow-sm hover:border-crm-accent/50 transition-colors">
            <h3 class="text-crm-muted text-sm font-medium mb-1">Active Projects</h3>
            <p class="text-3xl font-bold text-crm-text">{{ $projectCount }}</p>
        </div>
        
        <div class="bg-crm-surface border border-crm-border rounded-crm p-6 shadow-sm hover:border-crm-accent/50 transition-colors">
            <h3 class="text-crm-muted text-sm font-medium mb-1">Pending Tasks</h3>
            <p class="text-3xl font-bold text-crm-text">{{ $taskCount }}</p>
        </div>
        
        <div class="bg-crm-surface border border-crm-border rounded-crm p-6 shadow-sm hover:border-crm-accent/50 transition-colors">
            <h3 class="text-crm-muted text-sm font-medium mb-1">Open Tickets</h3>
            <p class="text-3xl font-bold text-crm-text">{{ $ticketCount }}</p>
        </div>
    </div>
@endsection
