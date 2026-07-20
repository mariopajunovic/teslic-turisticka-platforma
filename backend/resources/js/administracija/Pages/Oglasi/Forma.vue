<script setup>
import { useForm } from '@inertiajs/vue3';
import ResourceFormShell from '../../components/ResourceFormShell.vue';
import Card from '../../components/Card.vue';
import FormField from '../../components/FormField.vue';
import RichTextField from '../../components/RichTextField.vue';

const props = defineProps({
    oglas: { type: Object, default: null },
    kategorije: { type: Array, default: () => [] },
    statusi: { type: Array, default: () => [] },
    segmenti: { type: Object, default: () => ({ sr: 'oglas' }) },
});

const form = useForm({
    naslov: { ...(props.oglas?.naslov ?? {}) },
    slug: { ...(props.oglas?.slug ?? {}) },
    izdavac: { ...(props.oglas?.izdavac ?? {}) },
    lokacija: { ...(props.oglas?.lokacija ?? {}) },
    opis_dug: { ...(props.oglas?.opis_dug ?? {}) },
    rok: props.oglas?.rok ?? '',
    kontakt: {
        osoba: props.oglas?.kontakt?.osoba ?? '',
        telefon: props.oglas?.kontakt?.telefon ?? '',
        email: props.oglas?.kontakt?.email ?? '',
    },
    category_id: props.oglas?.category_id ?? '',
    status: props.oglas?.status ?? 'nacrt',
    tags: [...(props.oglas?.tags ?? [])],
});
</script>

<template>
    <ResourceFormShell
        :item="oglas"
        :form="form"
        :kategorije="kategorije"
        :statusi="statusi"
        :segmenti="segmenti"
        naslov="oglas"
        baza="oglasi"
        naslov-placeholder="Naslov oglasa"
        :has-media="false"
    >
        <template #fields="{ activeLang, trGet, trSet }">
            <Card title="Sadržaj">
                <div class="space-y-4">
                    <RichTextField :model-value="form.opis_dug" :lang="activeLang" label="Opis oglasa" @update:model-value="form.opis_dug = $event" />
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <FormField :model-value="trGet(form.izdavac)" label="Izdavač" placeholder="npr. Hotel Kardial" @update:model-value="trSet('izdavac', $event)" />
                        <FormField :model-value="trGet(form.lokacija)" label="Lokacija" placeholder="npr. Teslić, centar" @update:model-value="trSet('lokacija', $event)" />
                        <FormField v-model="form.rok" type="date" label="Rok" :error="form.errors.rok" />
                    </div>
                </div>
            </Card>

            <Card title="Kontakt">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <FormField v-model="form.kontakt.osoba" label="Kontakt osoba" placeholder="Ime i prezime" />
                    <FormField v-model="form.kontakt.telefon" label="Telefon" placeholder="065/123-456" />
                    <FormField v-model="form.kontakt.email" label="E-mail" type="email" placeholder="kontakt@primjer.ba" />
                </div>
            </Card>
        </template>
    </ResourceFormShell>
</template>
