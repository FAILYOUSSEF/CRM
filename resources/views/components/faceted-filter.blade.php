<!-- Faceted Search & Filter Panel -->
<div x-data="filterPanel()" class="bg-crm-surface border border-crm-border rounded-crm shadow-sm mb-6">
    <!-- Header with Toggle -->
    <div class="px-5 py-4 border-b border-crm-border flex items-center justify-between cursor-pointer" @click="open = !open">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-crm-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <h3 class="font-semibold text-crm-text">Advanced Filters</h3>
            <span x-show="activeFiltersCount > 0" class="bg-crm-accent text-white text-xs px-2.5 py-1 rounded-full font-bold" x-text="activeFiltersCount"></span>
        </div>
        <svg class="w-5 h-5 text-crm-muted transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>

    <!-- Filter Content -->
    <div x-show="open" x-transition class="p-5 space-y-6">
        <form method="GET" action="{{ request()->url() }}" id="filterForm" class="space-y-6">
            <!-- Search Input -->
            <div>
                <label class="block text-sm font-medium text-crm-text mb-2">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by title, name, or description..."
                       class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors placeholder-crm-muted" />
            </div>

            <!-- Status Filter -->
            {{ $__env->make('components.filter-select', [
                'name' => 'status',
                'label' => 'Status',
                'options' => $filterOptions['status'] ?? [],
                'value' => request('status'),
                'icon' => 'circle'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])) }}

            <!-- Priority Filter -->
            {{ $__env->make('components.filter-select', [
                'name' => 'priorite',
                'label' => 'Priority',
                'options' => $filterOptions['priority'] ?? [],
                'value' => request('priorite'),
                'icon' => 'flag'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])) }}

            <!-- Additional Filters (dynamic based on resource) -->
            @yield('additional-filters')

            <!-- Date Range Filters -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-crm-text mb-2">From Date</label>
                    <input type="date" 
                           name="date_from" 
                           value="{{ request('date_from') }}"
                           class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-crm-text mb-2">To Date</label>
                    <input type="date" 
                           name="date_to" 
                           value="{{ request('date_to') }}"
                           class="w-full bg-crm-bg3 border border-crm-border rounded-crm px-4 py-2.5 text-sm text-crm-text outline-none focus:border-crm-accent focus:ring-1 focus:ring-crm-accent transition-colors" />
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="flex gap-3 pt-4 border-t border-crm-border">
                <button type="submit" class="flex-1 bg-crm-accent text-white px-4 py-2.5 rounded-crm hover:bg-black transition-colors font-medium text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Apply Filters
                </button>
                <a href="{{ request()->url() }}" class="flex-1 bg-crm-bg3 text-crm-muted px-4 py-2.5 rounded-crm hover:bg-crm-bg2 transition-colors font-medium text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function filterPanel() {
    return {
        open: @js(request()->hasAny(['search', 'status', 'priorite', 'date_from', 'date_to'])),
        get activeFiltersCount() {
            return [
                '{{ request("search") }}',
                '{{ request("status") }}',
                '{{ request("priorite") }}',
                '{{ request("date_from") }}',
                '{{ request("date_to") }}'
            ].filter(v => v).length;
        }
    }
}
</script>
