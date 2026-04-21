<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-crm-text leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-crm-bg2 border border-crm-border overflow-hidden rounded-crm-lg shadow-lg">
                <div class="p-6 text-crm-text">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
