<script setup>
import { ref } from 'vue';
import { ImagePlus, Upload, Trash2, Loader2 } from 'lucide-vue-next';

const props = defineProps({
    modelValue: { type: String, default: '' },
    label: { type: String, default: null },
    required: { type: Boolean, default: false },
    hint: { type: String, default: null },
});

const emit = defineEmits(['update:modelValue']);

const fileInput = ref(null);
const uploading = ref(false);
const error = ref(null);

const pick = () => fileInput.value?.click();

const csrf = () => {
    const m = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]+)/);
    return m ? decodeURIComponent(m[1]) : '';
};

const onFile = async (e) => {
    const f = e.target.files?.[0];
    e.target.value = '';
    if (!f) return;

    error.value = null;
    uploading.value = true;

    try {
        const body = new FormData();
        body.append('file', f);
        const res = await fetch('/administracija/mediji', {
            method: 'POST',
            headers: { 'X-XSRF-TOKEN': csrf(), Accept: 'application/json' },
            body,
        });
        if (!res.ok) throw new Error('upload');
        const data = await res.json();
        emit('update:modelValue', data.url);
    } catch {
        error.value = 'Otpremanje nije uspjelo. Pokušajte ponovo.';
    } finally {
        uploading.value = false;
    }
};

const remove = () => emit('update:modelValue', '');
</script>

<template>
    <div>
        <p v-if="label" class="mb-1.5 text-sm font-medium text-ink">
            {{ label }}<span v-if="required" class="text-bad"> *</span>
        </p>

        <div class="flex items-center gap-4">
            <div class="flex h-16 w-24 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-line bg-surface-alt">
                <img v-if="modelValue" :src="modelValue" alt="" class="h-full w-full object-cover" />
                <ImagePlus v-else :size="20" class="text-ink-3" />
            </div>

            <div class="flex flex-col gap-1.5">
                <div class="flex items-center gap-2">
                    <button type="button" :disabled="uploading" class="inline-flex items-center gap-1.5 rounded-md border border-line bg-surface px-3 py-1.5 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt disabled:opacity-50" @click="pick">
                        <Loader2 v-if="uploading" :size="15" class="animate-spin" />
                        <Upload v-else :size="15" />
                        {{ modelValue ? 'Promijeni' : 'Otpremi sliku' }}
                    </button>
                    <button v-if="modelValue" type="button" class="inline-flex items-center gap-1.5 rounded-md border border-line bg-surface px-3 py-1.5 text-[13px] font-semibold text-bad hover:bg-bad-bg" @click="remove">
                        <Trash2 :size="15" /> Ukloni
                    </button>
                </div>
                <p v-if="error" class="text-xs text-bad">{{ error }}</p>
                <p v-else-if="hint" class="text-xs text-ink-3">{{ hint }}</p>
            </div>
        </div>

        <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onFile" />
    </div>
</template>
