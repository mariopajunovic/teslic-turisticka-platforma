<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref, reactive, watch, computed } from 'vue';
import { Search, ListFilter, TriangleAlert, Check, Languages, Lock } from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Pagination from '../components/Pagination.vue';
import EmptyState from '../components/EmptyState.vue';

const props = defineProps({
    columns: { type: Array, default: () => [] },
    target: { type: String, default: 'sr' },
    translations: { type: Array, default: () => [] },
    groups: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({ search: '', group: '', missing: false, lang: 'sr' }) },
    missingByLang: { type: Object, default: () => ({}) },
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
    for (const k of Object.keys(draft)) delete draft[k];
    for (const k of Object.keys(server)) delete server[k];
    for (const t of props.translations) {
        draft[t.id] = t.value ?? '';
        server[t.id] = t.value ?? '';
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
        lang: props.target,
        missing: props.filters.missing ? 1 : undefined,
        ...extra,
    }, { preserveState: true, preserveScroll: true, replace: true });
};

const onGroup = () => applyFilters();
const switchLang = (code) => {
    if (code === props.target) return;
    applyFilters({ lang: code });
};
const toggleMissing = () => applyFilters({ missing: props.filters.missing ? undefined : 1 });

const targetName = computed(() => props.columns.find((c) => c.code === props.target)?.name ?? props.target);
const showSource = computed(() => props.target !== 'sr');
const total = computed(() => props.pagination?.meta?.total ?? props.translations.length);

const isEmpty = (id) => !String(draft[id] ?? '').trim();

const saveRow = (id) => {
    if (String(draft[id] ?? '') === String(server[id] ?? '')) return;
    savingRow.value = id;
    router.put(`/administracija/prevodi/${id}`, { values: { [props.target]: draft[id] } }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            server[id] = draft[id];
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
</script>

<template>
    <Head title="Prevodi" />

    <div class="space-y-[18px]">
        <header>
            <h1 class="text-[22px] font-bold text-ink">Prevodi</h1>
            <p class="mt-1 text-sm text-ink-2">Uređujte tekstove interfejsa. Izmjene su odmah vidljive, bez novog deploya.</p>
        </header>

        <div class="flex flex-wrap items-center gap-1.5">
            <button
                v-for="c in columns"
                :key="c.code"
                type="button"
                :class="c.code === target
                    ? 'border-brand bg-brand text-white'
                    : 'border-line bg-surface text-ink-2 hover:bg-surface-alt'"
                class="inline-flex h-9 items-center gap-2 rounded-md border px-3 text-[13px] font-semibold"
                @click="switchLang(c.code)"
            >
                <span class="font-mono uppercase">{{ c.code }}</span>
                <span :class="c.code === target ? 'text-white/80' : 'text-ink-3'">{{ c.name }}</span>
                <span
                    v-if="(missingByLang[c.code] ?? 0) > 0"
                    :class="c.code === target ? 'bg-white/20 text-white' : 'bg-[#FCF3E3] text-[#B26A00]'"
                    class="inline-flex min-w-[18px] items-center justify-center rounded-full px-1.5 py-px text-[11px] font-bold"
                >{{ missingByLang[c.code] }}</span>
            </button>
        </div>

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
                Nedostaje u {{ target.toUpperCase() }} ({{ missingCount }})
            </button>
        </div>

        <Card :title="`Prevodi · ${targetName}`" :count="total" :padded="false">
            <div v-if="translations.length" class="w-full overflow-x-auto">
                <div class="min-w-[640px]">
                    <div class="flex items-center gap-3.5 border-b border-line bg-surface-alt px-[18px] py-2.5">
                        <div class="w-[240px] shrink-0 text-[11px] font-bold uppercase tracking-wide text-ink-3">Ključ</div>
                        <div v-if="showSource" class="flex-1 text-[11px] font-bold uppercase tracking-wide text-ink-3">SR · izvor</div>
                        <div class="flex-1 text-[11px] font-bold uppercase tracking-wide text-brand">{{ target.toUpperCase() }} · {{ targetName }}</div>
                    </div>

                    <div
                        v-for="t in translations"
                        :key="t.id"
                        class="flex items-center gap-3.5 border-b border-line px-[18px] py-2.5 last:border-b-0"
                    >
                        <div class="flex w-[240px] shrink-0 items-center gap-2">
                            <span class="truncate font-mono text-xs font-medium text-ink" :title="t.key">{{ t.key }}</span>
                            <Check v-if="savedRow === t.id" :size="14" class="shrink-0 text-ok" />
                        </div>
                        <div v-if="showSource" class="flex-1 truncate text-[13px] text-ink-3" :title="t.source">{{ t.source || '-' }}</div>
                        <div class="flex-1">
                            <div
                                v-if="t.zakljucano"
                                class="flex h-9 w-full items-center gap-2 rounded-md border border-line bg-surface-alt px-2.5 text-[13px] text-ink-3"
                                title="Lista (dani/mjeseci) - uređuje se u kodu, ne ovdje"
                            >
                                <Lock :size="13" class="shrink-0" />
                                <span class="truncate">{{ t.value }}</span>
                            </div>
                            <input
                                v-else
                                v-model="draft[t.id]"
                                type="text"
                                :class="isEmpty(t.id)
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
