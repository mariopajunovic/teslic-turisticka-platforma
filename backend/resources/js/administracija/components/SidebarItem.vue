<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    icon: { type: [Object, Function], default: null },
    label: { type: String, required: true },
    href: { type: String, default: '#' },
    active: { type: Boolean, default: false },
    count: { type: [Number, String], default: null },
    collapsed: { type: Boolean, default: false },
});
</script>

<template>
    <Link
        :href="href"
        :title="collapsed ? label : null"
        :class="[
            active
                ? 'bg-sidebar-alt text-sidebar-strong'
                : 'text-sidebar-text hover:bg-sidebar-alt hover:text-sidebar-strong',
            collapsed ? 'justify-center px-0' : 'px-3.5',
        ]"
        class="group relative flex h-[38px] items-center gap-2.5 text-[13px] transition-colors"
    >
        <span
            class="absolute left-0 top-1/2 h-[22px] w-[3px] -translate-y-1/2 rounded-r bg-brand transition-opacity"
            :class="active ? 'opacity-100' : 'opacity-0'"
        ></span>
        <component
            :is="icon"
            v-if="icon"
            :size="17"
            class="shrink-0"
            :class="active ? 'text-brand' : ''"
        />
        <template v-if="!collapsed">
            <span class="flex-1 truncate">{{ label }}</span>
            <span
                v-if="count !== null && count !== undefined && Number(count) > 0"
                class="inline-flex min-w-[1.125rem] items-center justify-center rounded-full bg-brand px-1.5 py-0.5 text-[11px] font-bold text-white"
            >
                {{ count }}
            </span>
        </template>
    </Link>
</template>
