<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref, watch, onMounted, onBeforeUnmount } from 'vue';
import {
    ArrowLeft, Plus, Save, Eye, Globe, Copy, Trash2, GripVertical, Languages, Layers, X, Search,
    Monitor, Smartphone, RefreshCw, ExternalLink, Loader2,
    PanelTop, Heading, Type, LayoutGrid, Megaphone, Grid2x2, Images, Play, Map as MapIcon,
    ListOrdered, PanelsTopLeft, MessagesSquare, ChartColumn, Handshake, Star, User, MoveVertical, List,
    Link2, Link2Off,
} from 'lucide-vue-next';
import Card from '../../components/Card.vue';
import Btn from '../../components/Btn.vue';
import Badge from '../../components/Badge.vue';
import BlockField from '../../components/BlockField.vue';
import FormField from '../../components/FormField.vue';
import SelectField from '../../components/SelectField.vue';
import TextareaField from '../../components/TextareaField.vue';
import BlockImageField from '../../components/BlockImageField.vue';
import RowMenu from '../../components/RowMenu.vue';
import { useConfirm } from '../../composables/useConfirm';

const props = defineProps({
    tipovi: { type: Array, default: () => [] },
    kategorije: { type: Array, default: () => [] },
    roditelji: { type: Array, default: () => [] },
    katTipovi: { type: Object, default: () => ({}) },
    ciljevi: { type: Object, default: () => ({ stranice: [], kategorije: [] }) },
    paleta: { type: Array, default: () => [] },
    globalBlokovi: { type: Array, default: () => [] },
    globalUpotreba: { type: Object, default: () => ({}) },
    stranica: { type: Object, required: true },
    schema: { type: Object, required: true },
    katalog: { type: Array, default: () => [] },
    defaults: { type: Object, default: () => ({}) },
    siteName: { type: Object, default: () => ({}) },
});

const SEO_TITLE_MAX = 60;
const SEO_DESC_MAX = 160;

const { confirm } = useConfirm();
const page = usePage();

const locales = computed(() => {
    const list = page.props?.locales;
    return Array.isArray(list) && list.length ? list : [{ code: 'sr', name: 'Srpski' }];
});
const activeLang = ref(locales.value[0]?.code ?? 'sr');
const langName = computed(() => locales.value.find((l) => l.code === activeLang.value)?.name ?? activeLang.value);

const TYPE_ICON = {
    hero: PanelTop, section_header: Heading, rich_text: Type, card_grid: LayoutGrid, resource_list: List,
    cta: Megaphone, category_nav: Grid2x2, gallery: Images, video: Play, map: MapIcon,
    stepper: ListOrdered, info_panel: PanelsTopLeft, faq: MessagesSquare, stats: ChartColumn,
    partners: Handshake, featured_story: Star, author: User, spacer: MoveVertical,
};
const RESOURCE_LABEL = { business: 'Biznisi', location: 'Lokaliteti', event: 'Događaji', ad: 'Oglasi', story: 'Priče' };

const clone = (v) => JSON.parse(JSON.stringify(v ?? null));

const blocks = ref(clone(props.stranica.blocks) ?? []);
const selected = ref(blocks.value.length ? 0 : null);
const tab = ref('blok');
const showPicker = ref(false);
const pickerQuery = ref('');
const savingContent = ref(false);

let baseline = JSON.stringify(blocks.value);
const blokoviDirty = computed(() => JSON.stringify(blocks.value) !== baseline);

const SETTINGS_FIELDS = [
    { name: 'background', label: 'Pozadina', type: 'select', options: { '': 'Podrazumijevano', transparent: 'Prozirna', surface: 'Površina', 'surface-alt': 'Površina (alt)', 'primary-tint': 'Brend (svijetlo)', primary: 'Brend' } },
    { name: 'padding', label: 'Vertikalni razmak', type: 'select', options: { '': 'Podrazumijevano', none: 'Bez razmaka', sm: 'Mali', md: 'Srednji', lg: 'Veliki' } },
    { name: 'width', label: 'Širina sadržaja', type: 'select', options: { '': 'Puna širina', narrow: 'Uska' } },
    { name: 'hidden', label: 'Sakrij blok na sajtu', type: 'toggle' },
];

const label = (type) => props.schema[type]?.label ?? type;
const icon = (type) => TYPE_ICON[type] ?? LayoutGrid;

const tr = (v) => (v && typeof v === 'object' ? (v[activeLang.value] ?? v.sr ?? '') : (v ?? ''));

const summary = (block) => {
    const d = block.data || {};
    const parts = [];
    const title = tr(d.title) || tr(d.naslov) || tr(d.ime);
    if (title) parts.push(title);
    switch (block.type) {
        case 'card_grid':
            parts.push(RESOURCE_LABEL[d.resource] || 'Kartice');
            if (d.limit) parts.push(`${d.limit} kartica`);
            break;
        case 'resource_list':
            parts.push(RESOURCE_LABEL[d.resource] || 'Kao na stranici');
            if (d.filteri) parts.push('filteri');
            if (d.pretraga) parts.push('pretraga');
            break;
        case 'gallery': parts.push(`${(d.items || []).length} slika`); break;
        case 'faq': parts.push(`${(d.items || []).length} pitanja`); break;
        case 'stats': case 'partners': case 'category_nav': case 'info_panel':
            parts.push(`${(d.items || []).length} stavki`); break;
        case 'stepper': parts.push(`${(d.steps || []).length} koraka`); break;
        case 'cta': parts.push(`${(d.buttons || []).length} dugmad`); break;
        case 'hero': if (d.image) parts.push('slika'); break;
        case 'map': if (!title) parts.push('Interaktivna mapa'); break;
        case 'spacer': parts.push('Vertikalni razmak'); break;
    }
    return parts.join(' · ') || props.schema[block.type]?.opis || '';
};

