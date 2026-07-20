<script setup>
import { ref, computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { X } from 'lucide-vue-next';

const props = defineProps({
    src: { type: String, required: true },
    saveUrl: { type: String, required: true },
    aspect: { type: Number, default: 4 / 3 },
    outputWidth: { type: Number, default: 1280 },
});

const emit = defineEmits(['close', 'saved']);

const VIEW_W = 360;

const natural = ref({ w: 0, h: 0 });
const zoom = ref(1);
const pos = ref({ x: 0, y: 0 });
const ready = ref(false);
const saving = ref(false);

const viewH = computed(() => Math.round(VIEW_W / props.aspect));
const outH = computed(() => Math.round(props.outputWidth / props.aspect));
const baseScale = computed(() => (natural.value.w ? Math.max(VIEW_W / natural.value.w, viewH.value / natural.value.h) : 1));
const scale = computed(() => baseScale.value * zoom.value);
const dispW = computed(() => natural.value.w * scale.value);
const dispH = computed(() => natural.value.h * scale.value);

const clamp = () => {
    pos.value.x = dispW.value <= VIEW_W ? (VIEW_W - dispW.value) / 2 : Math.min(0, Math.max(VIEW_W - dispW.value, pos.value.x));
    pos.value.y = dispH.value <= viewH.value ? (viewH.value - dispH.value) / 2 : Math.min(0, Math.max(viewH.value - dispH.value, pos.value.y));
};

onMounted(() => {
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => {
        natural.value = { w: img.naturalWidth, h: img.naturalHeight };
        zoom.value = 1;
        const b = Math.max(VIEW_W / img.naturalWidth, viewH.value / img.naturalHeight);
        pos.value = { x: (VIEW_W - b * img.naturalWidth) / 2, y: (viewH.value - b * img.naturalHeight) / 2 };
        ready.value = true;
    };
    img.src = props.src;
});

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
    img.crossOrigin = 'anonymous';
    img.onload = () => {
        const canvas = document.createElement('canvas');
        canvas.width = props.outputWidth;
        canvas.height = outH.value;
        const ctx = canvas.getContext('2d');
        const k = props.outputWidth / VIEW_W;
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, pos.value.x * k, pos.value.y * k, dispW.value * k, dispH.value * k);
        canvas.toBlob((blob) => {
            const file = new File([blob], 'slika.jpg', { type: 'image/jpeg' });
            saving.value = true;
            router.post(props.saveUrl, { image: file }, {
                forceFormData: true,
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => emit('saved'),
                onFinish: () => { saving.value = false; },
            });
        }, 'image/jpeg', 0.92);
    };
    img.src = props.src;
};
</script>

<template>
    <Teleport to="body">
        <div
            class="fixed inset-0 z-[80] flex items-center justify-center p-4"
            @mousemove="move"
            @mouseup="up"
            @mouseleave="up"
            @touchmove.prevent="move"
            @touchend="up"
        >
            <div class="absolute inset-0 bg-[#0f172a]/60" @click="emit('close')"></div>
            <div class="relative w-full max-w-[420px] rounded-xl border border-line bg-surface p-5 shadow-[var(--shadow-pop)]">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-[15px] font-bold text-ink">Uredi fotografiju</h3>
                    <button type="button" class="text-ink-3 hover:text-ink" @click="emit('close')"><X :size="18" /></button>
                </div>

                <div class="flex justify-center">
                    <div
                        :style="{ width: `${VIEW_W}px`, height: `${viewH}px` }"
                        class="relative cursor-move touch-none select-none overflow-hidden rounded-lg border border-line bg-surface-alt"
                        @mousedown.prevent="down"
                        @touchstart.prevent="down"
                    >
                        <img
                            v-if="ready"
                            :src="src"
                            alt=""
                            draggable="false"
                            class="pointer-events-none absolute max-w-none"
                            :style="{ left: `${pos.x}px`, top: `${pos.y}px`, width: `${dispW}px`, height: `${dispH}px` }"
                        />
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-3">
                    <span class="text-xs text-ink-3">Zoom</span>
                    <input v-model.number="zoom" type="range" min="1" max="3" step="0.01" class="flex-1 accent-brand" @input="clamp" />
                </div>

                <div class="mt-5 flex justify-end gap-2">
                    <button type="button" class="rounded-md border border-line bg-surface px-4 py-2 text-[13px] font-semibold text-ink-2 hover:bg-surface-alt" @click="emit('close')">Odustani</button>
                    <button type="button" :disabled="saving || !ready" class="rounded-md bg-brand px-4 py-2 text-[13px] font-semibold text-white hover:bg-brand-dark disabled:opacity-50" @click="save">Sačuvaj</button>
                </div>
            </div>
        </div>
    </Teleport>
</template>
