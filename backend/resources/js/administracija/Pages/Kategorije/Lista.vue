<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { Plus, Pencil, Trash2, GripVertical, Tag, Search } from 'lucide-vue-next';
import Btn from '../../components/Btn.vue';
import IconBtn from '../../components/IconBtn.vue';
import Tabs from '../../components/Tabs.vue';
import Pagination from '../../components/Pagination.vue';
import EmptyState from '../../components/EmptyState.vue';
import { resolveCategoryIcon, TIP_BOJE } from '../../lib/categoryIcon';
import { useConfirm } from '../../composables/useConfirm';

const props = defineProps({
    kategorije: { type: Object, default: () => ({ data: [], links: [] }) },
    filteri: { type: Object, default: () => ({ tip: 'sve', q: '' }) },
    tipovi: { type: Array, default: () => [] },
});

const { confirm } = useConfirm();
const page = usePage();

const locales = computed(() => {
    const list = page.props?.locales;
    return Array.isArray(list) && list.length ? list : [{ code: 'sr', name: 'Srpski' }];
});

const tabovi = computed(() => [{ key: 'sve', label: 'Sve' }, ...props.tipovi]);
const aktivniTab = ref(props.filteri?.tip ?? 'sve');
const pretraga = ref(props.filteri?.q ?? '');

const redovi = ref([...(props.kategorije?.data ?? [])]);
watch(() => props.kategorije?.data, (d) => { redovi.value = [...(d ?? [])]; });

const primijeni = (patch = {}) => {
    router.get('/administracija/kategorije', {
        tip: aktivniTab.value !== 'sve' ? aktivniTab.value : undefined,
        q: pretraga.value || undefined,
        ...patch,
    }, { preserveState: true, preserveScroll: true, replace: true });
};

const promijeniTab = (key) => {
    aktivniTab.value = key;
    primijeni({ tip: key !== 'sve' ? key : undefined });
};

let pretragaTimer = null;
watch(pretraga, () => {
    clearTimeout(pretragaTimer);
    pretragaTimer = setTimeout(() => primijeni({ q: pretraga.value || undefined }), 300);
});

const swatchStyle = (color) => ({ backgroundColor: `${color || '#0E8275'}1a` });
const tipStyle = (tip) => {
    const boja = TIP_BOJE[tip] || '#64748b';
    return { color: boja, backgroundColor: `${boja}1a` };
};

const obrisi = async (k) => {
    if (k.brojStavki > 0) {
        await confirm({
            title: `„${k.label}" se ne može obrisati`,
            message: `Kategorija sadrži ${k.brojStavki} stavki. Premjestite ih prije brisanja.`,
            confirmLabel: 'U redu',
        });
        return;
    }
    const ok = await confirm({
        danger: true,
        title: `Obrisati „${k.label}"?`,
        message: 'Kategorija se trajno briše.',
        confirmLabel: 'Obriši kategoriju',
    });
    if (!ok) return;
    router.delete(`/administracija/kategorije/${k.id}`, { preserveScroll: true });
};

