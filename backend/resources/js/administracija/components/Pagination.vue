<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    links: { type: Array, default: () => [] },
    meta: { type: Object, default: null },
});

const isNav = (label) => /previous|next|&laquo|&raquo|«|»|‹|›/i.test(label ?? '');

const numbered = computed(() => (props.links || []).filter((l) => l.label && !isNav(l.label)));
const prev = computed(() => (props.links || [])[0] ?? null);
const next = computed(() => {
    const arr = props.links || [];
    return arr.length ? arr[arr.length - 1] : null;
});
const multiPage = computed(() => numbered.value.length > 1);
</script>

<template>
    <div v-if="meta && (meta.total ?? 0) > 0" class="flex flex-col items-center justify-between gap-3 sm:flex-row">
        <p class="text-[13px] text-ink-3">
            Prikazano {{ meta.from ?? 0 }}-{{ meta.to ?? 0 }} od {{ meta.total ?? 0 }}
        </p>

        <nav v-if="multiPage" class="flex items-center gap-1">
            <Link
                v-if="prev && prev.url"
                :href="prev.url"
                preserve-scroll
                class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-line bg-surface text-ink-2 hover:bg-surface-alt"
            >
                <ChevronLeft :size="16" />
            </Link>
            <span
                v-else
                class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-line bg-surface text-ink-3 opacity-40"
            >
                <ChevronLeft :size="16" />
            </span>

            <template v-for="(link, i) in numbered" :key="i">
                <Link
                    v-if="link.url && !link.active"
                    :href="link.url"
                    preserve-scroll
                    class="inline-flex h-8 min-w-8 items-center justify-center rounded-md border border-line bg-surface px-2 text-[13px] font-medium text-ink-2 hover:bg-surface-alt"
                    v-html="link.label"
                />
                <span
                    v-else
                    :class="link.active ? 'border-brand bg-brand text-white font-bold' : 'border-line bg-surface text-ink-3'"
                    class="inline-flex h-8 min-w-8 items-center justify-center rounded-md border px-2 text-[13px]"
                    v-html="link.label"
                />
            </template>

            <Link
                v-if="next && next.url"
                :href="next.url"
                preserve-scroll
                class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-line bg-surface text-ink-2 hover:bg-surface-alt"
            >
                <ChevronRight :size="16" />
            </Link>
            <span
                v-else
                class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-line bg-surface text-ink-3 opacity-40"
            >
                <ChevronRight :size="16" />
            </span>
        </nav>
    </div>
</template>
