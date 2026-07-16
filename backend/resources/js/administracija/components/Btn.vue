<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    variant: { type: String, default: 'primary' },
    size: { type: String, default: 'md' },
    icon: { type: [Object, Function], default: null },
    as: { type: String, default: 'button' },
    href: { type: String, default: null },
    type: { type: String, default: 'button' },
    disabled: { type: Boolean, default: false },
    block: { type: Boolean, default: false },
});

const variantClass = computed(() => {
    return {
        primary: 'bg-brand text-white hover:bg-brand-dark border border-transparent',
        secondary: 'bg-surface text-ink border border-line hover:bg-surface-alt',
        ghost: 'bg-transparent text-ink-2 hover:bg-surface-alt border border-transparent',
        danger: 'bg-bad text-white hover:brightness-95 border border-transparent',
    }[props.variant] ?? 'bg-brand text-white hover:bg-brand-dark border border-transparent';
});

const sizeClass = computed(() => {
    return {
        sm: 'h-8 px-3 text-xs gap-1.5',
        md: 'h-9 px-4 text-sm gap-2',
        lg: 'h-11 px-5 text-sm gap-2',
    }[props.size] ?? 'h-9 px-4 text-sm gap-2';
});

const iconSize = computed(() => (props.size === 'sm' ? 15 : 16));

const component = computed(() => {
    if (props.as === 'Link' || (props.as === 'button' && props.href)) return Link;
    return 'button';
});
</script>

<template>
    <component
        :is="component"
        :href="component === Link ? href : undefined"
        :type="component === 'button' ? type : undefined"
        :disabled="component === 'button' ? disabled : undefined"
        :class="[variantClass, sizeClass, block ? 'w-full' : '', disabled ? 'opacity-50 pointer-events-none' : '']"
        class="inline-flex items-center justify-center rounded-[var(--radius-card)] font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40"
    >
        <component :is="icon" v-if="icon" :size="iconSize" />
        <slot />
    </component>
</template>
