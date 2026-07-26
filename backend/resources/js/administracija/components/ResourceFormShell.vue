<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { Save, Eye, Globe, Languages, Images, X, Plus, Loader2, Check } from 'lucide-vue-next';
import Card from './Card.vue';
import CoverUpload from './CoverUpload.vue';
import StatusBadge from './StatusBadge.vue';
import PublishBox from './PublishBox.vue';
import ToggleField from './ToggleField.vue';
import GalleryEditor from './GalleryEditor.vue';
import ModeracijaAlert from './ModeracijaAlert.vue';
import { useConfirm } from '../composables/useConfirm';

const props = defineProps({
    item: { type: Object, default: null },
    form: { type: Object, required: true },
    kategorije: { type: Array, default: () => [] },
    statusi: { type: Array, default: () => [] },
    korisnici: { type: Array, default: () => [] },
    pending: { type: Object, default: null },
    subjekt: { type: String, default: 'vlasnik' },
    naslov: { type: String, required: true },
    baza: { type: String, required: true },
    naslovPlaceholder: { type: String, default: 'Naslov' },
    segmenti: { type: Object, default: () => ({}) },
    hasMedia: { type: Boolean, default: true },
    hasCategory: { type: Boolean, default: true },
    feature: { type: Object, default: null },
});

const { confirm } = useConfirm();
const page = usePage();
const form = props.form;

const locales = computed(() => {
    const list = page.props?.locales;
    return Array.isArray(list) && list.length ? list : [{ code: 'sr', name: 'Srpski' }];
});
const activeLang = ref(locales.value[0]?.code ?? 'sr');
const langName = computed(() => locales.value.find((l) => l.code === activeLang.value)?.name ?? activeLang.value);

const isNew = computed(() => !props.item?.id);

const trGet = (map) => map?.[activeLang.value] ?? '';
const trSet = (key, val) => { form[key] = { ...(form[key] || {}), [activeLang.value]: val }; };

const naslovDisplay = computed(() => trGet(form.naslov) || '(bez naslova)');

const slugify = (val) => String(val ?? '')
    .toLowerCase()
    .normalize('NFD').replace(/[̀-ͯ]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)/g, '');
const defaultLang = computed(() => locales.value[0]?.code ?? 'sr');
const langPrefix = computed(() => (activeLang.value === defaultLang.value ? '' : `/${activeLang.value}`));
const segment = computed(() => props.segmenti?.[activeLang.value] || props.segmenti?.sr || props.baza);
const slugForLang = computed(() => form.slug?.[activeLang.value] ?? '');
const setSlug = (val) => { form.slug = { ...(form.slug || {}), [activeLang.value]: val }; };
const slugPreview = computed(() => slugify(trGet(form.naslov)));
const effSlug = computed(() => slugForLang.value || slugPreview.value || 'novi-unos');
const permalink = computed(() => `${langPrefix.value}/${segment.value}/${effSlug.value}`);
const editSlug = ref(false);

const tagInput = ref('');
const addTag = () => {
    const val = tagInput.value.trim();
    if (val && !form.tags.includes(val)) form.tags.push(val);
    tagInput.value = '';
};
const removeTag = (t) => { form.tags = form.tags.filter((x) => x !== t); };

const submit = () => {
    if (isNew.value) {
        form.post(`/administracija/${props.baza}`, { preserveScroll: true });
    } else {
        form.put(`/administracija/${props.baza}/${props.item.id}`, { preserveScroll: true });
    }
};

const obrisi = async () => {
    if (isNew.value) {
        router.visit(`/administracija/${props.baza}`);
        return;
    }
    const ok = await confirm({
        danger: true,
        title: `Obrisati „${naslovDisplay.value}"?`,
        message: 'Unos se trajno briše.',
        confirmLabel: 'Obriši',
    });
    if (!ok) return;
    router.delete(`/administracija/${props.baza}/${props.item.id}`);
};

const galerijaInput = ref(null);
const uploadingGalerija = ref(false);
const pickGalerija = () => galerijaInput.value?.click();
const onGalerija = (e) => {
    const files = Array.from(e.target.files ?? []);
    e.target.value = '';
    if (!files.length || !props.item?.id) return;
    uploadingGalerija.value = true;
    router.post(`/administracija/${props.baza}/${props.item.id}/galerija`, { galerija: files }, {
        forceFormData: true,
        preserveScroll: true,
        preserveState: true,
        onFinish: () => { uploadingGalerija.value = false; },
    });
};
const obrisiFoto = (m) => {
    router.delete(`/administracija/${props.baza}/galerija/${m.id}`, { preserveScroll: true, preserveState: true });
};

