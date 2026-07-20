<script setup>
import { computed } from 'vue';
import Badge from './Badge.vue';

const props = defineProps({
    status: { type: String, default: 'nacrt' },
});

const MAPA = {
    nacrt: { label: 'Nacrt', color: 'gray' },
    poslano: { label: 'Na čekanju', color: 'warn' },
    odobreno: { label: 'Odobreno', color: 'ok' },
    objavljeno: { label: 'Objavljeno', color: 'ok' },
    odbijeno: { label: 'Odbijeno', color: 'bad' },
    arhivirano: { label: 'Arhivirano', color: 'gray' },
};

const meta = computed(() => MAPA[props.status] ?? MAPA.nacrt);
</script>

<template>
    <Badge :label="meta.label" :color="meta.color" />
</template>