const current = computed(() => (selected.value != null ? blocks.value[selected.value] : null));
const currentFields = computed(() => (current.value ? (props.schema[current.value.type]?.fields ?? []) : []));

const setField = (name, val) => { if (current.value) current.value.data[name] = val; };
const setSetting = (name, val) => {
    if (!current.value) return;
    if (!current.value.data.settings) current.value.data.settings = {};
    current.value.data.settings[name] = val;
};

const filteredKatalog = computed(() => {
    const q = pickerQuery.value.trim().toLowerCase();
    if (!q) return props.katalog;
    return props.katalog.filter((k) => `${k.label} ${k.opis}`.toLowerCase().includes(q));
});

const filteredGlobalni = computed(() => {
    const q = pickerQuery.value.trim().toLowerCase();
    if (!q) return props.globalBlokovi;
    return props.globalBlokovi.filter((g) => `${g.name} ${label(g.type)}`.toLowerCase().includes(q));
});

const upotrebaZa = (gid) => props.globalUpotreba?.[gid] || [];
const upotrebaTekst = (gid) => upotrebaZa(gid).map((p) => p.naslov).join(', ');

const obrisiGlobalni = async (g) => {
    const koristi = upotrebaZa(g.id).length;
    const ok = await confirm({
        danger: true,
        title: `Obrisati globalni blok „${g.name}"?`,
        message: koristi
            ? `Blok je postavljen na ${koristi} ${koristi === 1 ? 'stranici' : 'stranica'}. Te instance se odvezuju i ostaju kao samostalne kopije.`
            : 'Globalni blok se trajno briše.',
        confirmLabel: 'Obriši globalni blok',
    });
    if (!ok) return;
    router.delete(`/administracija/globalni-blokovi/${g.id}`, { preserveScroll: true });
};

const addBlock = (type) => {
    const def = props.defaults[type];
    if (!def) return;
    const block = clone(def);
    const at = selected.value != null ? selected.value + 1 : blocks.value.length;
    blocks.value.splice(at, 0, block);
    selected.value = at;
    tab.value = 'blok';
    showPicker.value = false;
    pickerQuery.value = '';
};

const duplicateBlock = (i) => {
    const kopija = clone(blocks.value[i]);
    delete kopija.global_id;
    delete kopija.globalNaziv;
    blocks.value.splice(i + 1, 0, kopija);
    selected.value = i + 1;
};

const dodajGlobalni = (g) => {
    const block = { type: g.type, data: clone(g.data) || {}, global_id: g.id, globalNaziv: g.name };
    const at = selected.value != null ? selected.value + 1 : blocks.value.length;
    blocks.value.splice(at, 0, block);
    selected.value = at;
    tab.value = 'blok';
    showPicker.value = false;
    pickerQuery.value = '';
};

const globalNazivModal = ref(false);
const globalNaziv = ref('');
const globalIndex = ref(null);

const otvoriPostaviGlobalni = (i) => {
    globalIndex.value = i;
    globalNaziv.value = summary(blocks.value[i]) || label(blocks.value[i].type);
    globalNazivModal.value = true;
};

const potvrdiGlobalni = () => {
    const i = globalIndex.value;
    const naziv = globalNaziv.value.trim();
    if (i == null || !naziv) return;

    globalNazivModal.value = false;

    router.post(`/administracija/stranice/${props.stranica.id}/globalni-blok`,
        { blocks: blocks.value, index: i, name: naziv },
        { preserveScroll: true },
    );
};

const odveziGlobalni = async (i) => {
    const ok = await confirm({
        title: 'Odvezati od globalnog bloka?',
        message: 'Blok postaje samostalna kopija na ovoj stranici. Buduće izmjene globalnog bloka ga više neće mijenjati.',
        confirmLabel: 'Odveži',
    });
    if (!ok) return;
    delete blocks.value[i].global_id;
    delete blocks.value[i].globalNaziv;
};

const removeBlock = async (i) => {
    const ok = await confirm({
        danger: true,
        title: 'Obrisati blok?',
        message: `Blok „${label(blocks.value[i].type)}" se uklanja sa stranice.`,
        confirmLabel: 'Obriši blok',
    });
    if (!ok) return;
    blocks.value.splice(i, 1);
    if (!blocks.value.length) selected.value = null;
    else if (selected.value >= blocks.value.length) selected.value = blocks.value.length - 1;
};

const blockDragIdx = ref(null);
const blockOverIdx = ref(null);
const onBlockDragStart = (e, i) => {
    blockDragIdx.value = i;
    if (e.dataTransfer) {
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', String(i));
    }
};
const onBlockDrop = (target) => {
    const from = blockDragIdx.value;
    blockDragIdx.value = null;
    blockOverIdx.value = null;
    if (from === null || from === target) return;
    const selBlock = selected.value != null ? blocks.value[selected.value] : null;
    const next = [...blocks.value];
    const [moved] = next.splice(from, 1);
    next.splice(target, 0, moved);
    blocks.value = next;
    if (selBlock) selected.value = next.indexOf(selBlock);
};

const saveContent = () => {
    if (postavkeDirty.value) {
        savePostavke();
    }

    if (! blokoviDirty.value) {
        return;
    }

    savingContent.value = true;
    router.put(`/administracija/stranice/${props.stranica.id}/sadrzaj`, { blocks: blocks.value }, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => { baseline = JSON.stringify(blocks.value); },
        onFinish: () => { savingContent.value = false; },
    });
};

const postavke = ref({
    title: { ...props.stranica.title },
    slug: { ...(props.stranica.slug || {}) },
    published: props.stranica.published,
    meta_title: { ...props.stranica.metaTitle },
    meta_description: { ...props.stranica.metaDescription },
    og_image: props.stranica.ogImage || '',
    resource_type: props.stranica.resourceType || '',
    category_id: props.stranica.categoryId || '',
    parent_id: props.stranica.parentId || '',
});

