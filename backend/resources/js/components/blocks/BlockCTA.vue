<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import CTASection from '@/components/common/CTASection.vue'
import BaseButton from '@/components/base/BaseButton.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="my-14">
    <CTASection :title="data.title || ''" :text="data.text || ''">
      <BaseButton
        v-for="(b, i) in data.buttons || []"
        :key="i"
        :to="b.url || '#'"
        :variant="b.variant || 'sekundarna'"
      >
        {{ b.label }}
      </BaseButton>
    </CTASection>
  </AppContainer>
</template>
