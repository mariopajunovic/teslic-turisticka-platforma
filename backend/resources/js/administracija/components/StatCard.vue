<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: { type: String, required: true },
    value: { type: [String, Number], default: '' },
    caption: { type: String, default: null },
    icon: { type: [Object, Function], default: null },
    color: { type: String, default: 'brand' },
});

const iconWrap = computed(() => {
    return {
        brand: 'text-brand bg-brand-tint',
        ok: 'text-ok bg-ok-bg',
        warn: 'text-warn bg-warn-bg',
        bad: 'text-bad bg-bad-bg',
        info: 'text-info bg-info-bg',
        gray: 'text-ink-2 bg-surface-alt',
    }[props.color] ?? 'text-brand bg-brand-tint';
});
</script>

<template>
    <div class="bg-surface border border-line rounded-[var(--radius-card)] p-5">
        <div class="flex items-center justify-between gap-3">
            <p class="min-w-0 text-[13px] font-medium text-ink-2">{{ label }}</p>
            <span
                v-if="icon"
                :class="iconWrap"
                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full"
            >
                <component :is="icon" :size="18" />
            </span>
        </div>
        <p class="mt-2.5 text-[30px] font-bold leading-none text-ink">{{ value }}</p>
        <p v-if="caption" class="mt-2.5 text-xs text-ink-3">{{ caption }}</p>
    </div>
</template>
