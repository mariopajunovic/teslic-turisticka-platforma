<script setup>
defineProps({
    title: { type: String, default: null },
    count: { type: [String, Number], default: null },
    padded: { type: Boolean, default: true },
});

const slots = defineSlots();
</script>

<template>
    <section class="overflow-hidden bg-surface border border-line rounded-[var(--radius-card)]">
        <header
            v-if="title || slots.actions"
            class="flex items-center justify-between gap-3 px-[18px] py-[15px] border-b border-line"
        >
            <div class="flex items-center gap-2 min-w-0">
                <h2 v-if="title" class="text-[15px] font-bold text-ink truncate">{{ title }}</h2>
                <span
                    v-if="count !== null"
                    class="inline-flex items-center justify-center rounded-full bg-surface-alt px-2 py-0.5 text-xs font-semibold text-ink-2"
                >
                    {{ count }}
                </span>
            </div>
            <div v-if="slots.actions" class="flex shrink-0 items-center gap-2">
                <slot name="actions" />
            </div>
        </header>
        <div :class="padded ? 'p-4 sm:p-5' : ''">
            <slot />
        </div>
    </section>
</template>
