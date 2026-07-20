<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, nextTick, onMounted, onBeforeUnmount } from 'vue';
import { Save, Eye, Languages, Trash2, GripVertical, ChevronDown, Check } from 'lucide-vue-next';
import Card from '../../components/Card.vue';
import FormField from '../../components/FormField.vue';
import TextareaField from '../../components/TextareaField.vue';
import SelectField from '../../components/SelectField.vue';
import ToggleField from '../../components/ToggleField.vue';
import Btn from '../../components/Btn.vue';
import { resolveCategoryIcon, ICON_CHOICES, TIP_BOJE } from '../../lib/categoryIcon';
import { useConfirm } from '../../composables/useConfirm';

const props = defineProps({
    kategorija: { type: Object, default: null },
    tipovi: { type: Array, default: () => [] },
});

const { confirm } = useConfirm();
const page = usePage();

const locales = computed(() => {
    const list = page.props?.locales;
    return Array.isArray(list) && list.length ? list : [{ code: 'sr', name: 'Srpski' }];
});
const activeLang = ref(locales.value[0]?.code ?? 'sr');

const isNew = computed(() => !props.kategorija?.id);

const form = useForm({
    slug: { ...(props.kategorija?.slug ?? {}) },
    label: { ...(props.kategorija?.label ?? {}) },
    opis: { ...(props.kategorija?.opis ?? {}) },
    type: props.kategorija?.type ?? (props.tipovi[0]?.value ?? 'domace'),
    color: props.kategorija?.color ?? '#0E8275',
    icon: props.kategorija?.icon ?? 'tag',
    visible: props.kategorija?.visible ?? true,
});

const trGet = (map) => map?.[activeLang.value] ?? '';
const trSet = (key, val) => { form[key] = { ...(form[key] || {}), [activeLang.value]: val }; };

const slugify = (val) => String(val ?? '')
    .toLowerCase()
    .normalize('NFD').replace(/[̀-ͯ]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)/g, '');

const slugForLang = computed(() => form.slug?.[activeLang.value] ?? '');
const setSlug = (val) => { form.slug = { ...(form.slug || {}), [activeLang.value]: val }; };
const slugPreview = computed(() => slugify(trGet(form.label)));
const effSlug = computed(() => slugForLang.value || slugPreview.value || 'nova-kategorija');
const editSlug = ref(false);

const defaultLang = computed(() => locales.value[0]?.code ?? 'sr');
const langPrefix = computed(() => (activeLang.value === defaultLang.value ? '' : `/${activeLang.value}`));

const labelDisplay = computed(() => form.label?.sr || '(bez naziva)');
const tipLabel = computed(() => props.tipovi.find((t) => t.value === form.type)?.label ?? form.type);
const tipStyle = computed(() => {
    const boja = TIP_BOJE[form.type] || '#64748b';
    return { color: boja, backgroundColor: `${boja}1a` };
});

const osnovaUrl = computed(() => ({
    domace: '/domace-je-najbolje/kategorija',
    turizam: '/turizam/kategorija',
    price: '/price/kategorija',
}[form.type] ?? null));
const imaJavnuStranicu = computed(() => osnovaUrl.value !== null);
const permalink = computed(() => `${langPrefix.value}${osnovaUrl.value ?? ''}/${effSlug.value}`);
const javniUrl = computed(() => permalink.value);

const boje = ['#0E8275', '#2271B1', '#0A7D54', '#B26A00', '#D63638', '#787C82'];

const ikonaOpen = ref(false);
const ikonaTrigger = ref(null);
const ikonaMenu = ref(null);
const ikonaPos = ref({ top: 0, left: 0, width: 0 });

const postaviIkonu = () => {
    if (!ikonaTrigger.value) return;
    const r = ikonaTrigger.value.getBoundingClientRect();
    ikonaPos.value = { top: Math.round(r.bottom + 6), left: Math.round(r.left), width: Math.round(r.width) };
};
const toggleIkona = async () => {
    ikonaOpen.value = !ikonaOpen.value;
    if (ikonaOpen.value) {
        await nextTick();
        postaviIkonu();
    }
};
const zatvoriIkonu = () => (ikonaOpen.value = false);
const izaberiIkonu = (name) => { form.icon = name; zatvoriIkonu(); };

const onOutside = (e) => {
    if (!ikonaOpen.value) return;
    if (ikonaTrigger.value?.contains(e.target)) return;
    if (ikonaMenu.value?.contains(e.target)) return;
    zatvoriIkonu();
};
const onEsc = (e) => {
    if (e.key === 'Escape') zatvoriIkonu();
};
const onReflow = (e) => {
    if (!ikonaOpen.value) return;
    const cilj = e?.target;
    if (cilj && ikonaMenu.value && (cilj === ikonaMenu.value || ikonaMenu.value.contains(cilj))) return;
    zatvoriIkonu();
};

