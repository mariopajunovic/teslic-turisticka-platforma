<script setup>
import ResourceList from '../../components/ResourceList.vue';
import { FileText } from 'lucide-vue-next';
defineProps({ stavke: Object, filteri: Object, brojaci: Object, kategorije: Array });
</script>

<template>
    <ResourceList :stavke="stavke" :filteri="filteri" :brojaci="brojaci" :kategorije="kategorije"
        naslov="Javne nabavke" jednina="Javna nabavka" baza="nabavke" :ikona="FileText" :has-category="false" />
</template>
