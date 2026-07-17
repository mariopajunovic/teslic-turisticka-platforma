<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { Camera, Trash2, X, ImagePlus } from 'lucide-vue-next';

const props = defineProps({
    src: { type: String, default: null },
    uploadUrl: { type: String, required: true },
    deleteUrl: { type: String, default: null },
    label: { type: String, default: null },
    hint: { type: String, default: null },
    aspect: { type: [Number, String], default: 1 },
    shape: { type: String, default: 'circle' },
    outputWidth: { type: Number, default: 512 },
    outputType: { type: String, default: 'image/jpeg' },
    field: { type: String, default: 'image' },
});

const VIEW_W = 320;

const fileInput = ref(null);
const cropping = ref(false);
const uploading = ref(false);
const imageSrc = ref(null);
const natural = ref({ w: 0, h: 0 });
const zoom = ref(1);
const pos = ref({ x: 0, y: 0 });

const effAspect = computed(() => (props.aspect === 'auto' && natural.value.w)
    ? natural.value.w / natural.value.h
    : (Number(props.aspect) || 1));
const viewH = computed(() => Math.round(VIEW_W / effAspect.value));
const outH = computed(() => Math.round(props.outputWidth / effAspect.value));
const baseScale = computed(() => (natural.value.w ? Math.max(VIEW_W / natural.value.w, viewH.value / natural.value.h) : 1));
const scale = computed(() => baseScale.value * zoom.value);
const dispW = computed(() => natural.value.w * scale.value);
const dispH = computed(() => natural.value.h * scale.value);
const rounded = computed(() => (props.shape === 'circle' ? 'rounded-full' : 'rounded-lg'));

const minZoom = computed(() => {
    if (!natural.value.w) return 0.3;
    const cover = Math.max(VIEW_W / natural.value.w, viewH.value / natural.value.h);
    const contain = Math.min(VIEW_W / natural.value.w, viewH.value / natural.value.h);
    return (contain / cover) * 0.3;
});

const clamp = () => {
    if (dispW.value <= VIEW_W) {
        pos.value.x = (VIEW_W - dispW.value) / 2;
    } else {
        pos.value.x = Math.min(0, Math.max(VIEW_W - dispW.value, pos.value.x));
    }

    if (dispH.value <= viewH.value) {
        pos.value.y = (viewH.value - dispH.value) / 2;
    } else {
        pos.value.y = Math.min(0, Math.max(viewH.value - dispH.value, pos.value.y));
    }
};

const pick = () => fileInput.value?.click();

const onFile = (e) => {
    const f = e.target.files?.[0];
    if (!f) return;
    const reader = new FileReader();
    reader.onload = () => {
        const img = new Image();
        img.onload = () => {
            imageSrc.value = reader.result;
            natural.value = { w: img.naturalWidth, h: img.naturalHeight };
            zoom.value = 1;
            const b = Math.max(VIEW_W / img.naturalWidth, viewH.value / img.naturalHeight);
            pos.value = { x: (VIEW_W - b * img.naturalWidth) / 2, y: (viewH.value - b * img.naturalHeight) / 2 };
            cropping.value = true;
        };
        img.src = reader.result;
    };
    reader.readAsDataURL(f);
    e.target.value = '';
};

let dragging = false;
let last = { x: 0, y: 0 };
const point = (e) => {
    const t = e.touches?.[0];
    return { x: t ? t.clientX : e.clientX, y: t ? t.clientY : e.clientY };
};
const down = (e) => { dragging = true; last = point(e); };
const move = (e) => {
    if (!dragging) return;
    const p = point(e);
    pos.value.x += p.x - last.x;
    pos.value.y += p.y - last.y;
    last = p;
    clamp();
};
const up = () => { dragging = false; };

