@extends('layouts.app')
@section('title','New User')
@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">New User</h1>
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                <select name="type_client" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                    <option value="client">Client</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label><input name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">CIN</label><input name="cin" value="{{ old('cin') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Salary</label><input type="number" step="0.01" name="salaire" value="{{ old('salaire') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Contract Type</label><input name="type_contrat" value="{{ old('type_contrat') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
        </div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Address</label><input name="addresse" value="{{ old('addresse') }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Contract File</label><input type="file" name="fichier_de_contrat" class="text-sm text-gray-500"></div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-black text-sm">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:underline text-sm py-2">Cancel</a>
        </div>
    </form>
</div>
@endsection
