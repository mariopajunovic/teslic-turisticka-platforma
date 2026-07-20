<script setup>
import { computed, ref } from 'vue';
import { Save, Send, Trash2, Radio, Eye, EyeOff, Calendar } from 'lucide-vue-next';
import Card from './Card.vue';
import SelectField from './SelectField.vue';

const props = defineProps({
    status: { type: String, default: 'nacrt' },
    statusi: { type: Array, default: () => [] },
    publishedAt: { type: String, default: null },
    rejectionReason: { type: String, default: null },
    saving: { type: Boolean, default: false },
    showTrash: { type: Boolean, default: true },
});

const emit = defineEmits(['update:status', 'save', 'trash']);

const objavljeno = computed(() => props.status === 'objavljeno');
const statusLabel = computed(() => props.statusi.find((s) => s.value === props.status)?.label ?? props.status);
const vidljivost = computed(() => (objavljeno.value ? 'Javno' : 'Skriveno'));
const objava = computed(() => props.publishedAt ?? 'Odmah po objavi');
const dugmeLabel = computed(() => (objavljeno.value ? 'Objavi' : 'Sačuvaj'));
const dugmeIkona = computed(() => (objavljeno.value ? Send : Save));

const menjamStatus = ref(false);
</script>

<template>
    <Card title="Objava" :padded="false">
        <div class="px-[18px] py-2.5">
            <div class="flex items-center justify-between gap-3 py-[7px]">
                <span class="flex items-center gap-2 text-[13px]">
                    <Radio :size="15" class="text-ink-3" />
                    <span class="text-ink-2">Status:</span>
                    <span class="font-semibold text-ink">{{ statusLabel }}</span>
                </span>
                <button type="button" class="text-[12px] font-semibold text-brand hover:underline" @click="menjamStatus = !menjamStatus">
                    {{ menjamStatus ? 'Gotovo' : 'Uredi' }}
                </button>
            </div>

            <div v-if="menjamStatus" class="pb-1 pt-1">
                <SelectField :model-value="status" :options="statusi" @update:model-value="emit('update:status', $event)" />
            </div>

            <div class="flex items-center justify-between gap-3 py-[7px]">
                <span class="flex items-center gap-2 text-[13px]">
                    <component :is="objavljeno ? Eye : EyeOff" :size="15" class="text-ink-3" />
                    <span class="text-ink-2">Vidljivost:</span>
                    <span class="font-semibold text-ink">{{ vidljivost }}</span>
                </span>
            </div>

            <div class="flex items-center justify-between gap-3 py-[7px]">
                <span class="flex items-center gap-2 text-[13px]">
                    <Calendar :size="15" class="text-ink-3" />
                    <span class="text-ink-2">Objaviti:</span>
                    <span class="font-semibold text-ink">{{ objava }}</span>
                </span>
            </div>

            <div v-if="rejectionReason" class="mt-1.5 rounded-md bg-bad-bg px-3 py-2">
                <p class="text-[11px] font-bold uppercase tracking-wide text-bad">Razlog odbijanja</p>
                <p class="mt-0.5 text-[13px] text-ink-2">{{ rejectionReason }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between gap-3 border-t border-line px-[18px] py-3">
            <button
                v-if="showTrash"
                type="button"
                class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-bad hover:underline"
                @click="emit('trash')"
            >
                <Trash2 :size="15" /> U smeće
            </button>
            <span v-else></span>

            <button
                type="button"
                :disabled="saving"
                class="inline-flex h-9 items-center gap-2 rounded-[var(--radius-card)] bg-brand px-4 text-sm font-semibold text-white transition-colors hover:bg-brand-dark disabled:opacity-50"
                @click="emit('save')"
            >
                <component :is="dugmeIkona" :size="16" /> {{ dugmeLabel }}
            </button>
        </div>
    </Card>
</template>
