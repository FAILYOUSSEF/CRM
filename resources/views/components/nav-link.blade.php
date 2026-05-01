@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-crm-accent text-xs font-medium leading-5 text-crm-text focus:outline-none focus:border-black transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-xs font-medium leading-5 text-crm-muted hover:text-crm-text hover:border-crm-border focus:outline-none focus:text-crm-text focus:border-crm-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
