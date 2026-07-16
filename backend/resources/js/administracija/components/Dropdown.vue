<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { ChevronDown } from 'lucide-vue-next';

defineProps({
    label: { type: String, default: '' },
    icon: { type: [Object, Function], default: null },
});

const open = ref(false);
const root = ref(null);

const onOutside = (e) => {
    if (root.value && !root.value.contains(e.target)) open.value = false;
};
const onEsc = (e) => {
    if (e.key === 'Escape') open.value = false;
};

onMounted(() => {
    document.addEventListener('click', onOutside);
    document.addEventListener('keydown', onEsc);
});
onBeforeUnmount(() => {
    document.removeEventListener('click', onOutside);
    document.removeEventListener('keydown', onEsc);
});

const close = () => (open.value = false);
</script>

<template>
    <div ref="root" class="relative">
        <button
            type="button"
            class="inline-flex h-9 items-center gap-2 rounded-[var(--radius-card)] border border-line bg-surface px-3 text-sm font-medium text-ink-2 hover:bg-surface-alt focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/30"
            @click="open = !open"
        >
            <component :is="icon" v-if="icon" :size="16" />
            <span>{{ label }}</span>
            <ChevronDown :size="15" class="text-ink-3" />
        </button>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-if="open"
                class="absolute left-0 z-20 mt-2 min-w-[12rem] origin-top-left rounded-[var(--radius-card)] border border-line bg-surface py-1 shadow-[var(--shadow-pop)]"
                @click="close"
            >
                <slot :close="close" />
            </div>
        </transition>
    </div>
</template>
