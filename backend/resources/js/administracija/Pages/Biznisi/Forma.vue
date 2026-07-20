<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import {
    ArrowLeft, Save, Eye, Globe, Languages, Star, Images, Upload, Trash2, Plus, X, MapPin, Loader2, Check,
} from 'lucide-vue-next';
import Card from '../../components/Card.vue';
import FormField from '../../components/FormField.vue';
import TextareaField from '../../components/TextareaField.vue';
import SelectField from '../../components/SelectField.vue';
import ToggleField from '../../components/ToggleField.vue';
import RichTextField from '../../components/RichTextField.vue';
import CoverUpload from '../../components/CoverUpload.vue';
import StatusBadge from '../../components/StatusBadge.vue';
import PublishBox from '../../components/PublishBox.vue';
import LocationMap from '../../components/LocationMap.vue';
import GalleryEditor from '../../components/GalleryEditor.vue';
import { useConfirm } from '../../composables/useConfirm';

const props = defineProps({
    biznis: { type: Object, default: null },
    kategorije: { type: Array, default: () => [] },
    statusi: { type: Array, default: () => [] },
    segmenti: { type: Object, default: () => ({ sr: 'biznis' }) },
});

const { confirm } = useConfirm();
const page = usePage();

const locales = computed(() => {
    const list = page.props?.locales;
    return Array.isArray(list) && list.length ? list : [{ code: 'sr', name: 'Srpski' }];
});
const activeLang = ref(locales.value[0]?.code ?? 'sr');
const langName = computed(() => locales.value.find((l) => l.code === activeLang.value)?.name ?? activeLang.value);

const isNew = computed(() => !props.biznis?.id);

const DANI = ['Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota', 'Nedjelja'];

function pocetnoRadnoVrijeme() {
    const postojece = Array.isArray(props.biznis?.radno_vrijeme) ? props.biznis.radno_vrijeme : [];
    return DANI.map((_, i) => ({
        zatvoreno: postojece[i]?.zatvoreno ?? (i >= 6),
        od: postojece[i]?.od ?? (i < 6 ? '08:00' : ''),
        do: postojece[i]?.do ?? (i < 6 ? '16:00' : ''),
    }));
}

const form = useForm({
    naslov: { ...(props.biznis?.naslov ?? {}) },
    slug: { ...(props.biznis?.slug ?? {}) },
    opis: { ...(props.biznis?.opis ?? {}) },
    opis_dug: { ...(props.biznis?.opis_dug ?? {}) },
    lokacija: { ...(props.biznis?.lokacija ?? {}) },
    radno_vrijeme: pocetnoRadnoVrijeme(),
    category_id: props.biznis?.category_id ?? '',
    kontakt: {
        telefon: props.biznis?.kontakt?.telefon ?? '',
        email: props.biznis?.kontakt?.email ?? '',
        adresa: props.biznis?.kontakt?.adresa ?? '',
        web: props.biznis?.kontakt?.web ?? '',
        viber: props.biznis?.kontakt?.viber ?? '',
        whatsapp: props.biznis?.kontakt?.whatsapp ?? '',
    },
    drustvene: {
        facebook: props.biznis?.drustvene?.facebook ?? '',
        instagram: props.biznis?.drustvene?.instagram ?? '',
        youtube: props.biznis?.drustvene?.youtube ?? '',
        tiktok: props.biznis?.drustvene?.tiktok ?? '',
    },
    usluge: { ...(props.biznis?.usluge ?? {}) },
    cijena_raspon: props.biznis?.cijena_raspon ?? '',
    godina_osnivanja: props.biznis?.godina_osnivanja ?? '',
    nacin_placanja: {
        gotovina: props.biznis?.nacin_placanja?.gotovina ?? false,
        kartica: props.biznis?.nacin_placanja?.kartica ?? false,
        virman: props.biznis?.nacin_placanja?.virman ?? false,
    },
    lat: props.biznis?.lat ?? '',
    lng: props.biznis?.lng ?? '',
    preporuceno: props.biznis?.preporuceno ?? false,
    status: props.biznis?.status ?? 'nacrt',
    tags: [...(props.biznis?.tags ?? [])],
});

