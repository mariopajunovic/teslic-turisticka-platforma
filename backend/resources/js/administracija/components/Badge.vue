<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: { type: [String, Number], default: '' },
    color: { type: String, default: 'gray' },
    dot: { type: Boolean, default: true },
});

const colorClass = computed(() => {
    return {
        brand: 'text-brand bg-brand-tint',
        ok: 'text-ok bg-ok-bg',
        warn: 'text-warn bg-warn-bg',
        bad: 'text-bad bg-bad-bg',
        info: 'text-info bg-info-bg',
        gray: 'text-ink-2 bg-surface-alt',
    }[props.color] ?? 'text-ink-2 bg-surface-alt';
});

const dotClass = computed(() => {
    return {
        brand: 'bg-brand',
        ok: 'bg-ok',
        warn: 'bg-warn',
        bad: 'bg-bad',
        info: 'bg-info',
        gray: 'bg-ink-3',
    }[props.color] ?? 'bg-ink-3';
});
</script>

<template>
    <span
        :class="colorClass"
        class="inline-flex items-center gap-1.5 rounded px-2.5 py-[3px] text-xs font-semibold whitespace-nowrap"
    >
        <span v-if="dot" :class="dotClass" class="h-1.5 w-1.5 rounded-full"></span>
        <slot>{{ label }}</slot>
    </span>
</template>