const GALERIJA_MAX = 18;
const fotografije = ref([...(props.item?.galerija ?? [])]);
watch(() => props.item?.galerija, (g) => { fotografije.value = [...(g ?? [])]; });
const brojFoto = computed(() => fotografije.value.length);
const editFoto = ref(null);

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
    router.post(`/administracija/${props.baza}/${props.item.id}/galerija/redoslijed`, { redoslijed: arr.map((m) => m.id) }, { preserveScroll: true, preserveState: true });
};
</script>

<template>
    <Head :title="isNew ? `Novi: ${naslov}` : `Uredi: ${naslovDisplay}`" />

    <div class="space-y-4">
        <header class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex min-w-0 items-center gap-2.5">
                <h1 class="truncate text-[22px] font-bold text-ink">{{ isNew ? `Novi: ${naslov}` : `Uredi: ${naslov}` }}</h1>
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
                    v-if="!isNew && item?.url"
                    :href="item.url"
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
                        :placeholder="naslovPlaceholder"
                        class="w-full bg-transparent text-[22px] font-bold text-ink placeholder:text-ink-3 focus:outline-none"
                        @input="trSet('naslov', $event.target.value)"
                    />
                    <p v-if="form.errors['naslov.sr']" class="mt-1 text-xs text-bad">{{ form.errors['naslov.sr'] }}</p>
                    <div class="mt-2 flex flex-wrap items-center gap-2 text-[13px]">
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
                </Card>

                <ModeracijaAlert :base="baza" :id="item?.id" :status="form.status" :pending="pending" :subjekt="subjekt" />

                <slot name="fields" :active-lang="activeLang" :tr-get="trGet" :tr-set="trSet" :is-new="isNew" />

                <Card v-if="hasMedia" title="Galerija">
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
                        <input ref="galerijaInput" type="file" accept="image/*" multiple class="hidden" @change="onGalerija" />
                    </template>
                    <p v-else class="flex items-center gap-2 text-sm text-ink-3">
                        <Images :size="16" /> Sačuvajte unos da biste dodali fotografije.
                    </p>
                </Card>
            </div>

            <div class="space-y-[18px]">
                <PublishBox
                    :status="form.status"
                    :statusi="statusi"
                    :published-at="item?.publishedAt"
                    :rejection-reason="item?.rejection_reason"
                    :saving="form.processing"
                    :show-trash="!isNew"
                    @update:status="form.status = $event"
                    @save="submit"
                    @trash="obrisi"
                />

                <Card title="Vlasnik">
                    <p class="mb-2 text-[12px] text-ink-2">Korisnik za kojeg je vezan ovaj sadržaj (opciono).</p>
                    <select
                        v-model="form.user_id"
                        class="w-full rounded-lg border border-line bg-surface px-3 py-2 text-[13px] text-ink focus:border-brand focus:outline-none"
                    >
                        <option :value="null">- Nije vezano -</option>
                        <option v-for="k in korisnici" :key="k.value" :value="k.value">{{ k.label }}</option>
                    </select>
                </Card>

                <Card v-if="hasCategory" title="Kategorija">
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

                <Card v-if="hasMedia" title="Naslovna slika">
                    <CoverUpload
                        v-if="!isNew"
                        :src="item.naslovna"
                        :upload-url="`/administracija/${baza}/${item.id}/naslovna`"
                        :delete-url="`/administracija/${baza}/${item.id}/naslovna`"
                        field="image"
                        :aspect="16 / 9"
                        :output-width="1280"
                        hint="PNG, JPG · preporučeno 1280×720"
                    />
                    <p v-else class="flex items-center gap-2 text-sm text-ink-3">
                        <Images :size="16" /> Dostupno nakon prvog čuvanja.
                    </p>
                </Card>

                <Card v-if="feature" title="Istaknuto">
                    <ToggleField
                        :model-value="!!form[feature.key]"
                        :label="feature.label"
                        :hint="feature.hint"
                        @update:model-value="form[feature.key] = $event"
                    />
                </Card>
            </div>
        </div>

        <GalleryEditor
            v-if="editFoto"
            :src="editFoto.src"
            :save-url="`/administracija/${baza}/galerija/${editFoto.id}/zamijeni`"
            @close="editFoto = null"
            @saved="editFoto = null"
        />
    </div>
</template>
