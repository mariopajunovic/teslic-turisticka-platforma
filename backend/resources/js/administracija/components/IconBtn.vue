<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    icon: { type: [Object, Function], required: true },
    color: { type: String, default: 'default' },
    tooltip: { type: String, default: null },
    size: { type: String, default: 'md' },
    disabled: { type: Boolean, default: false },
    type: { type: String, default: 'button' },
    href: { type: String, default: null },
});

const tag = computed(() => (props.href ? Link : 'button'));

const colorClass = computed(() => {
    return {
        default: 'text-ink-2 hover:text-ink',
        brand: 'text-brand hover:bg-brand-tint',
        ok: 'text-ok hover:bg-ok-bg',
        warn: 'text-warn hover:bg-warn-bg',
        bad: 'text-bad hover:bg-bad-bg',
        info: 'text-info hover:bg-info-bg',
    }[props.color] ?? 'text-ink-2 hover:text-ink';
});

const sizeClass = computed(() => (props.size === 'sm' ? 'h-7 w-7' : 'h-8 w-8'));
</script>

<template>
    <component
        :is="tag"
        :href="href || undefined"
        :type="tag === 'button' ? type : undefined"
        :disabled="tag === 'button' ? disabled : undefined"
        :title="tooltip"
        :aria-label="tooltip"
        :class="[colorClass, sizeClass, disabled ? 'opacity-40 pointer-events-none' : '']"
        class="inline-flex items-center justify-center rounded-md border border-line bg-surface-alt transition-colors hover:border-line-strong focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40"
    >
        <component :is="icon" :size="16" />
    </component>
</template>
