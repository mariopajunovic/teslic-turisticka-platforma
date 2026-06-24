<script setup>
// Drag&drop upload zona (1:1 Upload iz 11_AuthFoundations).
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  title: { type: String, default: 'Prevucite fotografije ili kliknite za odabir' },
  hint: { type: String, default: 'JPG ili PNG, do 5 MB po fotografiji' },
  icon: { type: String, default: 'image' },
})
</script>

<template>
  <div
    class="flex flex-col items-center justify-center gap-2.5 rounded-md border border-dashed border-border bg-surface p-7 text-center"
  >
    <span class="flex size-12 items-center justify-center rounded-full bg-primary-tint text-primary">
      <BaseIcon :name="icon" :size="22" />
    </span>
    <p class="text-[15px] font-semibold text-heading">{{ title }}</p>
    <p class="text-[13px] text-text-muted">{{ hint }}</p>
  </div>
</template>
