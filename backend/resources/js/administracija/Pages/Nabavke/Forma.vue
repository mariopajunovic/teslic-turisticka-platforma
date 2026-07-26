<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { FileText, X, Plus, Loader2 } from 'lucide-vue-next';
import ResourceFormShell from '../../components/ResourceFormShell.vue';
import Card from '../../components/Card.vue';
import FormField from '../../components/FormField.vue';
import RichTextField from '../../components/RichTextField.vue';

const props = defineProps({
    nabavka: { type: Object, default: null },
    kategorije: { type: Array, default: () => [] },
    statusi: { type: Array, default: () => [] },
    korisnici: { type: Array, default: () => [] },
    pending: { type: Object, default: null },
    segmenti: { type: Object, default: () => ({ sr: 'javna-nabavka' }) },
});

const form = useForm({
    naslov: { ...(props.nabavka?.naslov ?? {}) },
    slug: { ...(props.nabavka?.slug ?? {}) },
    opis: { ...(props.nabavka?.opis ?? {}) },
    godina: props.nabavka?.godina ?? '',
    datum: props.nabavka?.datum ?? '',
    status: props.nabavka?.status ?? 'nacrt',
    user_id: props.nabavka?.user_id ?? null,
    tags: [...(props.nabavka?.tags ?? [])],
});

const pdfInput = ref(null);
const uploading = ref(false);
const pickPdf = () => pdfInput.value?.click();
const onPdf = (e) => {
    const file = e.target.files?.[0];
    e.target.value = '';
    if (!file || !props.nabavka?.id) return;
    uploading.value = true;
    router.post(`/administracija/nabavke/${props.nabavka.id}/dokument`, { dokument: file }, {
        forceFormData: true,
        preserveScroll: true,
        preserveState: false,
        onFinish: () => { uploading.value = false; },
    });
};
const obrisiDokument = (d) => {
    router.delete(`/administracija/nabavke/dokument/${d.id}`, { preserveScroll: true });
};
</script>

<template>
    <ResourceFormShell
        :item="nabavka"
        :form="form"
        :statusi="statusi"
        :korisnici="korisnici"
        :pending="pending"
        :segmenti="segmenti"
        naslov="javnu nabavku"
        baza="nabavke"
        naslov-placeholder="Naslov javne nabavke"
        :has-category="false"
        :has-media="false"
    >
        <template #fields="{ activeLang, trGet, trSet, isNew }">
            <Card title="Podaci">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <FormField v-model="form.godina" type="number" label="Godina" placeholder="npr. 2026" hint="Za grupisanje na javnoj stranici." :error="form.errors.godina" />
                        <FormField v-model="form.datum" type="date" label="Datum objave" :error="form.errors.datum" />
                    </div>
                    <RichTextField :model-value="form.opis" :lang="activeLang" label="Opis" @update:model-value="form.opis = $event" />
                </div>
            </Card>

            <Card title="Dokumenti (PDF)">
                <template v-if="!isNew">
                    <div v-if="(nabavka?.dokumenti || []).length" class="mb-3 space-y-2">
                        <div v-for="d in nabavka.dokumenti" :key="d.id" class="flex items-center justify-between rounded-md border border-line px-3 py-2">
                            <a :href="d.url" target="_blank" class="flex items-center gap-2 text-[13px] font-semibold text-brand hover:underline">
                                <FileText :size="15" /> {{ d.naziv }}
                            </a>
                            <button type="button" class="text-ink-3 hover:text-bad" title="Ukloni" @click="obrisiDokument(d)"><X :size="15" /></button>
                        </div>
                    </div>
                    <p v-else class="mb-3 text-xs text-ink-3">Nema dodanih dokumenata.</p>
                    <button type="button" :disabled="uploading" class="inline-flex h-9 items-center gap-2 rounded-md border border-dashed border-line-strong bg-surface-alt px-4 text-[13px] font-semibold text-ink-2 hover:border-brand hover:text-brand disabled:opacity-50" @click="pickPdf">
                        <Loader2 v-if="uploading" :size="16" class="animate-spin" />
                        <Plus v-else :size="16" /> Dodaj PDF
                    </button>
                    <input ref="pdfInput" type="file" accept="application/pdf" class="hidden" @change="onPdf" />
                </template>
                <p v-else class="flex items-center gap-2 text-sm text-ink-3">
                    <FileText :size="16" /> Sačuvajte nabavku da biste dodali dokumente.
                </p>
            </Card>
        </template>
    </ResourceFormShell>
</template>