onMounted(() => {
    document.addEventListener('click', onOutside, true);
    document.addEventListener('keydown', onEsc);
    window.addEventListener('scroll', onReflow, true);
    window.addEventListener('resize', onReflow);
});
onBeforeUnmount(() => {
    document.removeEventListener('click', onOutside, true);
    document.removeEventListener('keydown', onEsc);
    window.removeEventListener('scroll', onReflow, true);
    window.removeEventListener('resize', onReflow);
});

const submit = () => {
    if (isNew.value) {
        form.post('/administracija/kategorije', { preserveScroll: true });
    } else {
        form.put(`/administracija/kategorije/${props.kategorija.id}`, { preserveScroll: true });
    }
};

const obrisi = async () => {
    if (isNew.value) {
        router.visit('/administracija/kategorije');
        return;
    }
    if (props.kategorija?.brojStavki > 0) {
        await confirm({
            title: `„${labelDisplay.value}" se ne može obrisati`,
            message: `Kategorija sadrži ${props.kategorija.brojStavki} stavki. Premjestite ih prije brisanja.`,
            confirmLabel: 'U redu',
        });
        return;
    }
    const ok = await confirm({
        danger: true,
        title: `Obrisati „${labelDisplay.value}"?`,
        message: 'Kategorija se trajno briše.',
        confirmLabel: 'Obriši kategoriju',
    });
    if (!ok) return;
    router.delete(`/administracija/kategorije/${props.kategorija.id}`);
};
</script>

