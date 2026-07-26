<script setup>
import { useForm } from '@inertiajs/vue3';
import ResourceFormShell from '../../components/ResourceFormShell.vue';
import Card from '../../components/Card.vue';
import FormField from '../../components/FormField.vue';
import TextareaField from '../../components/TextareaField.vue';
import RichTextField from '../../components/RichTextField.vue';

const props = defineProps({
    vijest: { type: Object, default: null },
    kategorije: { type: Array, default: () => [] },
    statusi: { type: Array, default: () => [] },
    korisnici: { type: Array, default: () => [] },
    pending: { type: Object, default: null },
    segmenti: { type: Object, default: () => ({ sr: 'vijest' }) },
});

const form = useForm({
    naslov: { ...(props.vijest?.naslov ?? {}) },
    slug: { ...(props.vijest?.slug ?? {}) },
    izvod: { ...(props.vijest?.izvod ?? {}) },
    sadrzaj: { ...(props.vijest?.sadrzaj ?? {}) },
    datum: props.vijest?.datum ?? '',
    status: props.vijest?.status ?? 'nacrt',
    user_id: props.vijest?.user_id ?? null,
    tags: [...(props.vijest?.tags ?? [])],
});
</script>

<template>
    <ResourceFormShell
        :item="vijest"
        :form="form"
        :statusi="statusi"
        :korisnici="korisnici"
        :pending="pending"
        :segmenti="segmenti"
        naslov="vijest"
        baza="vijesti"
        naslov-placeholder="Naslov vijesti"
        :has-category="false"
    >
        <template #fields="{ activeLang, trGet, trSet }">
            <Card title="Sadržaj">
                <div class="space-y-4">
                    <TextareaField :model-value="trGet(form.izvod)" label="Izvod (uvod)" :rows="3" hint="Kratak sažetak prikazan na kartici i vrhu vijesti." :error="form.errors[`izvod.${activeLang}`]" @update:model-value="trSet('izvod', $event)" />
                    <RichTextField :model-value="form.sadrzaj" :lang="activeLang" label="Tekst vijesti" @update:model-value="form.sadrzaj = $event" />
                    <FormField v-model="form.datum" type="date" label="Datum" :error="form.errors.datum" />
                </div>
            </Card>
        </template>
    </ResourceFormShell>
</template>
