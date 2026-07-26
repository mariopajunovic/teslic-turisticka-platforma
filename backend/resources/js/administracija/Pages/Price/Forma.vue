<script setup>
import { useForm } from '@inertiajs/vue3';
import ResourceFormShell from '../../components/ResourceFormShell.vue';
import Card from '../../components/Card.vue';
import FormField from '../../components/FormField.vue';
import TextareaField from '../../components/TextareaField.vue';
import RichTextField from '../../components/RichTextField.vue';

const props = defineProps({
    prica: { type: Object, default: null },
    kategorije: { type: Array, default: () => [] },
    statusi: { type: Array, default: () => [] },
    korisnici: { type: Array, default: () => [] },
    segmenti: { type: Object, default: () => ({ sr: 'prica' }) },
    pending: { type: Object, default: null },
});

const form = useForm({
    naslov: { ...(props.prica?.naslov ?? {}) },
    slug: { ...(props.prica?.slug ?? {}) },
    izvod: { ...(props.prica?.izvod ?? {}) },
    sadrzaj: { ...(props.prica?.sadrzaj ?? {}) },
    autor: { ...(props.prica?.autor ?? {}) },
    autor_bio: { ...(props.prica?.autor_bio ?? {}) },
    datum: props.prica?.datum ?? '',
    featured: props.prica?.featured ?? false,
    category_id: props.prica?.category_id ?? '',
    status: props.prica?.status ?? 'nacrt',
    user_id: props.prica?.user_id ?? null,
    tags: [...(props.prica?.tags ?? [])],
});
</script>

<template>
    <ResourceFormShell
        :item="prica"
        :form="form"
        :kategorije="kategorije"
        :statusi="statusi"
        :korisnici="korisnici"
        :pending="pending"
        subjekt="autor"
        :segmenti="segmenti"
        naslov="priča"
        baza="price"
        naslov-placeholder="Naslov priče"
        :feature="{ key: 'featured', label: 'Izdvojena priča', hint: 'Prikazuje se izdvojeno na naslovnoj.' }"
    >
        <template #fields="{ activeLang, trGet, trSet }">
            <Card title="Sadržaj">
                <div class="space-y-4">
                    <TextareaField :model-value="trGet(form.izvod)" label="Izvod (uvod)" :rows="3" hint="Kratak sažetak prikazan na kartici i vrhu priče." :error="form.errors[`izvod.${activeLang}`]" @update:model-value="trSet('izvod', $event)" />
                    <RichTextField :model-value="form.sadrzaj" :lang="activeLang" label="Tekst priče" @update:model-value="form.sadrzaj = $event" />
                </div>
            </Card>

            <Card title="Autor">
                <div class="grid grid-cols-1 gap-4">
                    <div v-if="form.user_id" class="rounded-lg border border-line bg-surface-alt p-3 text-[13px] text-ink-2">
                        Ime autora i biografija se automatski preuzimaju iz vezanog korisnika (vidi „Vlasnik").
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <FormField v-if="!form.user_id" :model-value="trGet(form.autor)" label="Ime autora" placeholder="npr. Marko Marković" @update:model-value="trSet('autor', $event)" />
                        <FormField v-model="form.datum" type="date" label="Datum objave" :error="form.errors.datum" />
                    </div>
                    <TextareaField v-if="!form.user_id" :model-value="trGet(form.autor_bio)" label="O autoru" :rows="2" @update:model-value="trSet('autor_bio', $event)" />
                </div>
            </Card>
        </template>
    </ResourceFormShell>
</template>
