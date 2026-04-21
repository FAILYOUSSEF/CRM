@extends('layouts.app')
@section('title','Users')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Users</h1>
    <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ New User</a>
</div>
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-800 text-white uppercase text-xs">
            <tr>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Role</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-medium
                        {{ $user->type_client === 'admin' ? 'bg-purple-100 text-purple-700' :
                          ($user->type_client === 'employee' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                        {{ ucfirst($user->type_client) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->status }}</span>
                </td>
                <td class="px-6 py-4 flex gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete user?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No users.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection