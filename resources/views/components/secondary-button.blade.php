<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-crm-bg3 border border-crm-border rounded-crm font-semibold text-xs text-crm-text uppercase tracking-widest hover:bg-crm-surface focus:outline-none focus:ring-2 focus:ring-crm-accent focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