const osigurajUsluge = (lang) => {
    if (!Array.isArray(form.usluge[lang])) form.usluge = { ...form.usluge, [lang]: [] };
};
watch(activeLang, (l) => osigurajUsluge(l), { immediate: true });
const dodajUslugu = () => { osigurajUsluge(activeLang.value); form.usluge[activeLang.value].push(''); };
const ukloniUslugu = (i) => { form.usluge[activeLang.value].splice(i, 1); };

const trGet = (map) => map?.[activeLang.value] ?? '';
const trSet = (key, val) => { form[key] = { ...(form[key] || {}), [activeLang.value]: val }; };

const slugify = (val) => String(val ?? '')
    .toLowerCase()
    .normalize('NFD').replace(/[̀-ͯ]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)/g, '');

const slugForLang = computed(() => form.slug?.[activeLang.value] ?? '');
const setSlug = (val) => { form.slug = { ...(form.slug || {}), [activeLang.value]: val }; };
const slugPreview = computed(() => slugify(trGet(form.naslov)));
const effSlug = computed(() => slugForLang.value || slugPreview.value || 'novi-biznis');
const defaultLang = computed(() => locales.value[0]?.code ?? 'sr');
const langPrefix = computed(() => (activeLang.value === defaultLang.value ? '' : `/${activeLang.value}`));
const segment = computed(() => props.segmenti?.[activeLang.value] || props.segmenti?.sr || 'biznis');
const permalink = computed(() => `${langPrefix.value}/${segment.value}/${effSlug.value}`);
const editSlug = ref(false);

const naslovDisplay = computed(() => trGet(form.naslov) || '(bez naslova)');

const tagInput = ref('');
const addTag = () => {
    const val = tagInput.value.trim();
    if (val && !form.tags.includes(val)) form.tags.push(val);
    tagInput.value = '';
};
const removeTag = (t) => { form.tags = form.tags.filter((x) => x !== t); };

const submit = () => {
    if (isNew.value) {
        form.post('/administracija/biznisi', { preserveScroll: true });
    } else {
        form.put(`/administracija/biznisi/${props.biznis.id}`, { preserveScroll: true });
    }
};

const obrisi = async () => {
    if (isNew.value) {
        router.visit('/administracija/biznisi');
        return;
    }
    const ok = await confirm({
        danger: true,
        title: `Obrisati „${naslovDisplay.value}"?`,
        message: 'Biznis i sve njegove fotografije se trajno brišu.',
        confirmLabel: 'Obriši biznis',
    });
    if (!ok) return;
    router.delete(`/administracija/biznisi/${props.biznis.id}`);
};

const galerijaInput = ref(null);
const uploadingGalerija = ref(false);
const pickGalerija = () => galerijaInput.value?.click();
const onGalerija = (e) => {
    const files = Array.from(e.target.files ?? []);
    e.target.value = '';
    if (!files.length || !props.biznis?.id) return;
    uploadingGalerija.value = true;
    router.post(`/administracija/biznisi/${props.biznis.id}/galerija`, { galerija: files }, {
        forceFormData: true,
        preserveScroll: true,
        preserveState: true,
        onFinish: () => { uploadingGalerija.value = false; },
    });
};
const obrisiFoto = (m) => {
    router.delete(`/administracija/biznisi/galerija/${m.id}`, { preserveScroll: true, preserveState: true });
};

const GALERIJA_MAX = 18;
const fotografije = ref([...(props.biznis?.galerija ?? [])]);
watch(() => props.biznis?.galerija, (g) => { fotografije.value = [...(g ?? [])]; });
const brojFoto = computed(() => fotografije.value.length);
const editFoto = ref(null);
const onFotoSaved = () => { editFoto.value = null; };

const dragIdx = ref(null);
const overIdx = ref(null);
const onFotoDragStart = (e, i) => {
    dragIdx.value = i;
    if (e.dataTransfer) {
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', String(i));
    }
};
const onFotoDrop = (target) => {
    const from = dragIdx.value;
    dragIdx.value = null;
    overIdx.value = null;
    if (from === null || from === target) return;
    const arr = [...fotografije.value];
    const [moved] = arr.splice(from, 1);
    arr.splice(target, 0, moved);
    fotografije.value = arr;
    router.post(`/administracija/biznisi/${props.biznis.id}/galerija/redoslijed`, { redoslijed: arr.map((m) => m.id) }, { preserveScroll: true, preserveState: true });
};
</script>