const save = () => {
    const img = new Image();
    img.onload = () => {
        const canvas = document.createElement('canvas');
        canvas.width = props.outputWidth;
        canvas.height = outH.value;
        const ctx = canvas.getContext('2d');
        const k = props.outputWidth / VIEW_W;
        const isPng = props.outputType === 'image/png';
        if (!isPng) {
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }
        ctx.drawImage(img, pos.value.x * k, pos.value.y * k, dispW.value * k, dispH.value * k);
        canvas.toBlob((blob) => {
            const file = new File([blob], isPng ? 'slika.png' : 'slika.jpg', { type: props.outputType });
            uploading.value = true;
            router.post(props.uploadUrl, { [props.field]: file }, {
                forceFormData: true,
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => { cropping.value = false; },
                onFinish: () => { uploading.value = false; },
            });
        }, props.outputType, 0.92);
    };
    img.src = imageSrc.value;
};

const remove = () => {
    if (props.deleteUrl) router.delete(props.deleteUrl, { preserveScroll: true, preserveState: true });
};
</script>

<template>
    <div>
        <p v-if="label" class="mb-1.5 text-sm font-medium text-ink">{{ label }}</p>

        <div class="flex items-center gap-4">
            <div
                v-if="shape === 'circle'"
                class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full border border-line bg-surface-alt"
            >
                <img v-if="src" :src="src" alt="" class="h-full w-full object-cover" />
                <ImagePlus v-else :size="22" class="text-ink-3" />
            </div>
            <div
                v-else
                class="flex h-16 min-w-[96px] max-w-[240px] shrink-0 items-center justify-center overflow-hidden rounded-lg border border-line bg-surface-alt px-2"
            >
                <img v-if="src" :src="src" alt="" class="max-h-full w-auto object-contain" />
                <ImagePlus v-else :size="22" class="text-ink-3" />
            </div>

            <div class="flex flex-col gap-1.5">
                <div class="flex items-center gap-2">
                    <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-line bg-surface px-3 py-1.5 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt" @click="pick">
                        <Camera :size="15" /> {{ src ? 'Promijeni' : 'Dodaj sliku' }}
                    </button>
                    <button v-if="src && deleteUrl" type="button" class="inline-flex items-center gap-1.5 rounded-md border border-line bg-surface px-3 py-1.5 text-[13px] font-semibold text-bad hover:bg-bad-bg" @click="remove">
                        <Trash2 :size="15" /> Ukloni
                    </button>
                </div>
                <p v-if="hint" class="text-xs text-ink-3">{{ hint }}</p>
            </div>
        </div>

        <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onFile" />

        <Teleport to="body">
            <div
                v-if="cropping"
                class="fixed inset-0 z-[80] flex items-center justify-center p-4"
                @mousemove="move"
                @mouseup="up"
                @mouseleave="up"
                @touchmove.prevent="move"
                @touchend="up"
            >
                <div class="absolute inset-0 bg-[#0f172a]/50" @click="cropping = false"></div>
                <div class="relative w-full max-w-[380px] rounded-xl border border-line bg-surface p-5 shadow-[var(--shadow-pop)]">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-[15px] font-bold text-ink">Prilagodi sliku</h3>
                        <button type="button" class="text-ink-3 hover:text-ink" @click="cropping = false"><X :size="18" /></button>
                    </div>

                    <div class="flex justify-center">
                        <div
                            :class="rounded"
                            :style="{ width: `${VIEW_W}px`, height: `${viewH}px` }"
                            class="relative cursor-move touch-none select-none overflow-hidden border border-line bg-surface-alt"
                            @mousedown.prevent="down"
                            @touchstart.prevent="down"
                        >
                            <img
                                :src="imageSrc"
                                alt=""
                                draggable="false"
                                class="pointer-events-none absolute max-w-none"
                                :style="{ left: `${pos.x}px`, top: `${pos.y}px`, width: `${dispW}px`, height: `${dispH}px` }"
                            />
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-3">
                        <span class="text-xs text-ink-3">Zoom</span>
                        <input v-model.number="zoom" type="range" :min="minZoom" max="3" step="0.01" class="flex-1 accent-brand" @input="clamp" />
                    </div>

                    <div class="mt-5 flex justify-end gap-2">
                        <button type="button" class="rounded-md border border-line bg-surface px-4 py-2 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt" @click="cropping = false">Odustani</button>
                        <button type="button" :disabled="uploading" class="rounded-md bg-brand px-4 py-2 text-[13px] font-semibold text-white hover:bg-brand-dark disabled:opacity-50" @click="save">Sačuvaj sliku</button>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>
