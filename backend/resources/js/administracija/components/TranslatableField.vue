<script setup>
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    modelValue: { type: Object, default: () => ({}) },
    label: { type: String, default: null },
    type: { type: String, default: 'text' },
    placeholder: { type: String, default: null },
    hint: { type: String, default: null },
    required: { type: Boolean, default: false },
    rows: { type: Number, default: 3 },
    errors: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['update:modelValue']);

const page = usePage();

const locales = computed(() => {
    const list = page.props?.locales;
    return Array.isArray(list) && list.length ? list : [{ code: 'sr', name: 'Srpski' }];
});

const active = ref(locales.value[0]?.code ?? 'sr');

const current = computed(() => props.modelValue?.[active.value] ?? '');

const filled = (code) => String(props.modelValue?.[code] ?? '').trim().length > 0;

const setValue = (val) => {
    emit('update:modelValue', { ...props.modelValue, [active.value]: val });
};
</script>

<template>
    <div>
        <div v-if="label" class="mb-1.5 flex items-center justify-between gap-2">
            <label class="block text-sm font-medium text-ink">
                {{ label }}<span v-if="required" class="text-bad"> *</span>
            </label>
            <div class="flex items-center gap-1">
                <button
                    v-for="loc in locales"
                    :key="loc.code"
                    type="button"
                    :class="loc.code === active
                        ? 'bg-brand text-white'
                        : 'text-ink-3 hover:bg-surface-alt hover:text-ink'"
                    class="inline-flex items-center gap-1 rounded px-1.5 py-0.5 text-[11px] font-bold uppercase"
                    @click="active = loc.code"
                >
                    {{ loc.code }}
                    <span
                        :class="filled(loc.code) ? 'bg-ok' : (loc.code === active ? 'bg-white/40' : 'bg-line-strong')"
                        class="h-1.5 w-1.5 rounded-full"
                    ></span>
                </button>
            </div>
        </div>

        <textarea
            v-if="type === 'textarea'"
            :value="current"
            :rows="rows"
            :placeholder="placeholder"
            :class="errors[active] ? 'border-bad focus:border-bad focus:ring-bad/20' : 'border-line focus:border-brand focus:ring-brand/20'"
            class="w-full rounded-md border bg-surface px-3 py-2 text-[13px] text-ink placeholder:text-ink-3 focus:outline-none focus:ring-2"
            @input="setValue($event.target.value)"
        ></textarea>
        <input
            v-else
            :value="current"
            type="text"
            :placeholder="placeholder"
            :class="errors[active] ? 'border-bad focus:border-bad focus:ring-bad/20' : 'border-line focus:border-brand focus:ring-brand/20'"
            class="h-10 w-full rounded-md border bg-surface px-3 text-[13px] text-ink placeholder:text-ink-3 focus:outline-none focus:ring-2"
            @input="setValue($event.target.value)"
        />

        <p v-if="errors[active]" class="mt-1 text-xs text-bad">{{ errors[active] }}</p>
        <p v-else-if="hint" class="mt-1 text-xs text-ink-3">{{ hint }}</p>
    </div>
</template>
