<script setup>
import { useForm, router } from '@inertiajs/vue3';
import ResourceFormShell from '../../components/ResourceFormShell.vue';
import Card from '../../components/Card.vue';
import FormField from '../../components/FormField.vue';
import TextareaField from '../../components/TextareaField.vue';
import RichTextField from '../../components/RichTextField.vue';

const props = defineProps({
    prica: { type: Object, default: null },
    kategorije: { type: Array, default: () => [] },
    statusi: { type: Array, default: () => [] },
    segmenti: { type: Object, default: () => ({ sr: 'prica' }) },
    pending: { type: Object, default: null },
});

function odobriIzmjene() {
    router.post(`/administracija/price/${props.prica.id}/odobri-izmjene`, {}, { preserveScroll: true });
}
function odbijIzmjene() {
    router.post(`/administracija/price/${props.prica.id}/odbij-izmjene`, {}, { preserveScroll: true });
}

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
    tags: [...(props.prica?.tags ?? [])],
});
</script>

<template>
    <ResourceFormShell
        :item="prica"
        :form="form"
        :kategorije="kategorije"
        :statusi="statusi"
        :segmenti="segmenti"
        naslov="priča"
        baza="price"
        naslov-placeholder="Naslov priče"
        :feature="{ key: 'featured', label: 'Izdvojena priča', hint: 'Prikazuje se izdvojeno na naslovnoj.' }"
    >
        <template #fields="{ activeLang, trGet, trSet }">
            <div v-if="pending" class="rounded-xl border border-[#d63638]/40 bg-[#fcebeb] p-4 md:p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="text-[15px] font-bold text-ink">Izmjene na čekanju</h2>
                    <div class="flex gap-2">
                        <button type="button" class="rounded-lg bg-brand px-3 py-1.5 text-[13px] font-bold text-white hover:opacity-90" @click="odobriIzmjene">Odobri izmjene</button>
                        <button type="button" class="rounded-lg border border-line bg-surface px-3 py-1.5 text-[13px] font-bold text-ink hover:bg-surface-alt" @click="odbijIzmjene">Odbij izmjene</button>
                    </div>
                </div>
                <p class="mt-1 text-[12px] text-ink-2">Autor je poslao izmjene. Živa priča ostaje objavljena dok ne odobriš.</p>

                <div v-if="pending.diff.length" class="mt-3 space-y-2">
                    <div v-for="r in pending.diff" :key="r.polje" class="rounded-lg border border-line bg-surface p-2.5">
                        <p class="text-[12px] font-bold text-ink">{{ r.polje }}</p>
                        <div class="mt-1 grid gap-1 text-[13px] sm:grid-cols-2">
                            <div class="text-ink-3 line-through">{{ r.staro || '—' }}</div>
                            <div class="font-medium text-ink">{{ r.novo || '—' }}</div>
                        </div>
                    </div>
                </div>
                <p v-else class="mt-3 text-[13px] text-ink-2">Nema promjena u tekstualnim poljima.</p>
            </div>

            <Card title="Sadržaj">
                <div class="space-y-4">
                    <TextareaField :model-value="trGet(form.izvod)" label="Izvod (uvod)" :rows="3" hint="Kratak sažetak prikazan na kartici i vrhu priče." :error="form.errors[`izvod.${activeLang}`]" @update:model-value="trSet('izvod', $event)" />
                    <RichTextField :model-value="form.sadrzaj" :lang="activeLang" label="Tekst priče" @update:model-value="form.sadrzaj = $event" />
                </div>
            </Card>

            <Card title="Autor">
                <div class="grid grid-cols-1 gap-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <FormField :model-value="trGet(form.autor)" label="Ime autora" placeholder="npr. Marko Marković" @update:model-value="trSet('autor', $event)" />
                        <FormField v-model="form.datum" type="date" label="Datum objave" :error="form.errors.datum" />
                    </div>
                    <TextareaField :model-value="trGet(form.autor_bio)" label="O autoru" :rows="2" @update:model-value="trSet('autor_bio', $event)" />
                </div>
            </Card>
        </template>
    </ResourceFormShell>
</template>
