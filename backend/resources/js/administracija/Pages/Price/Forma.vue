<script setup>
import { ref } from 'vue';
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
    korisnici: { type: Array, default: () => [] },
    segmenti: { type: Object, default: () => ({ sr: 'prica' }) },
    pending: { type: Object, default: null },
});

const vracaSe = ref(false);
const razlogVracanja = ref('');

function odobriIzmjene() {
    router.post(`/administracija/price/${props.prica.id}/odobri-izmjene`, {}, { preserveScroll: true });
}
function vratiIzmjene() {
    if (!razlogVracanja.value.trim()) return;
    router.post(`/administracija/price/${props.prica.id}/vrati-izmjene`, { pending_reason: razlogVracanja.value }, {
        preserveScroll: true,
        onSuccess: () => { vracaSe.value = false; razlogVracanja.value = ''; },
    });
}
function odbijIzmjene() {
    router.post(`/administracija/price/${props.prica.id}/odbij-izmjene`, {}, { preserveScroll: true });
}

const akcijaNovog = ref(null);
const razlogNovog = ref('');

function odobriNovi() {
    router.post(`/administracija/price/${props.prica.id}/odobri`, {}, { preserveScroll: true });
}
function posaljiAkcijuNovog() {
    if (!razlogNovog.value.trim()) return;
    const put = akcijaNovog.value === 'vrati' ? 'vrati' : 'odbij';
    router.post(`/administracija/price/${props.prica.id}/${put}`, { rejection_reason: razlogNovog.value }, {
        preserveScroll: true,
        onSuccess: () => { akcijaNovog.value = null; razlogNovog.value = ''; },
    });
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
                        <button type="button" class="rounded-lg border border-line bg-surface px-3 py-1.5 text-[13px] font-bold text-ink hover:bg-surface-alt" @click="vracaSe = !vracaSe">Vrati na doradu</button>
                        <button type="button" class="rounded-lg border border-line bg-surface px-3 py-1.5 text-[13px] font-bold text-ink hover:bg-surface-alt" @click="odbijIzmjene">Odbij izmjene</button>
                    </div>
                </div>
                <p class="mt-1 text-[12px] text-ink-2">Autor je poslao izmjene. Živa priča ostaje objavljena dok ne odobriš.</p>

                <div v-if="vracaSe" class="mt-3 space-y-2 rounded-lg border border-line bg-surface p-3">
                    <label class="text-[12px] font-bold text-ink">Šta autor treba da ispravi?</label>
                    <textarea v-model="razlogVracanja" rows="2" placeholder="Npr. Provjeri činjenice u drugom pasusu, dodaj izvor..." class="w-full rounded-lg border border-line bg-surface p-2 text-[13px] text-ink focus:border-brand focus:outline-none"></textarea>
                    <button type="button" :disabled="!razlogVracanja.trim()" class="rounded-lg bg-[#8C5810] px-3 py-1.5 text-[13px] font-bold text-white hover:opacity-90 disabled:opacity-40" @click="vratiIzmjene">Pošalji autoru na doradu</button>
                </div>

                <div v-if="pending.diff.length" class="mt-3 space-y-2">
                    <div v-for="r in pending.diff" :key="r.polje" class="rounded-lg border border-line bg-surface p-2.5">
                        <p class="text-[12px] font-bold text-ink">{{ r.polje }}</p>
                        <div class="mt-1 grid gap-1 text-[13px] sm:grid-cols-2">
                            <div class="text-ink-3 line-through">{{ r.staro || '-' }}</div>
                            <div class="font-medium text-ink">{{ r.novo || '-' }}</div>
                        </div>
                    </div>
                </div>
                <p v-else class="mt-3 text-[13px] text-ink-2">Nema promjena u tekstualnim poljima.</p>
            </div>

            <div v-if="prica && !pending && form.status === 'poslano'" class="rounded-xl border border-[#8C5810]/40 bg-[#fff8ee] p-4 md:p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="text-[15px] font-bold text-ink">Novi unos na čekanju</h2>
                    <div class="flex gap-2">
                        <button type="button" class="rounded-lg bg-brand px-3 py-1.5 text-[13px] font-bold text-white hover:opacity-90" @click="odobriNovi">Odobri i objavi</button>
                        <button type="button" class="rounded-lg border border-line bg-surface px-3 py-1.5 text-[13px] font-bold text-ink hover:bg-surface-alt" @click="akcijaNovog = akcijaNovog === 'vrati' ? null : 'vrati'">Vrati na doradu</button>
                        <button type="button" class="rounded-lg border border-line bg-surface px-3 py-1.5 text-[13px] font-bold text-ink hover:bg-surface-alt" @click="akcijaNovog = akcijaNovog === 'odbij' ? null : 'odbij'">Odbij</button>
                    </div>
                </div>
                <p class="mt-1 text-[12px] text-ink-2">Novi unos čeka pregled. Odobri za objavu, ili ga vrati autoru na doradu / odbij uz razlog.</p>

                <div v-if="akcijaNovog" class="mt-3 space-y-2 rounded-lg border border-line bg-surface p-3">
                    <label class="text-[12px] font-bold text-ink">{{ akcijaNovog === 'vrati' ? 'Šta autor treba da ispravi?' : 'Razlog odbijanja' }}</label>
                    <textarea v-model="razlogNovog" rows="2" class="w-full rounded-lg border border-line bg-surface p-2 text-[13px] text-ink focus:border-brand focus:outline-none"></textarea>
                    <button type="button" :disabled="!razlogNovog.trim()" class="rounded-lg bg-[#8C5810] px-3 py-1.5 text-[13px] font-bold text-white hover:opacity-90 disabled:opacity-40" @click="posaljiAkcijuNovog">{{ akcijaNovog === 'vrati' ? 'Pošalji na doradu' : 'Odbij unos' }}</button>
                </div>
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
