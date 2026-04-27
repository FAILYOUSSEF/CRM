@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-crm-text tracking-tight">Edit Profile</h1>
    </div>

    <div class="max-w-3xl space-y-6">
        <div class="bg-crm-surface border border-crm-border rounded-crm p-6 shadow-sm">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-crm-surface border border-crm-border rounded-crm p-6 shadow-sm">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-red-500/10 border border-red-500/20 rounded-crm p-6 shadow-sm">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
