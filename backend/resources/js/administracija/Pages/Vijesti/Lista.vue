<script setup>
import ResourceList from '../../components/ResourceList.vue';
import { Newspaper } from 'lucide-vue-next';
defineProps({ stavke: Object, filteri: Object, brojaci: Object, kategorije: Array });
</script>

<template>
    <ResourceList :stavke="stavke" :filteri="filteri" :brojaci="brojaci" :kategorije="kategorije"
        naslov="Vijesti" jednina="Vijest" baza="vijesti" :ikona="Newspaper" :has-category="false" />
</template>
