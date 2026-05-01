@extends('layouts.app')
@section('title','Create Category')
@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-gray-900">Create New Category</h1>
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Name</label>
            <input type="text" name="name" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white" required value="{{ old('name') }}">
            @error('name') <div class="text-red-500 text-xs">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-800">Description</label>
            <textarea name="description" class="w-full border border-gray-400 rounded px-3 py-2 text-gray-900 placeholder-gray-500 bg-white">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-black">Create Category</button>
        <a href="{{ route('admin.categories.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection
