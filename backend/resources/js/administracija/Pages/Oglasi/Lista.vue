<script setup>
import ResourceList from '../../components/ResourceList.vue';
import { Megaphone } from 'lucide-vue-next';
defineProps({ stavke: Object, filteri: Object, brojaci: Object, kategorije: Array });
</script>

<template>
    <ResourceList :stavke="stavke" :filteri="filteri" :brojaci="brojaci" :kategorije="kategorije"
        naslov="Oglasi" jednina="Oglas" baza="oglasi" :ikona="Megaphone" />
</template>
