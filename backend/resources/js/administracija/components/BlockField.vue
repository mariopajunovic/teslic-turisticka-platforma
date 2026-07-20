<script setup>
import { computed, ref } from 'vue';
import { Plus, Trash2, GripVertical } from 'lucide-vue-next';
import FormField from './FormField.vue';
import TextareaField from './TextareaField.vue';
import SelectField from './SelectField.vue';
import BaseIcon from '@/components/base/BaseIcon.vue';
import ToggleField from './ToggleField.vue';
import RichTextField from './RichTextField.vue';
import BlockImageField from './BlockImageField.vue';
import { icons } from '@/constants/icons';

const props = defineProps({
    field: { type: Object, required: true },
    modelValue: { default: null },
    lang: { type: String, default: 'sr' },
    ciljevi: { type: Object, default: () => ({ stranice: [], kategorije: [] }) },
    paleta: { type: Array, default: () => [] },
});

const emit = defineEmits(['update:modelValue']);

const set = (val) => emit('update:modelValue', val);

const trValue = computed(() => (props.modelValue && typeof props.modelValue === 'object' ? props.modelValue[props.lang] ?? '' : ''));
const setTr = (val) => set({ ...(props.modelValue && typeof props.modelValue === 'object' ? props.modelValue : {}), [props.lang]: val });

const ikoneOtvoren = ref(false);
const ikoneLista = Object.keys(icons);

const cilj = computed(() => (props.modelValue && typeof props.modelValue === 'object' && !Array.isArray(props.modelValue))
    ? props.modelValue
    : { type: 'page', id: '', url: '' });

const postaviCilj = (patch) => set({ ...cilj.value, ...patch });

const ciljOpcije = computed(() => (cilj.value.type === 'category'
    ? (props.ciljevi.kategorije || [])
    : (props.ciljevi.stranice || [])));

const selectOptions = computed(() =>
    Object.entries(props.field.options ?? {}).map(([value, label]) => ({ value, label })),
);

const items = computed(() => (Array.isArray(props.modelValue) ? props.modelValue : []));

const blankItem = () => {
    const item = {};
    for (const sub of props.field.fields ?? []) {
        item[sub.name] = sub.type === 'toggle'
            ? false
            : sub.type === 'select'
                ? (Object.keys(sub.options ?? {})[0] ?? null)
                : sub.tr
                    ? null
                    : '';
    }
    return item;
};

const addItem = () => set([...items.value, blankItem()]);
const removeItem = (i) => set(items.value.filter((_, idx) => idx !== i));
const setItemField = (i, name, val) => set(items.value.map((it, idx) => (idx === i ? { ...it, [name]: val } : it)));

const dragIdx = ref(null);
const overIdx = ref(null);

const onDragStart = (e, i) => {
    dragIdx.value = i;
    if (e.dataTransfer) {
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', String(i));
    }
};

const onDrop = (target) => {
    const from = dragIdx.value;
    dragIdx.value = null;
    overIdx.value = null;
    if (from === null || from === target) return;
    const next = [...items.value];
    const [moved] = next.splice(from, 1);
    next.splice(target, 0, moved);
    set(next);
};

const itemTitle = (item, i) => {
    const first = (props.field.fields ?? [])[0];
    if (!first) return `Stavka ${i + 1}`;
    const v = item?.[first.name];
    const text = first.tr ? (v?.[props.lang] ?? v?.sr ?? '') : v;
    return String(text || '').trim() || `Stavka ${i + 1}`;
};
</script>

