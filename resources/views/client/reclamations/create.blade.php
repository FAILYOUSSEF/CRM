@extends('layouts.app')
@section('title','New Reclamation')
@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Submit a Reclamation</h1>
    <p class="text-gray-500 mt-2 text-sm">We are here to help. Fill out the form below to report an issue or request a meeting.</p>
</div>
<div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 max-w-2xl border border-gray-100">
    <form method="POST" action="{{ route('client.reclamations.store') }}" class="space-y-4">
        @csrf
        <div class="space-y-5">
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input name="titre" value="{{ old('titre') }}" required placeholder="Briefly describe the issue" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-900 placeholder-gray-400 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Type</label>
                <select name="type" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-900 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 cursor-pointer">
                <option value="bug" {{ old('type') == 'bug' ? 'selected' : '' }}>Bug</option>
                <option value="meeting" {{ old('type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                </select></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Priority</label>
                <select name="priorite" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-900 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 cursor-pointer">
                <option value="faible">Faible</option><option value="moyenne" selected>Moyenne</option><option value="haute">Haute</option>
                </select></div>
            </div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Other Type Details <span class="text-gray-400 font-normal">(Optional)</span></label>
                <input name="type_other" value="{{ old('type_other') }}" placeholder="If 'Other' is selected, please specify" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-900 placeholder-gray-400 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" required placeholder="Provide as much detail as possible..." class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-gray-900 placeholder-gray-400 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-y">{{ old('description') }}</textarea></div>
        </div>
        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 mt-6">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 text-sm font-bold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                Submit Reclamation
            </button>
            <a href="{{ route('client.reclamations.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm py-2 px-3 rounded-xl hover:bg-gray-100 transition-colors duration-200">Cancel</a>
        </div>
    </form>
</div>
@endsection