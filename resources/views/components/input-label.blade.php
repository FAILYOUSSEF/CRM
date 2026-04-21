@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xs text-crm-text']) }}>
    {{ $value ?? $slot }}
</label>
