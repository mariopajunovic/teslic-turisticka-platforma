<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: { type: String, default: null },
    align: { type: String, default: 'left' },
});

const alignClass = computed(() => {
    return {
        left: 'md:text-left',
        center: 'md:text-center',
        right: 'md:text-right',
    }[props.align] ?? 'md:text-left';
});
</script>

<template>
    <td
        :class="alignClass"
        class="flex items-center justify-between gap-3 py-1.5 md:table-cell md:px-[18px] md:py-3 md:align-middle text-ink"
    >
        <span v-if="label" class="text-xs font-medium text-ink-3 md:hidden">{{ label }}</span>
        <span class="min-w-0 text-right md:text-inherit md:w-auto">
            <slot />
        </span>
    </td>
</template>