const dragIdx = ref(null);
const overIdx = ref(null);
const onDragStart = (e, i) => {
    dragIdx.value = i;
    if (e.dataTransfer) {
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', String(i));
    }
};
const onDragOver = (i) => { overIdx.value = i; };
const onDrop = (target) => {
    const from = dragIdx.value;
    dragIdx.value = null;
    overIdx.value = null;
    if (from === null || from === target) return;
    const arr = [...redovi.value];
    const [moved] = arr.splice(from, 1);
    arr.splice(target, 0, moved);
    redovi.value = arr;
    router.post('/administracija/kategorije/redoslijed', { redoslijed: arr.map((k) => k.id) }, {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <Head title="Kategorije" />

    <div class="space-y-[18px]">
        <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[22px] font-bold text-ink">Kategorije</h1>
                <p class="mt-1 text-sm text-ink-2">Jedinstvena taksonomija za biznise, turizam, događaje i priče</p>
            </div>
            <Btn variant="primary" :icon="Plus" href="/administracija/kategorije/nova">Nova kategorija</Btn>
        </header>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <Tabs :tabs="tabovi" :model-value="aktivniTab" @update:model-value="promijeniTab" />
            <div class="relative w-full sm:w-[240px]">
                <Search :size="15" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-ink-3" />
                <input
                    v-model="pretraga"
                    type="text"
                    placeholder="Pretraži kategorije"
                    class="h-9 w-full rounded-md border border-line bg-surface pl-9 pr-3 text-[13px] text-ink placeholder:text-ink-3 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                />
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-line bg-surface">
            <div v-if="redovi.length" class="w-full overflow-x-auto">
                <div class="min-w-[880px]">
                    <div class="flex items-center border-b border-line bg-surface-alt px-[18px] py-2.5">
                        <div class="w-11 shrink-0"></div>
                        <div class="flex-1 text-xs font-semibold text-ink-3">Kategorija</div>
                        <div class="w-40 shrink-0 text-xs font-semibold text-ink-3">Tip</div>
                        <div class="w-[110px] shrink-0 text-xs font-semibold text-ink-3">Stavki</div>
                        <div class="w-[170px] shrink-0 text-xs font-semibold text-ink-3">Prijevodi</div>
                        <div class="w-[110px] shrink-0 pr-2 text-right text-xs font-semibold text-ink-3">Akcije</div>
                    </div>

                    <div
                        v-for="(k, i) in redovi"
                        :key="k.id"
                        class="flex cursor-pointer items-center border-b border-line px-[18px] py-3 last:border-b-0 hover:bg-surface-alt"
                        :class="[overIdx === i ? 'bg-brand/5' : '', k.visible ? '' : 'opacity-60']"
                        @click="router.visit(`/administracija/kategorije/${k.id}/uredi`)"
                        @dragover.prevent="onDragOver(i)"
                        @drop="onDrop(i)"
                    >
                        <div
                            class="flex w-11 shrink-0 cursor-grab items-center justify-center text-ink-3 active:cursor-grabbing"
                            draggable="true"
                            title="Prevuci za promjenu redoslijeda"
                            @click.stop
                            @dragstart="onDragStart($event, i)"
                        >
                            <GripVertical :size="16" />
                        </div>
                        <div class="flex min-w-0 flex-1 items-center gap-3">
                            <span
                                :style="swatchStyle(k.color)"
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg"
                            >
                                <component :is="resolveCategoryIcon(k.icon)" :size="16" :style="{ color: k.color || '#0E8275' }" />
                            </span>
                            <div class="min-w-0">
                                <span class="block truncate text-[13px] font-semibold text-ink">{{ k.label }}</span>
                                <span class="block truncate text-xs text-ink-3">ključ: {{ k.key }}</span>
                            </div>
                        </div>
                        <div class="w-40 shrink-0">
                            <span
                                :style="tipStyle(k.type)"
                                class="inline-flex items-center rounded px-2.5 py-[3px] text-xs font-semibold"
                            >
                                {{ k.tipLabel }}
                            </span>
                        </div>
                        <div class="w-[110px] shrink-0 text-[13px] text-ink-2">{{ k.brojStavki }} {{ k.type === 'price' ? 'priča' : 'stavki' }}</div>
                        <div class="flex w-[170px] shrink-0 items-center gap-1.5">
                            <span
                                v-for="loc in locales"
                                :key="loc.code"
                                class="rounded px-1.5 py-0.5 text-[11px] font-bold"
                                :class="k.prijevodi.includes(loc.code) ? 'bg-brand/10 text-brand' : 'bg-surface-alt text-ink-3'"
                            >
                                {{ loc.code.toUpperCase() }}
                            </span>
                        </div>
                        <div class="flex w-[110px] shrink-0 items-center justify-end gap-1.5 pr-2" @click.stop>
                            <IconBtn :icon="Pencil" tooltip="Uredi" size="sm" @click="router.visit(`/administracija/kategorije/${k.id}/uredi`)" />
                            <IconBtn :icon="Trash2" tooltip="Obriši" size="sm" color="bad" @click="obrisi(k)" />
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="p-8">
                <EmptyState :icon="Tag" title="Nema kategorija" text="Dodajte prvu kategoriju u taksonomiju." />
            </div>
        </div>

        <Pagination :links="kategorije.links" :meta="kategorije" />
    </div>
</template>