<template>
    <Head :title="isNew ? 'Nova kategorija' : `Uredi: ${labelDisplay}`" />

    <div class="space-y-5">
        <header class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-[22px] font-bold text-ink">{{ isNew ? 'Nova kategorija' : 'Uredi kategoriju' }}</h1>
                <span :style="tipStyle" class="inline-flex items-center rounded px-2.5 py-[3px] text-xs font-semibold">{{ tipLabel }}</span>
            </div>
            <div class="flex items-center gap-2.5">
                <div class="inline-flex items-center gap-1.5 rounded-lg border border-line bg-surface px-2 py-1">
                    <Languages :size="15" class="text-ink-3" />
                    <button
                        v-for="loc in locales"
                        :key="loc.code"
                        type="button"
                        class="rounded px-2 py-0.5 text-xs font-bold transition-colors"
                        :class="loc.code === activeLang ? 'bg-brand text-white' : 'text-ink-3 hover:text-ink'"
                        @click="activeLang = loc.code"
                    >
                        {{ loc.code.toUpperCase() }}
                    </button>
                </div>
                <Btn v-if="!isNew && imaJavnuStranicu" as="a" :href="javniUrl" target="_blank" variant="secondary" :icon="Eye">Na sajtu</Btn>
                <Btn variant="primary" :icon="Save" :disabled="form.processing" @click="submit">Sačuvaj</Btn>
            </div>
        </header>

        <div class="flex flex-col gap-5 lg:flex-row">
            <div class="flex-1 space-y-4">
                <Card title="Naziv kategorije">
                    <div class="space-y-3">
                        <FormField
                            :model-value="trGet(form.label)"
                            label="Naziv"
                            placeholder="npr. Hrana i piće"
                            :error="form.errors['label.sr']"
                            @update:model-value="trSet('label', $event)"
                        />

                        <div class="flex flex-wrap items-center gap-2 text-[13px]">
                            <template v-if="!editSlug">
                                <span class="text-ink-3">Slug ({{ activeLang.toUpperCase() }}):</span>
                                <span class="font-semibold text-ink-2">{{ effSlug }}</span>
                                <button type="button" class="rounded border border-line bg-surface-alt px-2 py-0.5 text-[11px] font-semibold text-ink-2 hover:bg-surface hover:text-ink" @click="editSlug = true">Uredi</button>
                            </template>
                            <template v-else>
                                <span class="text-ink-3">Slug ({{ activeLang.toUpperCase() }}):</span>
                                <input
                                    :value="slugForLang"
                                    type="text"
                                    :placeholder="slugPreview"
                                    class="h-7 w-52 rounded-md border border-line bg-surface px-2 text-[13px] text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20"
                                    @input="setSlug($event.target.value)"
                                />
                                <button type="button" class="rounded-md bg-brand px-2.5 py-1 text-[11px] font-semibold text-white hover:bg-brand-dark" @click="editSlug = false">Gotovo</button>
                            </template>
                            <span v-if="form.errors[`slug.${activeLang}`]" class="w-full text-xs text-bad">{{ form.errors[`slug.${activeLang}`] }}</span>
                        </div>

                        <p class="flex items-center gap-1.5 text-xs text-ink-3">
                            <Languages :size="14" />
                            Naziv i slug se prevode za svaki jezik - prebaci jezik gore desno.
                        </p>
                    </div>
                </Card>

                <Card title="Kratki opis">
                    <TextareaField
                        :model-value="trGet(form.opis)"
                        label="Opis"
                        :rows="3"
                        placeholder="Kratko objašnjenje kategorije prikazano na sajtu (opciono)."
                        :error="form.errors['opis.sr']"
                        @update:model-value="trSet('opis', $event)"
                    />
                </Card>
            </div>

            <div class="w-full space-y-4 lg:w-[340px] lg:shrink-0">
                <Card title="Tip sadržaja">
                    <div class="space-y-2">
                        <SelectField
                            :model-value="form.type"
                            :options="tipovi"
                            label="Pripada modulu"
                            @update:model-value="form.type = $event"
                        />
                        <p class="text-xs text-ink-3">Određuje gdje se kategorija pojavljuje na sajtu.</p>
                    </div>
                </Card>

                <Card title="Izgled">
                    <div class="space-y-3">
                        <div>
                            <p class="mb-2 text-[13px] font-semibold text-ink">Boja</p>
                            <div class="flex flex-wrap gap-2.5">
                                <button
                                    v-for="b in boje"
                                    :key="b"
                                    type="button"
                                    class="h-[26px] w-[26px] rounded-full transition-transform hover:scale-110"
                                    :style="{ backgroundColor: b, outline: form.color === b ? '2px solid #1D2327' : 'none', outlineOffset: '2px' }"
                                    @click="form.color = b"
                                />
                            </div>
                        </div>

                        <div>
                            <p class="mb-2 text-[13px] font-semibold text-ink">Ikona</p>
                            <button
                                ref="ikonaTrigger"
                                type="button"
                                class="flex h-10 w-full items-center gap-2 rounded border border-line bg-surface px-3 text-[13px] text-ink hover:bg-surface-alt"
                                @click="toggleIkona"
                            >
                                <component :is="resolveCategoryIcon(form.icon)" :size="16" :style="{ color: form.color }" />
                                <span>{{ form.icon }}</span>
                                <ChevronDown :size="16" class="ml-auto text-ink-3" :class="ikonaOpen ? 'rotate-180' : ''" />
                            </button>
                        </div>
                    </div>
                </Card>

                <Card title="Vidljivost">
                    <div class="space-y-3">
                        <ToggleField
                            :model-value="form.visible"
                            label="Prikaži u filterima na sajtu"
                            @update:model-value="form.visible = $event"
                        />
                        <p class="flex items-center gap-1.5 text-xs text-ink-3">
                            <GripVertical :size="14" />
                            Redoslijed se mijenja prevlačenjem redova u listi kategorija.
                        </p>
                    </div>
                </Card>

                <button
                    type="button"
                    class="flex w-full items-center justify-center gap-2 rounded-lg border border-line px-4 py-2.5 text-[13px] font-semibold text-bad hover:bg-bad-bg"
                    @click="obrisi"
                >
                    <Trash2 :size="16" />
                    {{ isNew ? 'Odustani' : 'Obriši kategoriju' }}
                </button>
            </div>
        </div>

        <Teleport to="body">
        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-if="ikonaOpen"
                ref="ikonaMenu"
                :style="{ top: ikonaPos.top + 'px', left: ikonaPos.left + 'px', width: ikonaPos.width + 'px' }"
                class="fixed z-[80] max-h-60 origin-top overflow-y-auto rounded-[var(--radius-card)] border border-line bg-surface py-1 shadow-[var(--shadow-pop)]"
            >
                <button
                    v-for="name in ICON_CHOICES"
                    :key="name"
                    type="button"
                    class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-[13px] hover:bg-surface-alt"
                    :class="form.icon === name ? 'text-brand' : 'text-ink-2'"
                    @click="izaberiIkonu(name)"
                >
                    <component :is="resolveCategoryIcon(name)" :size="16" :style="form.icon === name ? { color: form.color } : {}" />
                    <span>{{ name }}</span>
                    <Check v-if="form.icon === name" :size="15" class="ml-auto text-brand" />
                </button>
            </div>
        </transition>
        </Teleport>
    </div>
</template>
