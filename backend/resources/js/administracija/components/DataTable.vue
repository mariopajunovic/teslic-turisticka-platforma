<script setup>
import { computed } from 'vue';

const props = defineProps({
    columns: { type: Array, default: () => [] },
});

const alignClass = (a) => {
    return {
        left: 'text-left',
        center: 'text-center',
        right: 'text-right',
    }[a] ?? 'text-left';
};

const cols = computed(() => props.columns);
</script>

<template>
    <div class="w-full overflow-x-auto">
        <table class="w-full min-w-full border-collapse text-sm md:table-fixed">
            <thead class="hidden md:table-header-group bg-surface-alt">
                <tr>
                    <th
                        v-for="col in cols"
                        :key="col.key"
                        :style="col.width ? { width: col.width } : null"
                        :class="alignClass(col.align)"
                        class="border-b border-line px-[18px] py-3 text-[11px] font-semibold uppercase tracking-wide text-ink-3 whitespace-nowrap"
                    >
                        {{ col.label }}
                    </th>
                </tr>
            </thead>
            <tbody class="block space-y-3 p-3 md:table-row-group md:space-y-0 md:p-0">
                <slot />
            </tbody>
        </table>
    </div>
</template>
