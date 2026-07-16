<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref, reactive, watch, computed } from 'vue';
import { Search, ListFilter, TriangleAlert, Check, Languages } from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Pagination from '../components/Pagination.vue';
import EmptyState from '../components/EmptyState.vue';

const props = defineProps({
    columns: { type: Array, default: () => [] },
    translations: { type: Array, default: () => [] },
    groups: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({ search: '', group: '', missing: false }) },
    missingCount: { type: Number, default: 0 },
    pagination: { type: Object, default: () => ({ links: [], meta: null }) },
});

const search = ref(props.filters.search ?? '');
const group = ref(props.filters.group ?? '');

const draft = reactive({});
const server = reactive({});
const savingRow = ref(null);
const savedRow = ref(null);

const seed = () => {
    for (const key of Object.keys(draft)) delete draft[key];
    for (const key of Object.keys(server)) delete server[key];
    for (const t of props.translations) {
        draft[t.id] = { ...t.values };
        server[t.id] = { ...t.values };
    }
};
seed();
watch(() => props.translations, seed, { deep: false });

let searchTimer = null;
watch(search, () => {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => applyFilters(), 350);
});

const applyFilters = (extra = {}) => {
    router.get('/administracija/prevodi', {
        search: search.value || undefined,
        group: group.value || undefined,
        missing: props.filters.missing ? 1 : undefined,
        ...extra,
    }, { preserveState: true, preserveScroll: true, replace: true });
};

const onGroup = () => applyFilters();
const toggleMissing = () => applyFilters({ missing: props.filters.missing ? undefined : 1 });

const isEmpty = (id, code) => !String(draft[id]?.[code] ?? '').trim();

const rowDirty = (id) => props.columns.some((c) => String(draft[id]?.[c.code] ?? '') !== String(server[id]?.[c.code] ?? ''));

const saveRow = (id) => {
    if (!rowDirty(id)) return;
    savingRow.value = id;
    router.put(`/administracija/prevodi/${id}`, { values: draft[id] }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            server[id] = { ...draft[id] };
            savedRow.value = id;
            setTimeout(() => {
                if (savedRow.value === id) savedRow.value = null;
            }, 1400);
        },
        onFinish: () => {
            if (savingRow.value === id) savingRow.value = null;
        },
    });
};

const total = computed(() => props.pagination?.meta?.total ?? props.translations.length);
</script>

<template>
    <Head title="Prevodi" />

    <div class="space-y-[18px]">
        <header>
            <h1 class="text-[22px] font-bold text-ink">Prevodi</h1>
            <p class="mt-1 text-sm text-ink-2">Uređujte tekstove interfejsa. Izmjene su odmah vidljive, bez novog deploya.</p>
        </header>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-1 flex-wrap items-center gap-2.5">
                <label class="flex h-9 w-full items-center gap-2 rounded-md border border-line bg-surface px-3 sm:w-[300px]">
                    <Search :size="16" class="shrink-0 text-ink-3" />
                    <input
                        v-model="search"
                        type="search"
                        placeholder="Pretraži ključ ili tekst..."
                        class="w-full bg-transparent text-[13px] text-ink placeholder:text-ink-3 focus:outline-none"
                    />
                </label>

                <div class="relative">
                    <ListFilter :size="16" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-ink-3" />
                    <select
                        v-model="group"
                        class="h-9 appearance-none rounded-md border border-line bg-surface pl-9 pr-8 text-[13px] font-medium text-ink-2 focus:border-brand focus:outline-none"
                        @change="onGroup"
                    >
                        <option value="">Sve grupe</option>
                        <option v-for="g in groups" :key="g" :value="g">{{ g }}</option>
                    </select>
                </div>
            </div>

            <button
                v-if="missingCount > 0 || filters.missing"
                type="button"
                :class="filters.missing
                    ? 'border-[#B26A00] bg-[#F6E4C4] text-[#8A5200]'
                    : 'border-[#EBC66B] bg-[#FCF3E3] text-[#B26A00] hover:bg-[#FAECD3]'"
                class="inline-flex h-9 shrink-0 items-center gap-2 rounded-md border px-3 text-[13px] font-semibold"
                @click="toggleMissing"
            >
                <TriangleAlert :size="15" />
                Nedostaje prevod ({{ missingCount }})
            </button>
        </div>

        <Card title="Prevodi" :count="total" :padded="false">
            <div v-if="translations.length" class="w-full overflow-x-auto">
                <div class="min-w-[720px]">
                    <div class="flex items-center gap-3.5 border-b border-line bg-surface-alt px-[18px] py-2.5">
                        <div class="w-[240px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Ključ</div>
                        <div
                            v-for="c in columns"
                            :key="c.code"
                            class="flex-1 text-[11px] font-bold uppercase tracking-wide text-ink-3"
                        >
                            {{ c.code }}
                        </div>
                    </div>

                    <div
                        v-for="t in translations"
                        :key="t.id"
                        class="flex items-center gap-3.5 border-b border-line px-[18px] py-2.5 last:border-b-0"
                    >
                        <div class="flex w-[240px] shrink-0 items-center gap-2">
                            <span class="truncate font-mono text-xs font-medium text-ink" :title="t.key">{{ t.key }}</span>
                            <Check
                                v-if="savedRow === t.id"
                                :size="14"
                                class="shrink-0 text-ok"
                            />
                        </div>
                        <div v-for="c in columns" :key="c.code" class="flex-1">
                            <input
                                v-model="draft[t.id][c.code]"
                                type="text"
                                :class="isEmpty(t.id, c.code)
                                    ? 'border-[#EBC66B] bg-[#FCF3E3]'
                                    : 'border-line bg-surface focus:border-brand'"
                                class="h-9 w-full rounded-md border px-2.5 text-[13px] text-ink focus:outline-none focus:ring-2 focus:ring-brand/15"
                                @change="saveRow(t.id)"
                                @keydown.enter.prevent="saveRow(t.id)"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="p-8">
                <EmptyState
                    :icon="Languages"
                    title="Nema rezultata"
                    text="Nijedan prevod ne odgovara pretrazi ili filteru."
                />
            </div>
        </Card>

        <Pagination v-if="pagination.meta" :links="pagination.links" :meta="pagination.meta" />
    </div>
</template>