<template>
    <Head :title="isNew ? 'Novi biznis' : `Uredi: ${naslovDisplay}`" />

    <div class="space-y-4">
        <header class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex min-w-0 items-center gap-2.5">
                <h1 class="truncate text-[22px] font-bold text-ink">{{ isNew ? 'Novi biznis' : 'Uredi biznis' }}</h1>
                <StatusBadge :status="form.status" />
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
                <a
                    v-if="!isNew"
                    :href="biznis.url"
                    target="_blank"
                    title="Pregled"
                    class="inline-flex h-9 items-center gap-2 rounded-md border border-line bg-surface px-4 text-sm font-semibold text-ink-2 hover:bg-surface-alt"
                >
                    <Eye :size="16" /> Pregled
                </a>
                <button type="button" :disabled="form.processing" class="inline-flex h-9 items-center gap-2 rounded-[var(--radius-card)] bg-brand px-4 text-sm font-semibold text-white transition-colors hover:bg-brand-dark disabled:opacity-50" @click="submit">
                    <Save :size="16" /> Sačuvaj
                </button>
            </div>
        </header>

        <div class="flex items-center gap-2 rounded-md bg-info-bg px-[18px] py-2.5">
            <Languages :size="15" class="shrink-0 text-info" />
            <p class="text-xs font-medium text-info">Tekstualna polja uređuješ za jezik: {{ langName }}. Promijeni jezik gore za prevod.</p>
        </div>

        <div class="grid grid-cols-1 gap-[18px] lg:grid-cols-[minmax(0,1fr)_340px]">
            <div class="space-y-[18px]">
                <Card>
                    <input
                        :value="trGet(form.naslov)"
                        type="text"
                        placeholder="Naziv biznisa"
                        class="w-full bg-transparent text-[22px] font-bold text-ink placeholder:text-ink-3 focus:outline-none"
                        @input="trSet('naslov', $event.target.value)"
                    />
                    <p v-if="form.errors['naslov.sr']" class="mt-1 text-xs text-bad">{{ form.errors['naslov.sr'] }}</p>
                </Card>

                <div class="flex flex-wrap items-center gap-2 px-1 text-[13px]">
                    <span class="text-ink-3">Trajna veza:</span>
                    <template v-if="!editSlug">
                        <a :href="permalink" target="_blank" class="font-semibold text-brand hover:underline">{{ permalink }}</a>
                        <button type="button" class="rounded border border-line bg-surface-alt px-2 py-0.5 text-[11px] font-semibold text-ink-2 hover:bg-surface hover:text-ink" @click="editSlug = true">Uredi</button>
                    </template>
                    <template v-else>
                        <span class="text-ink-3">{{ langPrefix }}/{{ segment }}/</span>
                        <input :value="slugForLang" type="text" :placeholder="slugPreview" class="h-7 w-48 rounded-md border border-line bg-surface px-2 text-[13px] text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20" @input="setSlug($event.target.value)" />
                        <button type="button" class="rounded-md bg-brand px-2.5 py-1 text-[11px] font-semibold text-white hover:bg-brand-dark" @click="editSlug = false">Gotovo</button>
                    </template>
                    <span v-if="form.errors[`slug.${activeLang}`]" class="w-full text-xs text-bad">{{ form.errors[`slug.${activeLang}`] }}</span>
                </div>

                <Card title="Opis">
                    <div class="space-y-4">
                        <TextareaField
                            :model-value="trGet(form.opis)"
                            label="Kratki opis"
                            :rows="3"
                            hint="Sažetak prikazan na kartici i u listi (do 500 znakova)."
                            :error="form.errors[`opis.${activeLang}`]"
                            @update:model-value="trSet('opis', $event)"
                        />
                        <RichTextField
                            :model-value="form.opis_dug"
                            :lang="activeLang"
                            label="Detaljan opis"
                            @update:model-value="form.opis_dug = $event"
                        />
                    </div>
                </Card>

                <Card title="Kontakt">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <FormField v-model="form.kontakt.telefon" label="Telefon" placeholder="+387 65 123 456" hint="Slobodan format - sredi se automatski za poziv." />
                        <FormField v-model="form.kontakt.email" label="Email" type="email" placeholder="kontakt@primjer.ba" />
                        <FormField v-model="form.kontakt.adresa" label="Adresa" placeholder="Ulica i broj" />
                        <FormField v-model="form.kontakt.web" label="Web" placeholder="https://" />
                        <FormField v-model="form.kontakt.viber" label="Viber" placeholder="+387 65 123 456" />
                        <FormField v-model="form.kontakt.whatsapp" label="WhatsApp" placeholder="+387 65 123 456" />
                    </div>
                    <div class="mt-5">
                        <p class="mb-2 text-[13px] font-semibold text-ink">Radno vrijeme</p>
                        <div class="divide-y divide-line rounded-md border border-line">
                            <div
                                v-for="(dan, i) in form.radno_vrijeme"
                                :key="i"
                                class="flex flex-wrap items-center gap-3 px-3 py-2.5"
                            >
                                <span class="w-24 shrink-0 text-[13px] font-medium text-ink">{{ DANI[i] }}</span>
                                <label class="flex shrink-0 cursor-pointer items-center gap-1.5 text-[13px] text-ink-2">
                                    <input type="checkbox" :checked="!dan.zatvoreno" class="h-4 w-4 rounded border-line text-brand focus:ring-brand/30" @change="dan.zatvoreno = !$event.target.checked" />
                                    Otvoreno
                                </label>
                                <template v-if="!dan.zatvoreno">
                                    <div class="flex items-center gap-1.5">
                                        <input v-model="dan.od" type="time" class="h-8 rounded-md border border-line bg-surface px-2 text-[13px] text-ink focus:border-brand focus:outline-none" />
                                        <span class="text-ink-3">-</span>
                                        <input v-model="dan.do" type="time" class="h-8 rounded-md border border-line bg-surface px-2 text-[13px] text-ink focus:border-brand focus:outline-none" />
                                    </div>
                                </template>
                                <span v-else class="text-[13px] font-medium text-ink-3">Zatvoreno</span>
                            </div>
                        </div>
                    </div>
                </Card>

                <Card title="Lokacija na mapi">
                    <div class="mb-4">
                        <FormField
                            :model-value="trGet(form.lokacija)"
                            label="Naziv lokacije"
                            placeholder="npr. Komušina, Teslić"
                            hint="Prikazuje se ispod imena biznisa. Prevodi se po jeziku."
                            @update:model-value="trSet('lokacija', $event)"
                        />
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <FormField v-model="form.lat" label="Geografska širina (lat)" placeholder="44.6000" :error="form.errors.lat" />
                        <FormField v-model="form.lng" label="Geografska dužina (lng)" placeholder="17.8600" :error="form.errors.lng" />
                    </div>
                    <p class="mb-2 mt-3 flex items-center gap-1.5 text-xs text-ink-3">
                        <MapPin :size="13" /> Klikni na mapu ili prevuci marker da postaviš lokaciju.
                    </p>
                    <LocationMap
                        :lat="form.lat"
                        :lng="form.lng"
                        @update:lat="form.lat = $event"
                        @update:lng="form.lng = $event"
                    />
                </Card>

                <Card title="Detalji">
                    <div class="space-y-5">
                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <p class="text-[13px] font-semibold text-ink">Usluge <span class="font-normal text-ink-3">· {{ activeLang.toUpperCase() }}</span></p>
                                <button type="button" class="inline-flex items-center gap-1 text-[12px] font-semibold text-brand hover:text-brand-dark" @click="dodajUslugu">
                                    <Plus :size="14" /> Dodaj
                                </button>
                            </div>
                            <div v-if="(form.usluge[activeLang] || []).length" class="space-y-2">
                                <div v-for="(u, i) in form.usluge[activeLang]" :key="i" class="flex items-center gap-2">
                                    <input v-model="form.usluge[activeLang][i]" type="text" placeholder="npr. Dostava na kućnu adresu" class="h-9 w-full rounded-md border border-line bg-surface px-3 text-[13px] text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20" />
                                    <button type="button" class="shrink-0 text-ink-3 hover:text-bad" @click="ukloniUslugu(i)"><X :size="16" /></button>
                                </div>
                            </div>
                            <p v-else class="text-xs text-ink-3">Nema dodanih usluga za ovaj jezik.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <SelectField
                                :model-value="form.cijena_raspon"
                                label="Raspon cijena"
                                :options="[{ value: '', label: '-' }, { value: '€', label: '€ (povoljno)' }, { value: '€€', label: '€€ (srednje)' }, { value: '€€€', label: '€€€ (skuplje)' }]"
                                @update:model-value="form.cijena_raspon = $event"
                            />
                            <FormField v-model="form.godina_osnivanja" label="Godina osnivanja" type="number" placeholder="npr. 2015" />
                        </div>

                        <div>
                            <p class="mb-2 text-[13px] font-semibold text-ink">Načini plaćanja</p>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex cursor-pointer items-center gap-1.5 text-[13px] text-ink-2">
                                    <input v-model="form.nacin_placanja.gotovina" type="checkbox" class="h-4 w-4 rounded border-line text-brand focus:ring-brand/30" /> Gotovina
                                </label>
                                <label class="flex cursor-pointer items-center gap-1.5 text-[13px] text-ink-2">
                                    <input v-model="form.nacin_placanja.kartica" type="checkbox" class="h-4 w-4 rounded border-line text-brand focus:ring-brand/30" /> Kartica
                                </label>
                                <label class="flex cursor-pointer items-center gap-1.5 text-[13px] text-ink-2">
                                    <input v-model="form.nacin_placanja.virman" type="checkbox" class="h-4 w-4 rounded border-line text-brand focus:ring-brand/30" /> Virman
                                </label>
                            </div>
                        </div>

                        <div>
                            <p class="mb-2 text-[13px] font-semibold text-ink">Društvene mreže</p>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <FormField v-model="form.drustvene.facebook" label="Facebook" placeholder="https://facebook.com/…" />
                                <FormField v-model="form.drustvene.instagram" label="Instagram" placeholder="https://instagram.com/…" />
                                <FormField v-model="form.drustvene.youtube" label="YouTube" placeholder="https://youtube.com/@…" />
                                <FormField v-model="form.drustvene.tiktok" label="TikTok" placeholder="https://tiktok.com/@…" />
                            </div>
                        </div>
                    </div>
                </Card>

                <Card title="Galerija">
                    <template v-if="!isNew">
                        <p class="mb-2.5 text-xs text-ink-3">{{ brojFoto }} / {{ GALERIJA_MAX }} fotografija</p>
                        <div class="flex flex-wrap gap-2.5">
                            <div
                                v-for="(m, i) in fotografije"
                                :key="m.id"
                                draggable="true"
                                :class="overIdx === i && dragIdx !== null ? 'ring-2 ring-brand ring-offset-1' : ''"
                                class="group relative h-[92px] w-[92px] shrink-0 cursor-pointer overflow-hidden rounded-md border border-line"
                                title="Prevuci za redoslijed · klik za uređivanje"
                                @click="editFoto = m"
                                @dragstart="onFotoDragStart($event, i)"
                                @dragend="dragIdx = null; overIdx = null"
                                @dragover.prevent="overIdx = i"
                                @drop="onFotoDrop(i)"
                            >
                                <img :src="m.src" alt="" class="pointer-events-none h-full w-full object-cover" />
                                <div class="pointer-events-none absolute inset-0 bg-ink/0 transition-colors group-hover:bg-ink/15"></div>
                                <button type="button" class="absolute right-1 top-1 inline-flex h-[18px] w-[18px] items-center justify-center rounded-full bg-bad text-white shadow-sm hover:brightness-110" title="Ukloni" @click.stop="obrisiFoto(m)">
                                    <X :size="11" />
                                </button>
                            </div>
                            <button v-if="brojFoto < GALERIJA_MAX" type="button" :disabled="uploadingGalerija" class="flex h-[92px] w-[92px] shrink-0 items-center justify-center rounded-md border border-dashed border-line-strong bg-surface-alt text-ink-3 hover:border-brand hover:text-brand disabled:opacity-50" title="Dodaj fotografije" @click="pickGalerija">
                                <Loader2 v-if="uploadingGalerija" :size="22" class="animate-spin" />
                                <Plus v-else :size="22" />
                            </button>
                        </div>
                        <p v-if="brojFoto >= GALERIJA_MAX" class="mt-2 text-xs text-ink-3">Dostignut je maksimum od {{ GALERIJA_MAX }} fotografija.</p>
                        <input ref="galerijaInput" type="file" accept="image/*" multiple class="hidden" @change="onGalerija" />
                    </template>
                    <p v-else class="flex items-center gap-2 text-sm text-ink-3">
                        <Images :size="16" /> Sačuvajte biznis da biste dodali fotografije.
                    </p>
                </Card>
            </div>

            <div class="space-y-[18px]">
                <PublishBox
                    :status="form.status"
                    :statusi="statusi"
                    :published-at="biznis?.publishedAt"
                    :rejection-reason="biznis?.rejection_reason"
                    :saving="form.processing"
                    :show-trash="!isNew"
                    @update:status="form.status = $event"
                    @save="submit"
                    @trash="obrisi"
                />

                <Card title="Kategorija">
                    <div v-if="kategorije.length" class="space-y-0.5">
                        <button
                            v-for="k in kategorije"
                            :key="k.value"
                            type="button"
                            class="flex w-full items-center gap-2.5 rounded-md px-1 py-[5px] text-left hover:bg-surface-alt"
                            @click="form.category_id = form.category_id === k.value ? '' : k.value"
                        >
                            <span
                                :class="form.category_id === k.value ? 'border-brand bg-brand text-white' : 'border-line-strong bg-surface text-transparent'"
                                class="flex h-[17px] w-[17px] shrink-0 items-center justify-center rounded border"
                            >
                                <Check :size="12" />
                            </span>
                            <span class="text-[13px] text-ink">{{ k.label }}</span>
                        </button>
                    </div>
                    <p v-else class="text-[13px] text-ink-3">Nema definisanih kategorija.</p>
                    <p v-if="form.errors.category_id" class="mt-1.5 text-xs text-bad">{{ form.errors.category_id }}</p>
                </Card>

                <Card title="Oznake">
                    <div class="flex flex-wrap gap-1.5">
                        <span v-for="t in form.tags" :key="t" class="inline-flex items-center gap-1 rounded bg-surface-alt px-2 py-1 text-xs font-semibold text-ink-2">
                            {{ t }}
                            <button type="button" class="text-ink-3 hover:text-bad" @click="removeTag(t)"><X :size="13" /></button>
                        </span>
                    </div>
                    <div class="mt-2 flex items-center gap-2 rounded-md border border-line bg-surface px-3 focus-within:border-brand focus-within:ring-2 focus-within:ring-brand/20">
                        <input
                            v-model="tagInput"
                            type="text"
                            placeholder="Dodaj oznaku i pritisni Enter"
                            class="h-9 w-full bg-transparent text-[13px] text-ink placeholder:text-ink-3 focus:outline-none"
                            @keydown.enter.prevent="addTag"
                            @keydown="$event.key === ',' && ($event.preventDefault(), addTag())"
                        />
                        <button type="button" class="text-ink-3 hover:text-ink" title="Dodaj" @click="addTag"><Plus :size="16" /></button>
                    </div>
                </Card>

                <Card title="Naslovna slika">
                    <CoverUpload
                        v-if="!isNew"
                        :src="biznis.naslovna"
                        :upload-url="`/administracija/biznisi/${biznis.id}/naslovna`"
                        :delete-url="`/administracija/biznisi/${biznis.id}/naslovna`"
                        field="image"
                        :aspect="16 / 9"
                        :output-width="1280"
                        hint="PNG, JPG · preporučeno 1280×720"
                    />
                    <p v-else class="flex items-center gap-2 text-sm text-ink-3">
                        <Images :size="16" /> Dostupno nakon prvog čuvanja.
                    </p>
                </Card>

                <Card title="Istaknuto">
                    <ToggleField
                        v-model="form.preporuceno"
                        label="Preporučeni biznis"
                        hint="Prikazuje se izdvojeno na naslovnoj i u katalogu."
                    />
                </Card>
            </div>
        </div>

        <GalleryEditor
            v-if="editFoto"
            :src="editFoto.src"
            :save-url="`/administracija/biznisi/galerija/${editFoto.id}/zamijeni`"
            @close="editFoto = null"
            @saved="onFotoSaved"
        />
    </div>
</template>
