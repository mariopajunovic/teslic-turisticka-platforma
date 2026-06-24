<script setup>
import PagePlaceholder from '@/components/common/PagePlaceholder.vue'
import { useTexts } from '@/composables/useTexts'

const t = useTexts()
</script>

<template>
  <PagePlaceholder :title="t('pridruzi_naslov', 'Pridruži se')" phase="Faza F10" />
</template>
