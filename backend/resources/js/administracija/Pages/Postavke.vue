<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { Check, Plus, GripVertical, Trash2, X, Share2, Handshake } from 'lucide-vue-next';
import Card from '../components/Card.vue';
import Tabs from '../components/Tabs.vue';
import FormField from '../components/FormField.vue';
import TextareaField from '../components/TextareaField.vue';
import ToggleField from '../components/ToggleField.vue';
import TranslatableField from '../components/TranslatableField.vue';
import ImageUpload from '../components/ImageUpload.vue';
import Btn from '../components/Btn.vue';

const props = defineProps({
    postavke: { type: Object, required: true },
    partneri: { type: Array, default: () => [] },
});

const tabs = [
    { key: 'opste', label: 'Opšte' },
    { key: 'kontakt', label: 'Kontakt' },
    { key: 'drustvene', label: 'Društvene mreže' },
    { key: 'footer', label: 'Footer' },
    { key: 'seo', label: 'SEO i pristup' },
];
const tab = ref('opste');

let uid = 0;
const form = useForm({
    brand_naziv: { ...(props.postavke.brand_naziv || {}) },
    brand_logo_tekst: { ...(props.postavke.brand_logo_tekst || {}) },
    kontakt_adresa: props.postavke.kontakt_adresa ?? '',
    kontakt_telefon: props.postavke.kontakt_telefon ?? '',
    kontakt_email: props.postavke.kontakt_email ?? '',
    footer_opis: { ...(props.postavke.footer_opis || {}) },
    copyright: { ...(props.postavke.copyright || {}) },
    partneri_tekst: { ...(props.postavke.partneri_tekst || {}) },
    logo_visina: props.postavke.logo_visina ?? 40,
    seo_opis: { ...(props.postavke.seo_opis || {}) },
    social: (props.postavke.social ?? []).map((s) => ({ _id: ++uid, name: s.name ?? '', label: s.label ?? '', href: s.href ?? '' })),
    google_indeksiranje: !!props.postavke.google_indeksiranje,
    odrzavanje: !!props.postavke.odrzavanje,
    odrzavanje_lozinka: props.postavke.odrzavanje_lozinka ?? '',
    odrzavanje_minuta: props.postavke.odrzavanje_minuta ?? 120,
    odrzavanje_poruka: props.postavke.odrzavanje_poruka ?? '',
});

const addSocial = () => form.social.push({ _id: ++uid, name: '', label: '', href: '' });
const removeSocial = (i) => form.social.splice(i, 1);

const dragIndex = ref(null);
const onDragStart = (i) => { dragIndex.value = i; };
const onDrop = (i) => {
    if (dragIndex.value === null || dragIndex.value === i) return;
    const [moved] = form.social.splice(dragIndex.value, 1);
    form.social.splice(i, 0, moved);
    dragIndex.value = null;
};

const partneri = ref(props.partneri.map((p) => ({ ...p })));
watch(() => props.partneri, (v) => { partneri.value = v.map((p) => ({ ...p })); });

const dodajPartnera = () => router.post('/administracija/postavke/partneri', { naziv: 'Novi partner' }, { preserveScroll: true, preserveState: true });
const ukloniPartnera = (id) => router.delete(`/administracija/postavke/partneri/${id}`, { preserveScroll: true, preserveState: true });
const sacuvajPartnera = (p) => {
    const orig = props.partneri.find((x) => x.id === p.id);
    if (!p.naziv.trim()) return;
    if (orig && orig.naziv === p.naziv && (orig.href || '') === (p.href || '')) return;
    router.put(`/administracija/postavke/partneri/${p.id}`, { naziv: p.naziv, href: p.href || null }, { preserveScroll: true, preserveState: true });
};

const pDrag = ref(null);
const pDragStart = (i) => { pDrag.value = i; };
const pDrop = (i) => {
    if (pDrag.value === null || pDrag.value === i) return;
    const arr = partneri.value;
    const [m] = arr.splice(pDrag.value, 1);
    arr.splice(i, 0, m);
    pDrag.value = null;
    router.post('/administracija/postavke/partneri/redoslijed', { ids: arr.map((p) => p.id) }, { preserveScroll: true, preserveState: true });
};

const submit = () => {
    form
        .transform((d) => ({ ...d, social: d.social.map(({ _id, ...rest }) => rest) }))
        .put('/administracija/postavke', { preserveScroll: true });
};

const err = (key) => form.errors[key];
const trErr = (field) => {
    const out = {};
    for (const [k, v] of Object.entries(form.errors)) {
        if (k.startsWith(`${field}.`)) out[k.slice(field.length + 1)] = v;
    }
    return out;
};
</script>

