<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import { EllipsisVertical } from 'lucide-vue-next';

const open = ref(false);
const trigger = ref(null);
const menu = ref(null);
const pos = ref({ top: 0, left: 0 });

const MENU_W = 240;

const place = () => {
    if (!trigger.value) return;
    const r = trigger.value.getBoundingClientRect();
    let left = r.right - MENU_W;
    left = Math.min(Math.max(8, left), window.innerWidth - MENU_W - 8);
    pos.value = { top: Math.round(r.bottom + 6), left: Math.round(left) };
};

const toggle = async () => {
    open.value = !open.value;
    if (open.value) {
        await nextTick();
        place();
    }
};

const close = () => (open.value = false);

const onOutside = (e) => {
    if (!open.value) return;
    if (trigger.value?.contains(e.target)) return;
    if (menu.value?.contains(e.target)) return;
    close();
};
const onEsc = (e) => {
    if (e.key === 'Escape') close();
};
const onReflow = () => {
    if (open.value) close();
};

onMounted(() => {
    document.addEventListener('click', onOutside, true);
    document.addEventListener('keydown', onEsc);
    window.addEventListener('scroll', onReflow, true);
    window.addEventListener('resize', onReflow);
});
onBeforeUnmount(() => {
    document.removeEventListener('click', onOutside, true);
    document.removeEventListener('keydown', onEsc);
    window.removeEventListener('scroll', onReflow, true);
    window.removeEventListener('resize', onReflow);
});
</script>

<template>
    <button
        ref="trigger"
        type="button"
        class="inline-flex h-7 w-7 items-center justify-center rounded-md border border-line bg-surface-alt text-ink-2 transition-colors hover:border-line-strong hover:text-ink"
        aria-label="Više opcija"
        @click="toggle"
    >
        <EllipsisVertical :size="16" />
    </button>

    <Teleport to="body">
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
                ref="menu"
                :style="{ top: pos.top + 'px', left: pos.left + 'px', width: MENU_W + 'px' }"
                class="fixed z-[80] origin-top-right rounded-[var(--radius-card)] border border-line bg-surface py-1.5 shadow-[var(--shadow-pop)]"
                @click="close"
            >
                <slot :close="close" />
            </div>
        </transition>
    </Teleport>
</template>
