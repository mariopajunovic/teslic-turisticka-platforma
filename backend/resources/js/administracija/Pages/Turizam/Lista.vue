<script setup>
import ResourceList from '../../components/ResourceList.vue';
import { Trees } from 'lucide-vue-next';
defineProps({ stavke: Object, filteri: Object, brojaci: Object, kategorije: Array });
</script>

<template>
    <ResourceList :stavke="stavke" :filteri="filteri" :brojaci="brojaci" :kategorije="kategorije"
        naslov="Turizam" jednina="Lokalitet" baza="turizam" :ikona="Trees" />
</template>
