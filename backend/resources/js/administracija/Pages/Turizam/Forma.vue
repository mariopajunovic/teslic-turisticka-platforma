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
    lokalitet: { type: Object, default: null },
    kategorije: { type: Array, default: () => [] },
    statusi: { type: Array, default: () => [] },
    korisnici: { type: Array, default: () => [] },
    pending: { type: Object, default: null },
    segmenti: { type: Object, default: () => ({ sr: 'lokalitet' }) },
});

const form = useForm({
    naslov: { ...(props.lokalitet?.naslov ?? {}) },
    slug: { ...(props.lokalitet?.slug ?? {}) },
    opis: { ...(props.lokalitet?.opis ?? {}) },
    opis_dug: { ...(props.lokalitet?.opis_dug ?? {}) },
    lokacija: { ...(props.lokalitet?.lokacija ?? {}) },
    kako_doci: { ...(props.lokalitet?.kako_doci ?? {}) },
    savjeti: { ...(props.lokalitet?.savjeti ?? {}) },
    sezona: { ...(props.lokalitet?.sezona ?? {}) },
    radno_vrijeme: { ...(props.lokalitet?.radno_vrijeme ?? {}) },
    ulaznice: { ...(props.lokalitet?.ulaznice ?? {}) },
    category_id: props.lokalitet?.category_id ?? '',
    lat: props.lokalitet?.lat ?? '',
    lng: props.lokalitet?.lng ?? '',
    preporuceno: props.lokalitet?.preporuceno ?? false,
    status: props.lokalitet?.status ?? 'nacrt',
    user_id: props.lokalitet?.user_id ?? null,
    tags: [...(props.lokalitet?.tags ?? [])],
});
</script>

<template>
    <ResourceFormShell
        :item="lokalitet"
        :form="form"
        :kategorije="kategorije"
        :statusi="statusi"
        :korisnici="korisnici"
        :pending="pending"
        :segmenti="segmenti"
        naslov="lokalitet"
        baza="turizam"
        naslov-placeholder="Naziv lokaliteta"
        :feature="{ key: 'preporuceno', label: 'Preporučeni lokalitet', hint: 'Prikazuje se izdvojeno u ponudi.' }"
    >
        <template #fields="{ activeLang, trGet, trSet }">
            <Card title="Opis">
                <div class="space-y-4">
                    <TextareaField :model-value="trGet(form.opis)" label="Kratki opis" :rows="3" hint="Sažetak na kartici i u listi." :error="form.errors[`opis.${activeLang}`]" @update:model-value="trSet('opis', $event)" />
                    <RichTextField :model-value="form.opis_dug" :lang="activeLang" label="Detaljan opis (O lokaciji)" @update:model-value="form.opis_dug = $event" />
                </div>
            </Card>

            <Card title="Detalji">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <FormField :model-value="trGet(form.sezona)" label="Sezona" placeholder="npr. Cijele godine" @update:model-value="trSet('sezona', $event)" />
                    <FormField :model-value="trGet(form.radno_vrijeme)" label="Radno vrijeme" placeholder="npr. 08-20h" @update:model-value="trSet('radno_vrijeme', $event)" />
                    <FormField :model-value="trGet(form.ulaznice)" label="Ulaznice" placeholder="npr. Besplatno" @update:model-value="trSet('ulaznice', $event)" />
                </div>
                <div class="mt-4 grid grid-cols-1 gap-4">
                    <TextareaField :model-value="trGet(form.kako_doci)" label="Kako doći" :rows="3" @update:model-value="trSet('kako_doci', $event)" />
                    <TextareaField :model-value="trGet(form.savjeti)" label="Savjeti" :rows="3" @update:model-value="trSet('savjeti', $event)" />
                </div>
            </Card>

            <Card title="Lokacija na mapi">
                <div class="mb-4">
                    <FormField :model-value="trGet(form.lokacija)" label="Naziv lokacije" placeholder="npr. Borje, Teslić" hint="Prikazuje se u zaglavlju. Prevodi se po jeziku." @update:model-value="trSet('lokacija', $event)" />
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
