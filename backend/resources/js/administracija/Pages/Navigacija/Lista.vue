<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { Plus, Pencil, Trash2, GripVertical, Eye, EyeOff, TriangleAlert, X, Menu as MenuIcon } from 'lucide-vue-next';
import Btn from '../../components/Btn.vue';
import IconBtn from '../../components/IconBtn.vue';
import FormField from '../../components/FormField.vue';
import SelectField from '../../components/SelectField.vue';
import EmptyState from '../../components/EmptyState.vue';
import { useConfirm } from '../../composables/useConfirm';

const props = defineProps({
    meniji: { type: Array, default: () => [] },
    aktivan: { type: Object, default: null },
    ciljevi: { type: Object, default: () => ({ stranice: [], kategorije: [] }) },
});

const { confirm } = useConfirm();
const page = usePage();

const locales = computed(() => {
    const list = page.props?.locales;
    return Array.isArray(list) && list.length ? list : [{ code: 'sr', name: 'Srpski' }];
});
const activeLang = ref(locales.value[0]?.code ?? 'sr');

const stavke = ref([...(props.aktivan?.stavke ?? [])]);
watch(() => props.aktivan?.stavke, (v) => { stavke.value = [...(v ?? [])]; });

const izaberiMeni = (key) => router.get('/administracija/navigacija', { meni: key }, { preserveState: true, preserveScroll: true, replace: true });

const TIP_LABELA = { page: 'Stranica', category: 'Kategorija', external: 'Vanjski link' };
const TIP_BOJE = { page: '#2271B1', category: '#0E8275', external: '#787C82' };
const tipStyle = (t) => {
    const boja = TIP_BOJE[t] || '#787C82';
    return { color: boja, backgroundColor: `${boja}1a` };
};

const prazna = () => ({
    id: null,
    label: {},
    target_type: 'page',
    target_id: '',
    url: '',
    parent_id: '',
});

const uredjivanje = ref(null);
const forma = useForm(prazna());

const otvoriNovu = () => {
    uredjivanje.value = 'nova';
    forma.defaults(prazna());
    forma.reset();
    forma.clearErrors();
};

const otvoriUredi = (s) => {
    uredjivanje.value = s.id;
    forma.clearErrors();
    forma.label = { ...(s.labelTranslations || {}) };
    forma.target_type = s.targetType;
    forma.target_id = s.targetId || '';
    forma.url = s.vanjskiUrl || '';
    forma.parent_id = s.parentId || '';
};

const zatvori = () => { uredjivanje.value = null; };

const ciljOpcije = computed(() => {
    if (forma.target_type === 'page') return props.ciljevi.stranice || [];
    if (forma.target_type === 'category') return props.ciljevi.kategorije || [];
    return [];
});

const roditeljOpcije = computed(() => [
    { value: '', label: '(glavni nivo)' },
    ...stavke.value.filter((s) => s.dubina === 0 && s.id !== uredjivanje.value).map((s) => ({ value: s.id, label: s.label })),
]);

const posalji = () => {
    if (uredjivanje.value === 'nova') {
        forma.post(`/administracija/navigacija/${props.aktivan.id}/stavke`, {
            preserveScroll: true,
            onSuccess: zatvori,
        });
    } else {
        forma.put(`/administracija/navigacija/stavke/${uredjivanje.value}`, {
            preserveScroll: true,
            onSuccess: zatvori,
        });
    }
};

const prebaciVidljivost = (s) => router.post(`/administracija/navigacija/stavke/${s.id}/vidljivost`, {}, { preserveScroll: true });

