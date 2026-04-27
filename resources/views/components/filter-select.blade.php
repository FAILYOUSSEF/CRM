<!-- Filter Select Component -->
<div>
    <label class="block text-sm font-medium text-crm-text mb-2">
        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            @switch($icon ?? 'circle')
                @case('circle')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    @break
                @case('flag')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5m0 16h18.75M9 6h4m8 0h.75v4H9v4h8v4h.75M9 6v16"></path>
                    @break
                @case('users')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zM7 10a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                    @break
                @case('tag')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    @break
            @endswitch
        </svg>
        {{ $label }}
    </label>
    <select name="{{ $name }}" 
            class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors">
        <option value="">— All {{ strtolower($label) }} —</option>
        @foreach($options as $option)
            @php
                $displayValue = is_array($option) ? ($option['label'] ?? $option['value'] ?? $option) : $option;
                $optionValue = is_array($option) ? ($option['value'] ?? $displayValue) : $option;
            @endphp
            <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                {{ ucfirst($displayValue) }}
            </option>
        @endforeach
    </select>
</div>
