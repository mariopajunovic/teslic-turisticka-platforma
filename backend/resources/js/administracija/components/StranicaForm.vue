<script setup>
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { X } from 'lucide-vue-next';
import FormField from './FormField.vue';
import SelectField from './SelectField.vue';
import ToggleField from './ToggleField.vue';
import TranslatableField from './TranslatableField.vue';

const props = defineProps({
    stranica: { type: Object, default: null },
    tipovi: { type: Array, default: () => [] },
    kategorije: { type: Array, default: () => [] },
    roditelji: { type: Array, default: () => [] },
    katTipovi: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['close']);

const jeEdit = computed(() => !!props.stranica);

const form = useForm({
    title: { ...(props.stranica?.titleTranslations || {}) },
    slug: props.stranica?.slug ?? '',
    published: props.stranica ? !!props.stranica.published : true,
    resource_type: props.stranica?.resourceType ?? '',
    category_id: props.stranica?.categoryId ?? '',
    parent_id: props.stranica?.parentId ?? '',
    meta_title: { ...(props.stranica?.metaTitleTranslations || {}) },
    meta_description: { ...(props.stranica?.metaDescriptionTranslations || {}) },
});

const tipoviOpcije = computed(() => [{ value: '', label: 'Obična stranica' }, ...props.tipovi]);
const kategorijeOpcije = computed(() => {
    const catType = form.resource_type ? props.katTipovi[form.resource_type] : null;
    const sve = props.kategorije;
    const filtrirane = catType ? sve.filter((k) => k.type === catType) : sve;
    return [{ value: '', label: 'Sve kategorije' }, ...filtrirane];
});
const roditeljiOpcije = computed(() => [
    { value: '', label: '(bez roditelja)' },
    ...props.roditelji.filter((r) => r.value !== props.stranica?.id),
]);

const trErr = (field) => {
    const out = {};
    for (const [k, v] of Object.entries(form.errors)) {
        if (k.startsWith(`${field}.`)) out[k.slice(field.length + 1)] = v;
    }
    return out;
};

const preview = computed(() => ({
    title: form.meta_title.sr || form.title.sr || 'Naslov stranice',
    desc: form.meta_description.sr || 'Meta opis stranice prikazan u rezultatima pretrage.',
    url: props.stranica?.url === '/' ? 'teslic.travel' : `teslic.travel${props.stranica?.url || '/' + (form.slug || '…')}`,
}));

const submit = () => {
    const opts = { preserveScroll: true, onSuccess: () => emit('close') };
    if (jeEdit.value) {
        form.put(`/administracija/stranice/${props.stranica.id}`, opts);
    } else {
        form.post('/administracija/stranice', opts);
    }
};
</script>

<template>
    <div class="overflow-hidden rounded-[var(--radius-card)] border border-line bg-surface shadow-[var(--shadow-pop)]">
        <div class="flex items-center justify-between border-b border-line px-[18px] py-[15px]">
            <h3 class="text-[15px] font-bold text-ink">{{ jeEdit ? 'Postavke stranice' : 'Nova stranica' }}</h3>
            <button type="button" class="text-ink-3 hover:text-ink" aria-label="Zatvori" @click="emit('close')">
                <X :size="18" />
            </button>
        </div>

        <form @submit.prevent="submit">
            <div class="max-h-[70vh] space-y-4 overflow-y-auto p-5">
                <TranslatableField v-model="form.title" label="Naslov stranice" required :errors="trErr('title')" />

                <FormField
                    v-model="form.slug"
                    label="URL adresa (slug)"
                    :placeholder="jeEdit ? '' : 'auto iz naslova'"
                    :disabled="stranica?.slugLocked"
                    :hint="stranica?.slugLocked ? 'Sistemska stranica - URL je fiksan (vezan za rute) i ne mijenja se.' : 'Mala slova, crtice. Ostale stranice: /slug.'"
                    :error="form.errors.slug"
                />

                <ToggleField v-model="form.published" label="Objavljeno" hint="Nacrt nije vidljiv posjetiocima." />

                <div class="border-t border-line pt-4">
                    <p class="text-sm font-bold text-ink">Šta stranica prikazuje</p>
                    <p class="mb-3 text-xs text-ink-3">Obična stranica ili lista sadržaja (biznisi, turizam, priče…).</p>
                    <div class="space-y-4">
                        <SelectField
                            v-model="form.resource_type"
                            label="Tip sadržaja"
                            :options="tipoviOpcije"
                            @update:model-value="form.category_id = ''"
                        />
                        <SelectField
                            v-if="form.resource_type"
                            v-model="form.category_id"
                            label="Kategorija"
                            :options="kategorijeOpcije"
                            hint="Prazno znači sve kategorije."
                        />
                        <SelectField
                            v-model="form.parent_id"
                            label="Roditelj"
                            :options="roditeljiOpcije"
                            :error="form.errors.parent_id"
                        />
                    </div>
                </div>

                <div class="border-t border-line pt-4">
                    <p class="text-sm font-bold text-ink">SEO</p>
                    <p class="mb-3 text-xs text-ink-3">Kako se stranica prikazuje u pretraživačima.</p>
                    <div class="space-y-4">
                        <TranslatableField v-model="form.meta_title" label="Meta naslov" :errors="trErr('meta_title')" />
                        <TranslatableField v-model="form.meta_description" label="Meta opis" type="textarea" :rows="2" :errors="trErr('meta_description')" />

                        <div class="rounded-md border border-line bg-surface-alt p-3">
                            <p class="text-[10px] font-bold uppercase tracking-wide text-ink-3">Pregled u Google-u</p>
                            <p class="mt-1 text-xs text-ok">{{ preview.url }}</p>
                            <p class="text-[15px] font-semibold text-info">{{ preview.title }}</p>
                            <p class="text-xs text-ink-2">{{ preview.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5 border-t border-line bg-surface-alt px-5 py-4">
                <button
                    type="button"
                    class="rounded-md border border-line bg-surface px-4 py-2 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt"
                    @click="emit('close')"
                >
                    Odustani
                </button>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-md bg-brand px-4 py-2 text-[13px] font-semibold text-white hover:bg-brand-dark disabled:opacity-50"
                >
                    {{ jeEdit ? 'Sačuvaj' : 'Kreiraj stranicu' }}
                </button>
            </div>
        </form>
    </div>
</template>
