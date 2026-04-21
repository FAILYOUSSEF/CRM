@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-xs text-green-400 bg-green-500/15 border border-green-500/30 rounded-crm p-3']) }}>
        {{ $status }}
    </div>
@endif
