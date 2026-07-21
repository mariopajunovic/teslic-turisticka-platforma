<script setup>
import { computed, ref, watch, onBeforeUnmount } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';
import { Bold, Italic, Heading2, Heading3, List, ListOrdered, Link2, Quote, ImagePlus, Undo2, Redo2, Loader2 } from 'lucide-vue-next';

const props = defineProps({
    modelValue: { type: Object, default: () => ({}) },
    label: { type: String, default: null },
    required: { type: Boolean, default: false },
    lang: { type: String, default: null },
    allowImage: { type: Boolean, default: true },
    uploadUrl: { type: String, default: '/administracija/mediji' },
});

const emit = defineEmits(['update:modelValue']);

const page = usePage();

const locales = computed(() => {
    const list = page.props?.locales;
    return Array.isArray(list) && list.length ? list : [{ code: 'sr', name: 'Srpski' }];
});

const internalActive = ref(locales.value[0]?.code ?? 'sr');
const active = computed(() => props.lang ?? internalActive.value);
const controlled = computed(() => props.lang !== null);

const filled = (code) => String(props.modelValue?.[code] ?? '').replace(/<[^>]*>/g, '').trim().length > 0;

let syncing = false;

const editor = useEditor({
    content: props.modelValue?.[active.value] ?? '',
    extensions: [
        StarterKit.configure({ heading: { levels: [2, 3] } }),
        Link.configure({ openOnClick: false, autolink: true }),
        Image.configure({ inline: false, HTMLAttributes: { class: 'rtf-img' } }),
    ],
    editorProps: {
        attributes: {
            class: 'rtf max-w-none min-h-[180px] px-3.5 py-3 focus:outline-none',
        },
    },
    onUpdate: ({ editor }) => {
        if (syncing) return;
        const html = editor.isEmpty ? '' : editor.getHTML();
        emit('update:modelValue', { ...props.modelValue, [active.value]: html });
    },
});

const swapTo = (code) => {
    if (!editor.value) return;
    syncing = true;
    editor.value.commands.setContent(props.modelValue?.[code] ?? '', false);
    syncing = false;
};

watch(active, (code) => swapTo(code));

watch(() => props.modelValue?.[active.value], (val) => {
    if (!editor.value || syncing) return;
    const current = editor.value.isEmpty ? '' : editor.value.getHTML();
    if ((val ?? '') !== current) swapTo(active.value);
});

onBeforeUnmount(() => editor.value?.destroy());

const setLink = () => {
    if (!editor.value) return;
    const prev = editor.value.getAttributes('link').href ?? '';
    const url = window.prompt('Unesi URL linka:', prev);
    if (url === null) return;
    if (url === '') {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run();
        return;
    }
    editor.value.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
};

const csrf = () => {
    const m = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]+)/);
    return m ? decodeURIComponent(m[1]) : '';
};

const slikaInput = ref(null);
const uploadingSlika = ref(false);

const pickSlika = () => slikaInput.value?.click();

const onSlika = async (e) => {
    const f = e.target.files?.[0];
    e.target.value = '';
    if (!f || !editor.value) return;

    uploadingSlika.value = true;
    try {
        const body = new FormData();
        body.append('file', f);
        const res = await fetch(props.uploadUrl, {
            method: 'POST',
            headers: { 'X-XSRF-TOKEN': csrf(), Accept: 'application/json' },
            body,
        });
        if (!res.ok) throw new Error('upload');
        const data = await res.json();
        editor.value.chain().focus().setImage({ src: data.url }).run();
    } catch {
        window.alert('Otpremanje slike nije uspjelo.');
    } finally {
        uploadingSlika.value = false;
    }
};

const is = (name, attrs) => editor.value?.isActive(name, attrs) ?? false;

