<script setup>
import ResourceList from '../../components/ResourceList.vue';
import { BookOpen } from 'lucide-vue-next';
defineProps({ stavke: Object, filteri: Object, brojaci: Object, kategorije: Array });
</script>

<template>
    <ResourceList :stavke="stavke" :filteri="filteri" :brojaci="brojaci" :kategorije="kategorije"
        naslov="Priče" jednina="Priča" baza="price" :ikona="BookOpen" />
</template>