<template>
    <Head title="Postavke sajta" />

    <div class="space-y-[18px]">
        <header class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-[22px] font-bold text-ink">Postavke sajta</h1>
                <p class="mt-1 text-sm text-ink-2">Brend, kontakt, društvene mreže i footer - globalne postavke platforme.</p>
            </div>
            <Btn variant="primary" :icon="Check" :disabled="form.processing" @click="submit">Sačuvaj promjene</Btn>
        </header>

        <Tabs :tabs="tabs" :model-value="tab" @update:model-value="tab = $event" />

        <Card v-show="tab === 'opste'" title="Brend i logo">
            <div class="space-y-4">
                <ImageUpload
                    :src="postavke.brand_logo"
                    upload-url="/administracija/postavke/logo"
                    delete-url="/administracija/postavke/logo"
                    label="Logo"
                    hint="PNG s providnošću. Čuva prirodni omjer loga (bez praznog prostora sa strane) - zumiraj za tijesno krojenje. Koristi se u zaglavlju/footeru ako je postavljen, inače logo tekst."
                    aspect="auto"
                    shape="rect"
                    :output-width="600"
                    output-type="image/png"
                    class="border-b border-line pb-4"
                />
                <FormField
                    v-model.number="form.logo_visina"
                    type="number"
                    label="Visina loga na sajtu (px)"
                    hint="Koliko visoko se logo prikazuje u zaglavlju/footeru (npr. 40)."
                    class="sm:max-w-[220px]"
                    :error="err('logo_visina')"
                />
                <div class="grid gap-4 sm:grid-cols-2">
                    <TranslatableField v-model="form.brand_naziv" label="Naziv sajta" required :errors="trErr('brand_naziv')" />
                    <TranslatableField v-model="form.brand_logo_tekst" label="Logo (tekst)" required :errors="trErr('brand_logo_tekst')" />
                </div>
            </div>
        </Card>

        <Card v-show="tab === 'kontakt'" title="Kontakt">
            <div class="grid gap-4 sm:grid-cols-3">
                <FormField v-model="form.kontakt_adresa" label="Adresa" required :error="err('kontakt_adresa')" />
                <FormField v-model="form.kontakt_telefon" label="Telefon" required :error="err('kontakt_telefon')" />
                <FormField v-model="form.kontakt_email" type="email" label="E-mail" required :error="err('kontakt_email')" />
            </div>
        </Card>

        <Card v-show="tab === 'drustvene'" title="Društvene mreže" :count="form.social.length">
            <p class="mb-3 text-[13px] text-ink-3">Linkovi prikazani u zaglavlju i footeru. Prevuci za promjenu redoslijeda.</p>

            <div class="space-y-2">
                <div
                    v-for="(s, i) in form.social"
                    :key="s._id"
                    class="flex items-start gap-2 rounded-lg border border-line bg-surface-alt p-2"
                    @dragover.prevent
                    @drop="onDrop(i)"
                >
                    <span
                        draggable="true"
                        title="Prevuci"
                        class="mt-2 cursor-grab text-ink-3 hover:text-ink active:cursor-grabbing"
                        @dragstart="onDragStart(i)"
                    >
                        <GripVertical :size="18" />
                    </span>
                    <div class="grid flex-1 gap-2 sm:grid-cols-[140px_1fr_1.4fr]">
                        <FormField v-model="s.name" placeholder="ikona (facebook)" :error="err(`social.${i}.name`)" />
                        <FormField v-model="s.label" placeholder="Naziv (Facebook)" :error="err(`social.${i}.label`)" />
                        <FormField v-model="s.href" placeholder="https://..." :error="err(`social.${i}.href`)" />
                    </div>
                    <button type="button" class="mt-1 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-bad hover:bg-bad-bg" title="Ukloni" @click="removeSocial(i)">
                        <Trash2 :size="16" />
                    </button>
                </div>
            </div>

            <button type="button" class="mt-3 inline-flex items-center gap-1.5 rounded-md border border-dashed border-line px-3 py-2 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt" @click="addSocial">
                <Plus :size="15" /> Dodaj mrežu
            </button>

            <div v-if="!form.social.length" class="mt-2 flex flex-col items-center gap-1.5 py-6 text-center">
                <Share2 :size="24" class="text-ink-3" />
                <p class="text-[13px] text-ink-3">Nema dodanih mreža.</p>
            </div>
        </Card>

        <Card v-show="tab === 'footer'" title="Footer">
            <div class="space-y-4">
                <TranslatableField v-model="form.footer_opis" label="Footer opis" type="textarea" :rows="3" hint="Dozvoljen HTML (npr. <a href=…>)." :errors="trErr('footer_opis')" />
                <TranslatableField v-model="form.copyright" label="Copyright" type="textarea" :rows="2" hint="Dozvoljen HTML - npr. link ka autoru." :errors="trErr('copyright')" />

                <div class="border-t border-line pt-4">
                    <p class="text-sm font-medium text-ink">Partneri</p>
                    <p class="mb-2 text-[13px] text-ink-3">Logo, naziv i link partnera. Prevuci za redoslijed. Prikazuju se u footeru i na „O projektu".</p>

                    <TranslatableField
                        v-model="form.partneri_tekst"
                        label="Tekst uz partnere (napomena / finansijer)"
                        type="textarea"
                        hint="Prikazuje se iznad logotipa - atribucija finansijera. Dozvoljen HTML. Ostavi prazno ako ne treba."
                        :rows="2"
                        :errors="trErr('partneri_tekst')"
                        class="mb-4"
                    />

                    <div class="space-y-2">
                        <div
                            v-for="(p, i) in partneri"
                            :key="p.id"
                            class="flex items-start gap-2 rounded-lg border border-line bg-surface-alt p-2.5"
                            @dragover.prevent
                            @drop="pDrop(i)"
                        >
                            <span draggable="true" title="Prevuci" class="mt-2 cursor-grab text-ink-3 hover:text-ink active:cursor-grabbing" @dragstart="pDragStart(i)">
                                <GripVertical :size="18" />
                            </span>
                            <div class="flex-1 space-y-2.5">
                                <ImageUpload
                                    :src="p.logo"
                                    :upload-url="`/administracija/postavke/partneri/${p.id}/logo`"
                                    :delete-url="`/administracija/postavke/partneri/${p.id}/logo`"
                                    aspect="auto"
                                    shape="rect"
                                    :output-width="400"
                                    output-type="image/png"
                                />
                                <div class="grid gap-2 sm:grid-cols-2">
                                    <input
                                        v-model="p.naziv"
                                        type="text"
                                        placeholder="Naziv partnera"
                                        class="h-10 w-full rounded-md border border-line bg-surface px-3 text-[13px] text-ink placeholder:text-ink-3 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                                        @change="sacuvajPartnera(p)"
                                    />
                                    <input
                                        v-model="p.href"
                                        type="url"
                                        placeholder="https://... (opcionalno)"
                                        class="h-10 w-full rounded-md border border-line bg-surface px-3 text-[13px] text-ink placeholder:text-ink-3 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                                        @change="sacuvajPartnera(p)"
                                    />
                                </div>
                            </div>
                            <button type="button" class="mt-1 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-bad hover:bg-bad-bg" title="Ukloni partnera" @click="ukloniPartnera(p.id)">
                                <Trash2 :size="16" />
                            </button>
                        </div>
                    </div>

                    <button type="button" class="mt-3 inline-flex items-center gap-1.5 rounded-md border border-dashed border-line px-3 py-2 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt" @click="dodajPartnera">
                        <Plus :size="15" /> Dodaj partnera
                    </button>

                    <div v-if="!partneri.length" class="mt-2 flex flex-col items-center gap-1.5 py-6 text-center">
                        <Handshake :size="24" class="text-ink-3" />
                        <p class="text-[13px] text-ink-3">Nema dodanih partnera.</p>
                    </div>
                </div>
            </div>
        </Card>

        <Card v-show="tab === 'seo'" title="SEO i pristup">
            <div class="space-y-4">
                <TranslatableField
                    v-model="form.seo_opis"
                    label="Podrazumijevani meta opis"
                    type="textarea"
                    hint="Koristi se za stranice bez vlastitog opisa (meta description, og:description)."
                    :rows="2"
                    :errors="trErr('seo_opis')"
                />
                <div class="border-t border-line pt-4">
                    <ToggleField v-model="form.google_indeksiranje" label="Dozvoli Google indeksiranje" hint="Isključi na dev serveru (noindex + robots.txt)." />
                </div>
                <div class="border-t border-line pt-4">
                    <ToggleField v-model="form.odrzavanje" label="Režim održavanja" hint="Posjetioci vide stranicu održavanja s poljem za lozinku." />
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <FormField v-model="form.odrzavanje_lozinka" label="Lozinka za pristup" hint="Posjetilac je unosi da otključa frontend." :error="err('odrzavanje_lozinka')" />
                    <FormField v-model.number="form.odrzavanje_minuta" type="number" label="Trajanje otključavanja (min)" :error="err('odrzavanje_minuta')" />
                </div>
                <TextareaField v-model="form.odrzavanje_poruka" label="Poruka na stranici održavanja" :rows="2" :error="err('odrzavanje_poruka')" />
            </div>
        </Card>
    </div>
</template>