const tools = computed(() => [
    { icon: Bold, title: 'Podebljano', run: () => editor.value?.chain().focus().toggleBold().run(), active: is('bold') },
    { icon: Italic, title: 'Kurziv', run: () => editor.value?.chain().focus().toggleItalic().run(), active: is('italic') },
    { icon: Heading2, title: 'Naslov 2', run: () => editor.value?.chain().focus().toggleHeading({ level: 2 }).run(), active: is('heading', { level: 2 }) },
    { icon: Heading3, title: 'Naslov 3', run: () => editor.value?.chain().focus().toggleHeading({ level: 3 }).run(), active: is('heading', { level: 3 }) },
    { icon: List, title: 'Lista', run: () => editor.value?.chain().focus().toggleBulletList().run(), active: is('bulletList') },
    { icon: ListOrdered, title: 'Numerisana lista', run: () => editor.value?.chain().focus().toggleOrderedList().run(), active: is('orderedList') },
    { icon: Quote, title: 'Citat', run: () => editor.value?.chain().focus().toggleBlockquote().run(), active: is('blockquote') },
    { icon: Link2, title: 'Link', run: setLink, active: is('link') },
]);
</script>

<template>
    <div>
        <div v-if="label || !controlled" class="mb-1.5 flex items-center justify-between gap-2">
            <label v-if="label" class="block text-sm font-medium text-ink">
                {{ label }}<span v-if="required" class="text-bad"> *</span>
            </label>
            <div v-if="!controlled" class="flex items-center gap-1">
                <button
                    v-for="loc in locales"
                    :key="loc.code"
                    type="button"
                    :class="loc.code === active ? 'bg-brand text-white' : 'text-ink-3 hover:bg-surface-alt hover:text-ink'"
                    class="inline-flex items-center gap-1 rounded px-1.5 py-0.5 text-[11px] font-bold uppercase"
                    @click="internalActive = loc.code"
                >
                    {{ loc.code }}
                    <span :class="filled(loc.code) ? 'bg-ok' : (loc.code === active ? 'bg-white/40' : 'bg-line-strong')" class="h-1.5 w-1.5 rounded-full"></span>
                </button>
            </div>
        </div>

        <div class="overflow-hidden rounded-md border border-line bg-surface focus-within:border-brand focus-within:ring-2 focus-within:ring-brand/20">
            <div class="flex flex-wrap items-center gap-0.5 border-b border-line bg-surface-alt px-1.5 py-1">
                <button
                    v-for="(t, i) in tools"
                    :key="i"
                    type="button"
                    :title="t.title"
                    :class="t.active ? 'bg-brand text-white' : 'text-ink-2 hover:bg-surface hover:text-ink'"
                    class="inline-flex h-7 w-7 items-center justify-center rounded"
                    @mousedown.prevent
                    @click="t.run"
                >
                    <component :is="t.icon" :size="15" />
                </button>
                <template v-if="allowImage">
                    <div class="mx-1 h-4 w-px bg-line"></div>
                    <button type="button" title="Ubaci sliku" class="inline-flex h-7 w-7 items-center justify-center rounded text-ink-2 hover:bg-surface hover:text-ink disabled:opacity-50" :disabled="uploadingSlika" @mousedown.prevent @click="pickSlika">
                        <Loader2 v-if="uploadingSlika" :size="15" class="animate-spin" />
                        <ImagePlus v-else :size="15" />
                    </button>
                </template>
                <div class="mx-1 h-4 w-px bg-line"></div>
                <button type="button" title="Poništi" class="inline-flex h-7 w-7 items-center justify-center rounded text-ink-2 hover:bg-surface hover:text-ink" @mousedown.prevent @click="editor?.chain().focus().undo().run()">
                    <Undo2 :size="15" />
                </button>
                <button type="button" title="Ponovi" class="inline-flex h-7 w-7 items-center justify-center rounded text-ink-2 hover:bg-surface hover:text-ink" @mousedown.prevent @click="editor?.chain().focus().redo().run()">
                    <Redo2 :size="15" />
                </button>
            </div>
            <EditorContent :editor="editor" />
            <input ref="slikaInput" type="file" accept="image/*" class="hidden" @change="onSlika" />
        </div>
    </div>
</template>
