<script setup>
import PagePlaceholder from '@/components/common/PagePlaceholder.vue'

const props = defineProps({
  doc: { type: String, default: 'privatnost' },
})

const naslovi = {
  privatnost: 'Politika privatnosti',
  kolacici: 'Politika kolačića',
  uslovi: 'Uslovi korištenja',
}
</script>

<template>
  <PagePlaceholder :title="naslovi[props.doc] || 'Pravne informacije'" phase="Pravne stranice" />
</template>