const tipoviOpcije = computed(() => [{ value: '', label: 'Obična stranica' }, ...(props.tipovi || [])]);
const kategorijeOpcije = computed(() => {
    const tip = postavke.value.resource_type;
    const catType = tip ? (props.katTipovi || {})[tip] : null;
    const sve = props.kategorije || [];
    const filtrirane = catType ? sve.filter((k) => k.type === catType) : sve;
    return [{ value: '', label: 'Sve kategorije' }, ...filtrirane];
});
const roditeljiOpcije = computed(() => [{ value: '', label: '(bez roditelja)' }, ...(props.roditelji || [])]);

const coverFallback = computed(() => {
    const hero = blocks.value.find((b) => b.type === 'hero' && b.data?.image);
    return hero?.data?.image || '';
});
const slugPrijedlog = computed(() => String(trGet(postavke.value.title) || '')
    .toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)/g, ''));

const postavkeErr = ref({});
const savingPostavke = ref(false);

let postavkeBaseline = JSON.stringify(postavke.value);
const postavkeDirty = computed(() => JSON.stringify(postavke.value) !== postavkeBaseline);
const dirty = computed(() => blokoviDirty.value || postavkeDirty.value);

const trGet = (map) => map?.[activeLang.value] ?? '';
const trSet = (key, val) => { postavke.value[key] = { ...(postavke.value[key] || {}), [activeLang.value]: val }; };

const savePostavke = () => {
    savingPostavke.value = true;
    router.put(`/administracija/stranice/${props.stranica.id}`, postavke.value, {
        preserveScroll: true,
        preserveState: true,
        onError: (e) => { postavkeErr.value = e; },
        onSuccess: () => { postavkeErr.value = {}; postavkeBaseline = JSON.stringify(postavke.value); },
        onFinish: () => { savingPostavke.value = false; },
    });
};

const naslov = computed(() => tr(props.stranica.title) || '(bez naslova)');
const brojBlokova = computed(() => blocks.value.length);

const siteNameLang = computed(() => props.siteName?.[activeLang.value] ?? props.siteName?.sr ?? '');

const metaDesc = computed(() => trGet(postavke.value.meta_description));

const titleSuffix = computed(() => siteNameLang.value ? ` - ${siteNameLang.value}` : '');
const metaTitleFront = computed({
    get() {
        const full = trGet(postavke.value.meta_title);
        const s = titleSuffix.value;
        return (s && full.endsWith(s)) ? full.slice(0, -s.length) : full;
    },
    set(val) {
        trSet('meta_title', val);
    },
});
const effectiveMetaTitle = computed(() => {
    const base = metaTitleFront.value || trGet(postavke.value.title) || 'Naslov stranice';
    const s = siteNameLang.value;
    if (! s) return base;
    return base.endsWith(` - ${s}`) ? base : `${base} - ${s}`;
});
const titleLen = computed(() => effectiveMetaTitle.value.length);
const descLen = computed(() => metaDesc.value.length);

const langPrefix = computed(() => (activeLang.value === defaultLang.value ? '' : `/${activeLang.value}`));

const counterClass = (len, max, min) => {
    if (len === 0) return 'text-ink-3';
    if (len > max) return 'text-bad';
    if (min && len < min) return 'text-warn';
    return 'text-ok';
};

const seoChecks = computed(() => {
    const titleSet = titleLen.value > 0;
    const descSet = descLen.value > 0;
    const custom = trGet(postavke.value.meta_title).length > 0;
    return [
        { label: 'Meta naslov postavljen', status: titleSet ? 'ok' : 'bad', weight: 22 },
        { label: `Dužina naslova 30-${SEO_TITLE_MAX} znakova`, status: !titleSet ? 'bad' : (titleLen.value >= 30 && titleLen.value <= SEO_TITLE_MAX ? 'ok' : 'warn'), weight: 15 },
        { label: 'Jedinstven meta naslov (ne samo default)', status: custom ? 'ok' : 'warn', weight: 8 },
        { label: 'Meta opis postavljen', status: descSet ? 'ok' : 'bad', weight: 25 },
        { label: `Dužina opisa 120-${SEO_DESC_MAX} znakova`, status: !descSet ? 'bad' : (descLen.value >= 120 && descLen.value <= SEO_DESC_MAX ? 'ok' : 'warn'), weight: 15 },
        { label: 'Slika za dijeljenje postoji', status: (postavke.value.og_image || coverFallback.value) ? 'ok' : 'warn', weight: 15 },
    ];
});

const seoScore = computed(() => Math.round(
    seoChecks.value.reduce((s, c) => s + (c.status === 'ok' ? c.weight : c.status === 'warn' ? c.weight * 0.5 : 0), 0),
));

const seoGrade = computed(() => {
    const s = seoScore.value;
    if (s >= 80) return { label: 'Dobro', color: 'ok', bar: 'bg-ok' };
    if (s >= 50) return { label: 'Može bolje', color: 'warn', bar: 'bg-warn' };
    return { label: 'Slabo', color: 'bad', bar: 'bg-bad' };
});

const googlePreview = computed(() => ({
    url: `teslic.travel${langPrefix.value}${props.stranica.url === '/' ? '' : props.stranica.url}`,
    title: effectiveMetaTitle.value,
    desc: metaDesc.value || 'Meta opis prikazan u rezultatima pretrage.',
}));

const previewOpen = ref(false);
const previewDevice = ref('desktop');
const previewNonce = ref(0);
const previewPushing = ref(false);

const defaultLang = computed(() => locales.value[0]?.code ?? 'sr');
const previewPath = computed(() => {
    const prefix = activeLang.value === defaultLang.value ? '' : `/${activeLang.value}`;
    const u = props.stranica.url;
    return u === '/' ? (prefix || '/') : `${prefix}${u}`;
});
const previewUrl = computed(() => `${previewPath.value}?preview=1&t=${previewNonce.value}`);

