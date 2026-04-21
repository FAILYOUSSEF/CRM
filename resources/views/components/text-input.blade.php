@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full bg-crm-bg3 border border-crm-border rounded-crm px-3 py-2 text-xs text-crm-text placeholder-crm-muted focus:border-crm-accent focus:outline-none focus:ring-0 disabled:opacity-50']) !!}>