const obrisi = async (s) => {
    const ok = await confirm({
        danger: true,
        title: `Ukloniti „${s.label}"?`,
        message: 'Stavka i njene podstavke se uklanjaju iz menija.',
        confirmLabel: 'Ukloni stavku',
    });
    if (!ok) return;
    router.delete(`/administracija/navigacija/stavke/${s.id}`, { preserveScroll: true });
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
const onDrop = (target) => {
    const from = dragIdx.value;
    dragIdx.value = null;
    overIdx.value = null;
    if (from === null || from === target) return;
    const arr = [...stavke.value];
    const [moved] = arr.splice(from, 1);
    arr.splice(target, 0, moved);
    stavke.value = arr;
    router.post(`/administracija/navigacija/${props.aktivan.id}/redoslijed`, {
        stavke: arr.map((s) => ({ id: s.id, parent_id: s.parentId })),
    }, { preserveScroll: true, preserveState: true });
};

const brojMrtvih = computed(() => stavke.value.filter((s) => s.mrtav).length);
</script>

<template>
    <Head title="Navigacija" />

    <div class="space-y-[18px]">
        <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[22px] font-bold text-ink">Navigacija</h1>
                <p class="mt-1 text-sm text-ink-2">Meniji se vežu na stranice iz strukture - kad promijeniš slug, link se sam ažurira.</p>
            </div>
            <div v-if="brojMrtvih" class="flex items-center gap-2 rounded-lg bg-bad-bg px-3 py-2 text-[13px] font-semibold text-bad">
                <TriangleAlert :size="16" />
                {{ brojMrtvih }} {{ brojMrtvih === 1 ? 'mrtav link' : 'mrtvih linkova' }}
            </div>
        </header>

        <div class="flex flex-col gap-[18px] lg:flex-row">
            <div class="w-full shrink-0 overflow-hidden rounded-lg border border-line bg-surface lg:w-[300px]">
                <div class="border-b border-line px-4 py-3.5">
                    <h2 class="text-[15px] font-bold text-ink">Meniji</h2>
                </div>
                <button
                    v-for="m in meniji"
                    :key="m.key"
                    type="button"
                    class="flex w-full flex-col gap-0.5 border-b border-line px-4 py-2.5 text-left last:border-b-0"
                    :class="aktivan && m.key === aktivan.key ? 'bg-brand/10' : 'hover:bg-surface-alt'"
                    @click="izaberiMeni(m.key)"
                >
                    <span class="text-[13px] font-semibold" :class="aktivan && m.key === aktivan.key ? 'text-brand' : 'text-ink'">{{ m.name }}</span>
                    <span class="text-xs text-ink-3">{{ m.broj }} {{ m.broj === 1 ? 'stavka' : 'stavki' }}</span>
                </button>
            </div>

            <div class="flex-1 overflow-hidden rounded-lg border border-line bg-surface">
                <div class="flex items-center justify-between border-b border-line px-4 py-3">
                    <div>
                        <h2 class="text-[15px] font-bold text-ink">{{ aktivan?.name || 'Meni' }}</h2>
                        <p class="text-xs text-ink-3">Prevuci za redoslijed</p>
                    </div>
                    <Btn v-if="aktivan" variant="primary" :icon="Plus" @click="otvoriNovu">Dodaj stavku</Btn>
                </div>

                <div v-if="stavke.length">
                    <div
                        v-for="(s, i) in stavke"
                        :key="s.id"
                        class="flex items-center gap-3 border-b border-line px-4 py-2.5 last:border-b-0"
                        :class="[overIdx === i ? 'bg-brand/5' : '', s.visible ? '' : 'opacity-60']"
                        @dragover.prevent="overIdx = i"
                        @drop="onDrop(i)"
                    >
                        <div
                            class="shrink-0 cursor-grab text-ink-3 active:cursor-grabbing"
                            draggable="true"
                            title="Prevuci za redoslijed"
                            @dragstart="onDragStart($event, i)"
                        >
                            <GripVertical :size="15" />
                        </div>

                        <div class="min-w-0 flex-1" :style="s.dubina ? { paddingLeft: '26px' } : {}">
                            <span class="block truncate text-[13px] font-semibold text-ink">{{ s.label }}</span>
                            <span class="block truncate text-xs" :class="s.mrtav ? 'text-bad' : 'text-ink-3'">{{ s.url || 'nije razriješeno' }}</span>
                        </div>

                        <div class="w-[130px] shrink-0">
                            <span :style="tipStyle(s.targetType)" class="inline-flex items-center rounded px-2.5 py-[3px] text-xs font-semibold">
                                {{ TIP_LABELA[s.targetType] }}
                            </span>
                        </div>

                        <div class="flex w-[110px] shrink-0 items-center gap-1.5">
                            <template v-if="s.mrtav">
                                <TriangleAlert :size="14" class="text-bad" />
                                <span class="text-xs font-semibold text-bad">Mrtav link</span>
                            </template>
                        </div>

                        <div class="flex shrink-0 items-center gap-1.5">
                            <IconBtn :icon="s.visible ? Eye : EyeOff" :tooltip="s.visible ? 'Sakrij' : 'Prikaži'" size="sm" @click="prebaciVidljivost(s)" />
                            <IconBtn :icon="Pencil" tooltip="Uredi" size="sm" @click="otvoriUredi(s)" />
                            <IconBtn :icon="Trash2" tooltip="Ukloni" size="sm" color="bad" @click="obrisi(s)" />
                        </div>
                    </div>
                </div>

                <div v-else class="p-8">
                    <EmptyState :icon="MenuIcon" title="Meni je prazan" text="Dodajte prvu stavku u ovaj meni." />
                </div>
            </div>
        </div>

        <Teleport to="body">
            <div v-if="uredjivanje !== null" class="fixed inset-0 z-[60] flex items-start justify-center overflow-y-auto p-4 sm:p-8">
                <div class="absolute inset-0 bg-[#0f172a]/40" @click="zatvori"></div>
                <div class="relative my-auto w-full max-w-[520px] overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface shadow-[var(--shadow-pop)]">
                    <div class="flex items-center justify-between border-b border-line px-[18px] py-[15px]">
                        <h3 class="text-[15px] font-bold text-ink">{{ uredjivanje === 'nova' ? 'Nova stavka' : 'Uredi stavku' }}</h3>
                        <button type="button" class="text-ink-3 hover:text-ink" aria-label="Zatvori" @click="zatvori">
                            <X :size="18" />
                        </button>
                    </div>

                    <form @submit.prevent="posalji">
                        <div class="max-h-[70vh] space-y-4 overflow-y-auto p-5">
                            <div class="flex items-center gap-1.5">
                                <button
                                    v-for="loc in locales"
                                    :key="loc.code"
                                    type="button"
                                    class="rounded px-2 py-0.5 text-xs font-bold"
                                    :class="loc.code === activeLang ? 'bg-brand text-white' : 'bg-surface-alt text-ink-3'"
                                    @click="activeLang = loc.code"
                                >
                                    {{ loc.code.toUpperCase() }}
                                </button>
                            </div>

                            <FormField
                                :model-value="forma.label[activeLang] || ''"
                                label="Naziv u meniju"
                                :error="forma.errors['label.sr']"
                                @update:model-value="forma.label = { ...forma.label, [activeLang]: $event }"
                            />

                            <SelectField
                                :model-value="forma.target_type"
                                label="Cilj"
                                :options="[
                                    { value: 'page', label: 'Stranica' },
                                    { value: 'category', label: 'Kategorija' },
                                    { value: 'external', label: 'Vanjski link' },
                                ]"
                                @update:model-value="forma.target_type = $event; forma.target_id = ''"
                            />

                            <SelectField
                                v-if="forma.target_type !== 'external'"
                                :model-value="forma.target_id"
                                :label="forma.target_type === 'page' ? 'Stranica' : 'Kategorija'"
                                :options="ciljOpcije"
                                placeholder="Izaberi…"
                                :error="forma.errors.target_id"
                                @update:model-value="forma.target_id = $event"
                            />

                            <FormField
                                v-else
                                :model-value="forma.url"
                                label="URL"
                                placeholder="https://…"
                                :error="forma.errors.url"
                                @update:model-value="forma.url = $event"
                            />

                            <SelectField
                                :model-value="forma.parent_id"
                                label="Roditelj"
                                :options="roditeljOpcije"
                                @update:model-value="forma.parent_id = $event"
                            />
                        </div>

                        <div class="flex justify-end gap-2.5 border-t border-line bg-surface-alt px-5 py-4">
                            <Btn variant="secondary" @click="zatvori">Odustani</Btn>
                            <Btn variant="primary" type="submit" :disabled="forma.processing">
                                {{ uredjivanje === 'nova' ? 'Dodaj' : 'Sačuvaj' }}
                            </Btn>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
    </div>
</template>
