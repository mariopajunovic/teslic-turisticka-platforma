<script setup>
import { useForm } from '@inertiajs/vue3';
import { MapPin } from 'lucide-vue-next';
import ResourceFormShell from '../../components/ResourceFormShell.vue';
import Card from '../../components/Card.vue';
import FormField from '../../components/FormField.vue';
import TextareaField from '../../components/TextareaField.vue';
import RichTextField from '../../components/RichTextField.vue';
import LocationMap from '../../components/LocationMap.vue';

const props = defineProps({
    dogadjaj: { type: Object, default: null },
    kategorije: { type: Array, default: () => [] },
    statusi: { type: Array, default: () => [] },
    segmenti: { type: Object, default: () => ({ sr: 'dogadjaj' }) },
});

const form = useForm({
    naslov: { ...(props.dogadjaj?.naslov ?? {}) },
    slug: { ...(props.dogadjaj?.slug ?? {}) },
    opis: { ...(props.dogadjaj?.opis ?? {}) },
    opis_dug: { ...(props.dogadjaj?.opis_dug ?? {}) },
    lokacija: { ...(props.dogadjaj?.lokacija ?? {}) },
    organizator: { ...(props.dogadjaj?.organizator ?? {}) },
    datum: props.dogadjaj?.datum ?? '',
    vrijeme: props.dogadjaj?.vrijeme ?? '',
    zavrseno: props.dogadjaj?.zavrseno ?? false,
    category_id: props.dogadjaj?.category_id ?? '',
    lat: props.dogadjaj?.lat ?? '',
    lng: props.dogadjaj?.lng ?? '',
    status: props.dogadjaj?.status ?? 'nacrt',
    tags: [...(props.dogadjaj?.tags ?? [])],
});
</script>

<template>
    <ResourceFormShell
        :item="dogadjaj"
        :form="form"
        :kategorije="kategorije"
        :statusi="statusi"
        :segmenti="segmenti"
        naslov="događaj"
        baza="dogadjaji"
        naslov-placeholder="Naziv događaja"
        :feature="{ key: 'zavrseno', label: 'Događaj završen', hint: 'Prikazuje oznaku Završeno i onemogućuje dodavanje u kalendar.' }"
    >
        <template #fields="{ activeLang, trGet, trSet }">
            <Card title="Opis">
                <div class="space-y-4">
                    <TextareaField :model-value="trGet(form.opis)" label="Kratki opis" :rows="3" :error="form.errors[`opis.${activeLang}`]" @update:model-value="trSet('opis', $event)" />
                    <RichTextField :model-value="form.opis_dug" :lang="activeLang" label="Detaljan opis (O događaju)" @update:model-value="form.opis_dug = $event" />
                </div>
            </Card>

            <Card title="Termin i organizator">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <FormField v-model="form.datum" type="date" label="Datum" :error="form.errors.datum" />
                    <FormField v-model="form.vrijeme" label="Vrijeme" placeholder="npr. 10:00 - 16:00" :error="form.errors.vrijeme" />
                    <FormField :model-value="trGet(form.organizator)" label="Organizator" placeholder="npr. TO Teslić" @update:model-value="trSet('organizator', $event)" />
                </div>
            </Card>

            <Card title="Lokacija na mapi">
                <div class="mb-4">
                    <FormField :model-value="trGet(form.lokacija)" label="Naziv lokacije" placeholder="npr. Trg, Teslić" @update:model-value="trSet('lokacija', $event)" />
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <FormField v-model="form.lat" label="Geografska širina (lat)" placeholder="44.6000" :error="form.errors.lat" />
                    <FormField v-model="form.lng" label="Geografska dužina (lng)" placeholder="17.8600" :error="form.errors.lng" />
                </div>
                <p class="mb-2 mt-3 flex items-center gap-1.5 text-xs text-ink-3">
                    <MapPin :size="13" /> Klikni na mapu ili prevuci marker da postaviš lokaciju.
                </p>
                <LocationMap :lat="form.lat" :lng="form.lng" @update:lat="form.lat = $event" @update:lng="form.lng = $event" />
            </Card>
        </template>
    </ResourceFormShell>
</template>