<template>
    <FormField
        v-if="field.tr && field.type === 'text'"
        :model-value="trValue"
        :label="field.label"
        :required="field.required"
        @update:model-value="setTr"
    />

    <TextareaField
        v-else-if="field.tr && field.type === 'textarea'"
        :model-value="trValue"
        :label="field.label"
        :required="field.required"
        @update:model-value="setTr"
    />

    <div v-else-if="field.type === 'icon'">
        <label class="mb-1.5 block text-sm font-medium text-ink">{{ field.label }}</label>
        <button
            type="button"
            class="flex h-10 w-full items-center gap-2 rounded-[var(--radius-card)] border border-line bg-surface px-3 text-sm text-ink hover:bg-surface-alt"
            @click="ikoneOtvoren = !ikoneOtvoren"
        >
            <BaseIcon v-if="modelValue" :name="modelValue" :size="17" />
            <span>{{ modelValue || 'Izaberi ikonu' }}</span>
        </button>
        <div v-if="ikoneOtvoren" class="mt-2 grid max-h-52 grid-cols-8 gap-1 overflow-y-auto rounded-[var(--radius-card)] border border-line bg-surface p-2">
            <button
                v-for="ime in ikoneLista"
                :key="ime"
                type="button"
                :title="ime"
                class="flex h-8 items-center justify-center rounded hover:bg-surface-alt"
                :class="modelValue === ime ? 'bg-brand/10 text-brand' : 'text-ink-2'"
                @click="set(ime); ikoneOtvoren = false"
            >
                <BaseIcon :name="ime" :size="17" />
            </button>
        </div>
    </div>

    <div v-else-if="field.type === 'color'">
        <label class="mb-1.5 block text-sm font-medium text-ink">{{ field.label }}</label>
        <div class="flex flex-wrap items-center gap-2">
            <button
                v-for="b in paleta"
                :key="b.value"
                type="button"
                :title="b.label"
                class="h-7 w-7 rounded-full transition-transform hover:scale-110"
                :style="{ backgroundColor: b.value, outline: modelValue === b.value ? '2px solid #1D2327' : 'none', outlineOffset: '2px' }"
                @click="set(b.value)"
            />
            <button type="button" class="text-xs font-semibold text-ink-3 hover:text-ink" @click="set('')">Poništi</button>
        </div>
    </div>

    <div v-else-if="field.type === 'target'" class="space-y-2">
        <label class="block text-sm font-medium text-ink">{{ field.label }}</label>
        <SelectField
            :model-value="cilj.type"
            :options="[
                { value: 'page', label: 'Stranica' },
                { value: 'category', label: 'Kategorija' },
                { value: 'external', label: 'Vanjski link' },
            ]"
            @update:model-value="postaviCilj({ type: $event, id: '' })"
        />
        <SelectField
            v-if="cilj.type !== 'external'"
            :model-value="cilj.id ?? ''"
            :options="ciljOpcije"
            placeholder="Izaberi…"
            @update:model-value="postaviCilj({ id: $event })"
        />
        <FormField
            v-else
            :model-value="cilj.url ?? ''"
            placeholder="https://…"
            @update:model-value="postaviCilj({ url: $event })"
        />
    </div>

    <RichTextField
        v-else-if="field.type === 'richtext'"
        :model-value="modelValue ?? {}"
        :label="field.label"
        :required="field.required"
        :lang="lang"
        @update:model-value="set"
    />

    <BlockImageField
        v-else-if="field.type === 'image'"
        :model-value="modelValue ?? ''"
        :label="field.label"
        :required="field.required"
        @update:model-value="set"
    />

    <SelectField
        v-else-if="field.type === 'select'"
        :model-value="modelValue ?? ''"
        :label="field.label"
        :options="selectOptions"
        :required="field.required"
        @update:model-value="set"
    />

    <ToggleField
        v-else-if="field.type === 'toggle'"
        :model-value="!!modelValue"
        :label="field.label"
        @update:model-value="set"
    />

    <TextareaField
        v-else-if="field.type === 'textarea'"
        :model-value="modelValue ?? ''"
        :label="field.label"
        :required="field.required"
        @update:model-value="set"
    />

    <div v-else-if="field.type === 'repeater'">
        <p class="mb-1.5 text-sm font-medium text-ink">{{ field.label }}</p>
        <div class="space-y-2.5">
            <div
                v-for="(item, i) in items"
                :key="i"
                :class="overIdx === i && dragIdx !== null ? 'border-brand' : 'border-line'"
                class="rounded-lg border bg-surface-alt/40 p-3"
                @dragover.prevent="overIdx = i"
                @drop="onDrop(i)"
            >
                <div class="mb-2.5 flex items-center gap-2">
                    <span
                        class="shrink-0 cursor-grab text-ink-3 hover:text-ink active:cursor-grabbing"
                        draggable="true"
                        title="Prevuci"
                        @dragstart="onDragStart($event, i)"
                        @dragend="dragIdx = null; overIdx = null"
                    >
                        <GripVertical :size="16" />
                    </span>
                    <span class="min-w-0 flex-1 truncate text-[13px] font-semibold text-ink-2">{{ itemTitle(item, i) }}</span>
                    <button type="button" title="Ukloni" class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-bad hover:bg-bad-bg" @click="removeItem(i)">
                        <Trash2 :size="15" />
                    </button>
                </div>
                <div class="space-y-3">
                    <BlockField
                        v-for="sub in field.fields"
                        :key="sub.name"
                        :field="sub"
                        :model-value="item[sub.name]"
                        :lang="lang"
                        :ciljevi="ciljevi"
                        :paleta="paleta"
                        @update:model-value="setItemField(i, sub.name, $event)"
                    />
                </div>
            </div>
        </div>
        <button type="button" class="mt-2.5 inline-flex items-center gap-1.5 rounded-md border border-line-strong bg-surface px-3 py-2 text-[13px] font-semibold text-ink-2 hover:border-brand hover:text-brand" @click="addItem">
            <Plus :size="15" /> Dodaj stavku
        </button>
    </div>

    <FormField
        v-else
        :model-value="modelValue ?? ''"
        :label="field.label"
        :type="field.type === 'number' ? 'number' : 'text'"
        :required="field.required"
        @update:model-value="set"
    />
</template>