const csrf = () => {
    const m = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]+)/);
    return m ? decodeURIComponent(m[1]) : '';
};

const pushDraft = async () => {
    previewPushing.value = true;
    try {
        await fetch(`/administracija/stranice/${props.stranica.id}/pregled-draft`, {
            method: 'POST',
            headers: { 'X-XSRF-TOKEN': csrf(), 'Content-Type': 'application/json', Accept: 'application/json' },
            body: JSON.stringify({ blocks: blocks.value }),
        });
        previewNonce.value++;
    } catch {
        // ignore
    } finally {
        previewPushing.value = false;
    }
};

const openPreview = async () => {
    previewOpen.value = true;
    await pushDraft();
};

let draftTimer = null;
watch(blocks, () => {
    if (!previewOpen.value) return;
    clearTimeout(draftTimer);
    draftTimer = setTimeout(pushDraft, 700);
}, { deep: true });

onBeforeUnmount(() => clearTimeout(draftTimer));

const beforeUnload = (e) => {
    if (!dirty.value) return;
    e.preventDefault();
    e.returnValue = '';
};

let removeInertiaGuard = null;
onMounted(() => {
    window.addEventListener('beforeunload', beforeUnload);
    removeInertiaGuard = router.on('before', (event) => {
        const method = event.detail?.visit?.method;
        if (method && method !== 'get') return;
        if (dirty.value && !window.confirm('Imaš nesačuvane izmjene sadržaja. Napustiti stranicu bez čuvanja?')) {
            event.preventDefault();
        }
    });
});
onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', beforeUnload);
    if (removeInertiaGuard) removeInertiaGuard();
});
</script>

