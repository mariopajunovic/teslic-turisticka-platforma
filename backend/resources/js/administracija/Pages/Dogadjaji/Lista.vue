<script setup>
import ResourceList from '../../components/ResourceList.vue';
import { CalendarDays } from 'lucide-vue-next';
defineProps({ stavke: Object, filteri: Object, brojaci: Object, kategorije: Array });
</script>

<template>
    <ResourceList :stavke="stavke" :filteri="filteri" :brojaci="brojaci" :kategorije="kategorije"
        naslov="Događaji" jednina="Događaj" baza="dogadjaji" :ikona="CalendarDays" />
</template>
