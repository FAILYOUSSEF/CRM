@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-crm-accent text-start text-xs font-medium text-crm-accent bg-crm-bg3 focus:outline-none focus:text-crm-accent focus:bg-crm-bg3 focus:border-crm-accent transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-xs font-medium text-crm-muted hover:text-crm-text hover:bg-crm-bg3 hover:border-crm-border focus:outline-none focus:text-crm-text focus:bg-crm-bg3 focus:border-crm-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