<template>
    <Head :title="`Uredi: ${naslov}`" />

    <div class="space-y-4">
        <header class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3">
                <button type="button" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-md border border-line bg-surface text-ink-2 hover:bg-surface-alt hover:text-ink" title="Nazad na listu" @click="router.visit('/administracija/stranice')">
                    <ArrowLeft :size="18" />
                </button>
                <div class="min-w-0">
                    <div class="flex items-center gap-2.5">
                        <h1 class="truncate text-[20px] font-bold text-ink">Uređivanje: {{ naslov }}</h1>
                        <Badge :label="stranica.published ? 'Objavljeno' : 'Nacrt'" :color="stranica.published ? 'ok' : 'gray'" />
                    </div>
                    <div class="mt-0.5 flex items-center gap-2 text-xs text-ink-3">
                        <span>{{ stranica.url }}</span>
                        <span>·</span>
                        <span>{{ brojBlokova }} {{ brojBlokova === 1 ? 'blok' : 'blokova' }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5 rounded-lg border border-line bg-surface px-2 py-1">
                    <Globe :size="15" class="text-ink-3" />
                    <button
                        v-for="loc in locales"
                        :key="loc.code"
                        type="button"
                        :class="loc.code === activeLang ? 'bg-brand text-white' : 'text-ink-3 hover:bg-surface-alt hover:text-ink'"
                        class="rounded-md px-2.5 py-1 text-[12px] font-bold uppercase"
                        @click="activeLang = loc.code"
                    >
                        {{ loc.code }}
                    </button>
                </div>
                <button type="button" class="inline-flex h-9 items-center gap-2 rounded-md border border-line bg-surface px-4 text-sm font-semibold text-ink-2 hover:bg-surface-alt" @click="openPreview">
                    <Eye :size="16" /> Pregled
                </button>
                <Btn variant="primary" :icon="Save" :disabled="savingContent || savingPostavke || !dirty" @click="saveContent">Sačuvaj</Btn>
            </div>
        </header>

        <div class="grid grid-cols-1 gap-[18px] lg:grid-cols-[380px_minmax(0,1fr)]">
            <div>
                <Card :padded="false">
                    <div class="flex items-center gap-2 border-b border-line px-4 py-3.5">
                        <h2 class="text-[15px] font-bold text-ink">Blokovi</h2>
                        <span class="inline-flex items-center justify-center rounded-full bg-surface-alt px-2 py-0.5 text-xs font-semibold text-ink-2">{{ brojBlokova }}</span>
                    </div>

                    <div v-if="blocks.length" class="max-h-[calc(100vh-260px)] overflow-y-auto">
                        <div
                            v-for="(block, i) in blocks"
                            :key="i"
                            :class="[
                                selected === i ? 'bg-brand-tint' : (block.global_id ? 'bg-brand-tint/40 hover:bg-brand-tint/60' : 'hover:bg-surface-alt'),
                                blockOverIdx === i && blockDragIdx !== null ? 'border-t-2 border-t-brand' : '',
                                block.global_id ? 'border-l-[3px] border-l-brand' : '',
                            ]"
                            class="flex cursor-pointer items-center gap-2.5 border-b border-line px-3.5 py-2.5 last:border-b-0"
                            @click="selected = i; tab = 'blok'"
                            @dragover.prevent="blockOverIdx = i"
                            @drop="onBlockDrop(i)"
                        >
                            <span
                                class="shrink-0 cursor-grab text-ink-3 hover:text-ink active:cursor-grabbing"
                                draggable="true"
                                title="Prevuci za promjenu redoslijeda"
                                @click.stop
                                @dragstart="onBlockDragStart($event, i)"
                                @dragend="blockDragIdx = null; blockOverIdx = null"
                            >
                                <GripVertical :size="16" />
                            </span>
                            <span :class="selected === i ? 'bg-brand text-white' : (block.global_id ? 'bg-brand/15 text-brand' : 'bg-surface-alt text-ink-2')" class="inline-flex h-[34px] w-[34px] shrink-0 items-center justify-center rounded-[7px]">
                                <component :is="icon(block.type)" :size="17" />
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="flex items-center gap-1.5">
                                    <span :class="selected === i ? 'text-brand' : 'text-ink'" class="truncate text-[13px] font-semibold">{{ block.global_id ? block.globalNaziv : label(block.type) }}</span>
                                    <Link2 v-if="block.global_id" :size="12" class="shrink-0 text-brand" />
                                </span>
                                <span class="block truncate text-[11px] text-ink-3">{{ block.global_id ? ('Globalni · ' + label(block.type)) : summary(block) }}</span>
                            </span>
                            <div @click.stop>
                                <RowMenu>
                                    <template #default="{ close }">
                                        <button type="button" class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-ink-2 hover:bg-surface-alt hover:text-ink" @click="close(); duplicateBlock(i)">
                                            <Copy :size="16" /> Dupliraj
                                        </button>
                                        <div class="my-1.5 border-t border-line"></div>
                                        <button type="button" class="flex w-full items-center gap-2.5 px-3.5 py-2 text-left text-[13px] text-bad hover:bg-bad-bg" @click="close(); removeBlock(i)">
                                            <Trash2 :size="16" /> Obriši
                                        </button>
                                    </template>
                                </RowMenu>
                            </div>
                        </div>
                    </div>

                    <div v-else class="px-5 py-8 text-center">
                        <Layers :size="24" class="mx-auto text-ink-3" />
                        <p class="mt-2 text-[13px] font-semibold text-ink">Nema blokova</p>
                        <p class="mt-0.5 text-xs text-ink-3">Dodajte prvi blok na stranicu.</p>
                    </div>

                    <div class="p-3">
                        <button type="button" class="flex w-full items-center justify-center gap-1.5 rounded-md border border-line-strong bg-surface px-3 py-2.5 text-[13px] font-semibold text-brand hover:bg-brand-tint" @click="showPicker = true">
                            <Plus :size="16" /> Dodaj blok
                        </button>
                    </div>
                </Card>
            </div>

            <Card :padded="false">
                <div class="flex items-center gap-1.5 border-b border-line bg-surface-alt px-3.5 py-2">
                    <button type="button" :class="tab === 'blok' ? 'bg-surface text-ink shadow-[var(--shadow-sm)]' : 'text-ink-3 hover:text-ink'" class="rounded-md px-3.5 py-1.5 text-[13px] font-semibold" @click="tab = 'blok'">Blok</button>
                    <button type="button" :class="tab === 'seo' ? 'bg-surface text-ink shadow-[var(--shadow-sm)]' : 'text-ink-3 hover:text-ink'" class="rounded-md px-3.5 py-1.5 text-[13px] font-semibold" @click="tab = 'seo'">Stranica i SEO</button>
                </div>

                <template v-if="tab === 'blok'">
                    <template v-if="current">
                        <div class="flex items-center justify-between gap-2 border-b border-line px-[18px] py-3">
                            <div class="flex items-center gap-2.5">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-brand-tint text-brand">
                                    <component :is="icon(current.type)" :size="18" />
                                </span>
                                <div>
                                    <p class="text-[15px] font-bold text-ink">{{ label(current.type) }}</p>
                                    <p class="text-xs text-ink-3">Blok {{ selected + 1 }} od {{ brojBlokova }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button
                                    v-if="!current.global_id"
                                    type="button"
                                    title="Postavi kao globalni blok"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-md text-ink-2 hover:bg-surface-alt hover:text-ink"
                                    @click="otvoriPostaviGlobalni(selected)"
                                >
                                    <Link2 :size="16" />
                                </button>
                                <button type="button" title="Dupliraj" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-ink-2 hover:bg-surface-alt hover:text-ink" @click="duplicateBlock(selected)">
                                    <Copy :size="16" />
                                </button>
                                <button type="button" title="Obriši" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-bad hover:bg-bad-bg" @click="removeBlock(selected)">
                                    <Trash2 :size="16" />
                                </button>
                            </div>
                        </div>

                        <div v-if="current.global_id" class="border-b border-line bg-brand-tint px-[18px] py-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex min-w-0 items-center gap-2">
                                    <Link2 :size="15" class="shrink-0 text-brand" />
                                    <p class="min-w-0 truncate text-xs font-semibold text-brand">
                                        Globalni blok „{{ current.globalNaziv }}" - izmjena mijenja sve njegove instance.
                                    </p>
                                </div>
                                <button type="button" class="inline-flex shrink-0 items-center gap-1 text-xs font-semibold text-ink-2 hover:text-ink" @click="odveziGlobalni(selected)">
                                    <Link2Off :size="14" /> Odveži
                                </button>
                            </div>
                            <p v-if="upotrebaZa(current.global_id).length" class="mt-1 pl-[23px] text-[11px] text-ink-2">
                                Postavljen na: <span class="font-semibold">{{ upotrebaTekst(current.global_id) }}</span>
                            </p>
                        </div>

                        <div class="flex items-center gap-2 bg-info-bg px-[18px] py-2.5">
                            <Languages :size="15" class="shrink-0 text-info" />
                            <p class="text-xs font-medium text-info">Tekstualna polja uređuješ za jezik: {{ langName }}. Promijeni jezik gore za prevod.</p>
                        </div>

                        <div class="space-y-4 p-[18px]">
                            <BlockField
                                v-for="field in currentFields"
                                :key="field.name"
                                :field="field"
                                :model-value="current.data[field.name]"
                                :lang="activeLang"
                                :ciljevi="ciljevi"
                                :paleta="paleta"
                                @update:model-value="setField(field.name, $event)"
                            />

                            <div class="border-t border-line pt-4">
                                <p class="mb-3 text-[11px] font-bold uppercase tracking-wide text-ink-3">Izgled sekcije</p>
                                <div class="space-y-4">
                                    <BlockField
                                        v-for="sf in SETTINGS_FIELDS"
                                        :key="sf.name"
                                        :field="sf"
                                        :model-value="current.data.settings?.[sf.name]"
                                        :lang="activeLang"
                                        @update:model-value="setSetting(sf.name, $event)"
                                    />
                                </div>
                            </div>
                        </div>
                    </template>

                    <div v-else class="py-16 text-center">
                        <Layers :size="26" class="mx-auto text-ink-3" />
                        <p class="mt-2 text-[13px] font-semibold text-ink">Odaberite blok</p>
                        <p class="mt-0.5 text-xs text-ink-3">Kliknite blok lijevo ili dodajte novi.</p>
                    </div>
                </template>

                <template v-else>
                    <div class="flex items-center gap-2 bg-info-bg px-[18px] py-2.5">
                        <Languages :size="15" class="shrink-0 text-info" />
                        <p class="text-xs font-medium text-info">Naslov i SEO uređuješ za jezik: {{ langName }}. Promijeni jezik gore za prevod.</p>
                    </div>

                    <div class="space-y-4 p-5">
                        <FormField :model-value="trGet(postavke.title)" label="Naslov stranice" required :error="postavkeErr[`title.${activeLang}`]" @update:model-value="trSet('title', $event)" />

                        <FormField
                            :model-value="postavke.slug[activeLang] || ''"
                            :label="`URL adresa (slug) - ${langName}`"
                            :disabled="stranica.slugLocked"
                            :placeholder="slugPrijedlog"
                            :hint="stranica.slugLocked ? 'Sistemska stranica - URL je fiksan (vezan za rute) i ne mijenja se.' : 'Slug je po jeziku. Prazno = generiše se iz naslova tog jezika.'"
                            :error="postavkeErr[`slug.${activeLang}`]"
                            @update:model-value="postavke.slug = { ...postavke.slug, [activeLang]: $event }"
                        />

                        <div>
                            <p class="mb-1.5 text-sm font-medium text-ink">Status</p>
                            <div class="inline-flex rounded-md bg-surface-alt p-0.5">
                                <button type="button" :class="postavke.published ? 'bg-surface text-ink shadow-[var(--shadow-sm)]' : 'text-ink-3'" class="rounded px-3.5 py-1.5 text-[13px] font-semibold" @click="postavke.published = true">Objavljeno</button>
                                <button type="button" :class="!postavke.published ? 'bg-surface text-ink shadow-[var(--shadow-sm)]' : 'text-ink-3'" class="rounded px-3.5 py-1.5 text-[13px] font-semibold" @click="postavke.published = false">Nacrt</button>
                            </div>
                        </div>

                        <div class="border-t border-line pt-4">
                            <p class="text-sm font-bold text-ink">Šta stranica prikazuje</p>
                            <p class="mb-3 text-xs text-ink-3">Stranica može biti obična ili lista sadržaja. Slug slobodno mijenjaš - veze se ne lome.</p>
                            <div class="space-y-4">
                                <SelectField
                                    :model-value="postavke.resource_type"
                                    label="Tip sadržaja"
                                    :options="tipoviOpcije"
                                    @update:model-value="postavke.resource_type = $event; postavke.category_id = ''"
                                />
                                <SelectField
                                    v-if="postavke.resource_type"
                                    :model-value="postavke.category_id"
                                    label="Kategorija"
                                    :options="kategorijeOpcije"
                                    hint="Prazno znači sve kategorije."
                                    @update:model-value="postavke.category_id = $event"
                                />
                                <SelectField
                                    :model-value="postavke.parent_id"
                                    label="Roditelj"
                                    :options="roditeljiOpcije"
                                    :error="postavkeErr.parent_id"
                                    @update:model-value="postavke.parent_id = $event"
                                />
                            </div>
                        </div>

                        <div class="border-t border-line pt-4">
                            <p class="text-sm font-bold text-ink">SEO</p>
                            <p class="mb-3 text-xs text-ink-3">Kako se stranica prikazuje u pretraživačima i pri dijeljenju.</p>
                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-ink">Meta naslov</label>
                                    <div :class="postavkeErr[`meta_title.${activeLang}`] ? 'border-bad focus-within:ring-bad/20' : 'border-line focus-within:border-brand focus-within:ring-brand/20'" class="flex items-center rounded-[var(--radius-card)] border bg-surface focus-within:ring-2">
                                        <input v-model="metaTitleFront" type="text" :placeholder="trGet(postavke.title) || 'Naslov stranice'" class="h-10 min-w-0 flex-1 bg-transparent px-3 text-sm text-ink placeholder:text-ink-3 focus:outline-none" />
                                        <span v-if="titleSuffix" class="shrink-0 whitespace-nowrap pr-3 text-sm font-medium text-ink-3">{{ titleSuffix }}</span>
                                    </div>
                                    <div class="mt-1.5 flex items-center justify-between text-xs">
                                        <span :class="counterClass(titleLen, SEO_TITLE_MAX, 30)">{{ titleLen }} / {{ SEO_TITLE_MAX }} znakova (sa nazivom sajta)</span>
                                        <span class="text-ink-3">Standard: 50-60</span>
                                    </div>
                                    <p v-if="postavkeErr[`meta_title.${activeLang}`]" class="mt-1 text-xs text-bad">{{ postavkeErr[`meta_title.${activeLang}`] }}</p>
                                </div>

                                <div>
                                    <TextareaField :model-value="trGet(postavke.meta_description)" label="Meta opis" :rows="3" :error="postavkeErr[`meta_description.${activeLang}`]" @update:model-value="trSet('meta_description', $event)" />
                                    <div class="mt-1.5 flex items-center justify-between text-xs">
                                        <span :class="counterClass(descLen, SEO_DESC_MAX, 120)">{{ descLen }} / {{ SEO_DESC_MAX }} znakova</span>
                                        <span class="text-ink-3">Standard: 120-160</span>
                                    </div>
                                </div>

                                <div>
                                    <BlockImageField
                                        v-model="postavke.og_image"
                                        label="Slika za dijeljenje"
                                        hint="Prikazuje se pri dijeljenju na društvenim mrežama. Preporučeno 1200×630."
                                    />
                                    <div v-if="!postavke.og_image && coverFallback" class="mt-2 flex items-center gap-2.5 rounded-md border border-line bg-surface-alt p-2.5">
                                        <img :src="coverFallback" alt="" class="h-11 w-16 shrink-0 rounded object-cover" />
                                        <p class="text-xs text-ink-2">Prazno - koristi se naslovna (hero) slika stranice.</p>
                                    </div>
                                    <p v-else-if="!postavke.og_image" class="mt-2 text-xs text-ink-3">Ako je prazno i stranica nema hero sliku, dijeljenje neće imati sliku.</p>
                                </div>

                                <div class="rounded-md border border-line bg-surface-alt p-3.5">
                                    <p class="text-[10px] font-bold uppercase tracking-wide text-ink-3">Pregled u Google-u</p>
                                    <p class="mt-1 text-xs text-ok">{{ googlePreview.url }}</p>
                                    <p class="text-[15px] font-semibold text-info">{{ googlePreview.title }}</p>
                                    <p class="text-xs text-ink-2">{{ googlePreview.desc }}</p>
                                </div>

                                <div class="rounded-md border border-line p-3.5">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-bold text-ink">SEO ocjena</p>
                                            <p :class="`text-${seoGrade.color}`" class="text-xs font-semibold">{{ seoGrade.label }} ({{ activeLang.toUpperCase() }})</p>
                                        </div>
                                        <div class="text-right">
                                            <span :class="`text-${seoGrade.color}`" class="text-[22px] font-bold">{{ seoScore }}</span>
                                            <span class="text-sm text-ink-3">/100</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-surface-alt">
                                        <div :class="seoGrade.bar" class="h-full rounded-full transition-all" :style="{ width: `${seoScore}%` }"></div>
                                    </div>
                                    <ul class="mt-3 space-y-1.5">
                                        <li v-for="(c, i) in seoChecks" :key="i" class="flex items-center gap-2 text-xs">
                                            <span :class="c.status === 'ok' ? 'bg-ok' : c.status === 'warn' ? 'bg-warn' : 'bg-bad'" class="inline-block h-1.5 w-1.5 shrink-0 rounded-full"></span>
                                            <span :class="c.status === 'bad' ? 'text-ink-2' : 'text-ink-2'">{{ c.label }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end border-t border-line pt-4">
                            <Btn variant="primary" :icon="Save" :disabled="savingPostavke || !postavkeDirty" @click="savePostavke">Sačuvaj postavke</Btn>
                        </div>
                    </div>
                </template>
            </Card>
        </div>
    </div>

    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-150 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showPicker" class="fixed inset-0 z-[60] flex items-start justify-center overflow-y-auto p-4 sm:p-8">
                <div class="absolute inset-0 bg-[#0f172a]/40" @click="showPicker = false"></div>
                <div class="relative my-auto w-full max-w-[720px] rounded-[var(--radius-card)] border border-line bg-surface shadow-[var(--shadow-pop)]">
                    <div class="flex items-center justify-between border-b border-line px-5 py-4">
                        <div>
                            <h3 class="text-[16px] font-bold text-ink">Dodaj blok</h3>
                            <p class="text-xs text-ink-3">Izaberi tip sekcije za dodavanje na stranicu.</p>
                        </div>
                        <button type="button" class="text-ink-3 hover:text-ink" @click="showPicker = false; pickerQuery = ''"><X :size="18" /></button>
                    </div>
                    <div class="border-b border-line p-4">
                        <div class="flex items-center gap-2 rounded-md bg-surface-alt px-3">
                            <Search :size="16" class="text-ink-3" />
                            <input v-model="pickerQuery" type="text" placeholder="Pretraži blokove…" class="h-9 w-full bg-transparent text-[13px] text-ink placeholder:text-ink-3 focus:outline-none" />
                        </div>
                    </div>
                    <div class="max-h-[60vh] overflow-y-auto p-4">
                        <template v-if="filteredGlobalni.length">
                            <p class="mb-2 flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wide text-ink-3">
                                <Link2 :size="13" /> Globalni blokovi
                            </p>
                            <div class="mb-4 grid grid-cols-2 gap-2.5 sm:grid-cols-3 lg:grid-cols-4">
                                <div
                                    v-for="g in filteredGlobalni"
                                    :key="g.id"
                                    class="group relative flex flex-col items-start gap-2 rounded-lg border border-brand/40 bg-brand-tint/40 p-3.5 text-left hover:border-brand hover:bg-brand-tint"
                                >
                                    <button
                                        type="button"
                                        title="Obriši globalni blok"
                                        class="absolute right-1.5 top-1.5 inline-flex h-6 w-6 items-center justify-center rounded-md text-ink-3 opacity-0 transition-opacity hover:bg-bad-bg hover:text-bad group-hover:opacity-100"
                                        @click.stop="obrisiGlobalni(g)"
                                    >
                                        <Trash2 :size="14" />
                                    </button>
                                    <button type="button" class="flex w-full flex-col items-start gap-2 text-left" @click="dodajGlobalni(g)">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-surface text-brand">
                                            <component :is="icon(g.type)" :size="17" />
                                        </span>
                                        <span class="w-full truncate pr-6 text-[13px] font-semibold text-ink">{{ g.name }}</span>
                                        <span class="text-[11px] leading-tight text-ink-3">{{ label(g.type) }} · {{ (globalUpotreba[g.id] || []).length }} {{ (globalUpotreba[g.id] || []).length === 1 ? 'stranica' : 'stranica' }}</span>
                                    </button>
                                </div>
                            </div>
                            <p class="mb-2 text-[11px] font-bold uppercase tracking-wide text-ink-3">Novi blok</p>
                        </template>
                        <div class="grid grid-cols-2 gap-2.5 sm:grid-cols-3 lg:grid-cols-4">
                            <button
                                v-for="item in filteredKatalog"
                                :key="item.type"
                                type="button"
                                class="flex flex-col items-start gap-2 rounded-lg border border-line bg-surface p-3.5 text-left hover:border-brand hover:bg-brand-tint"
                                @click="addBlock(item.type)"
                            >
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-surface-alt text-ink-2">
                                    <component :is="icon(item.type)" :size="17" />
                                </span>
                                <span class="text-[13px] font-semibold text-ink">{{ item.label }}</span>
                                <span class="text-[11px] leading-tight text-ink-3">{{ item.opis }}</span>
                            </button>
                            <div v-if="!filteredKatalog.length && !filteredGlobalni.length" class="col-span-full py-10 text-center text-[13px] text-ink-3">Nema rezultata za „{{ pickerQuery }}".</div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>

    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-150 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="previewOpen" class="fixed inset-0 z-[70] flex flex-col bg-[#0f172a]/80">
                <div class="flex items-center justify-between gap-3 bg-surface px-4 py-2.5 shadow-[var(--shadow-sm)]">
                    <div class="flex min-w-0 items-center gap-2.5">
                        <Eye :size="16" class="shrink-0 text-brand" />
                        <p class="truncate text-[14px] font-bold text-ink">Pregled: {{ naslov }}</p>
                        <span class="shrink-0 rounded bg-surface-alt px-1.5 py-0.5 text-[11px] font-bold uppercase text-ink-2">{{ activeLang }}</span>
                        <Loader2 v-if="previewPushing" :size="15" class="shrink-0 animate-spin text-ink-3" />
                    </div>
                    <div class="flex shrink-0 items-center gap-2">
                        <div class="flex items-center gap-0.5 rounded-md bg-surface-alt p-0.5">
                            <button type="button" title="Desktop" :class="previewDevice === 'desktop' ? 'bg-surface text-ink shadow-[var(--shadow-sm)]' : 'text-ink-3 hover:text-ink'" class="inline-flex h-7 w-8 items-center justify-center rounded" @click="previewDevice = 'desktop'">
                                <Monitor :size="15" />
                            </button>
                            <button type="button" title="Mobilni" :class="previewDevice === 'mobile' ? 'bg-surface text-ink shadow-[var(--shadow-sm)]' : 'text-ink-3 hover:text-ink'" class="inline-flex h-7 w-8 items-center justify-center rounded" @click="previewDevice = 'mobile'">
                                <Smartphone :size="15" />
                            </button>
                        </div>
                        <button type="button" title="Osvježi" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-line bg-surface text-ink-2 hover:bg-surface-alt hover:text-ink" @click="pushDraft">
                            <RefreshCw :size="15" />
                        </button>
                        <a :href="previewPath" target="_blank" title="Otvori u novoj kartici" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-line bg-surface text-ink-2 hover:bg-surface-alt hover:text-ink">
                            <ExternalLink :size="15" />
                        </a>
                        <button type="button" class="inline-flex h-8 items-center gap-1.5 rounded-md bg-ink px-3 text-[13px] font-semibold text-white hover:opacity-90" @click="previewOpen = false">
                            <X :size="15" /> Zatvori
                        </button>
                    </div>
                </div>

                <div class="flex flex-1 justify-center overflow-auto p-4">
                    <div :class="previewDevice === 'mobile' ? 'w-[390px]' : 'w-full'" class="h-full overflow-hidden rounded-lg bg-white shadow-[var(--shadow-pop)]">
                        <iframe :key="previewUrl" :src="previewUrl" class="h-full w-full border-0" title="Pregled stranice"></iframe>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>

    <Teleport to="body">
        <div v-if="globalNazivModal" class="fixed inset-0 z-[70] flex items-start justify-center overflow-y-auto p-4 sm:p-8">
            <div class="absolute inset-0 bg-[#0f172a]/40" @click="globalNazivModal = false"></div>
            <div class="relative my-auto w-full max-w-[440px] rounded-[var(--radius-card)] border border-line bg-surface shadow-[var(--shadow-pop)]">
                <div class="flex items-center justify-between border-b border-line px-5 py-4">
                    <h3 class="text-[15px] font-bold text-ink">Postavi kao globalni blok</h3>
                    <button type="button" class="text-ink-3 hover:text-ink" @click="globalNazivModal = false"><X :size="18" /></button>
                </div>
                <form @submit.prevent="potvrdiGlobalni">
                    <div class="space-y-3 p-5">
                        <p class="text-[13px] text-ink-2">Blok postaje globalni - možeš ga dodati na druge stranice, a izmjena na jednom mjestu mijenja ga svuda.</p>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-ink">Naziv globalnog bloka</label>
                            <input
                                v-model="globalNaziv"
                                type="text"
                                placeholder="npr. Kontakt CTA, Footer pozivnica…"
                                class="h-10 w-full rounded-md border border-line bg-surface px-3 text-sm text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                            />
                        </div>
                    </div>
                    <div class="flex justify-end gap-2.5 border-t border-line bg-surface-alt px-5 py-4">
                        <Btn variant="secondary" @click="globalNazivModal = false">Odustani</Btn>
                        <Btn variant="primary" type="submit" :icon="Link2" :disabled="!globalNaziv.trim()">Postavi globalno</Btn>
                    </div>
                </form>
            </div>
        </div>
    </Teleport>
</template>
