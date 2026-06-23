<script setup>
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

defineProps({
  src: { type: String, default: '' },
  hint: { type: String, default: 'JPG ili PNG, do 2 MB' },
})
</script>

<template>
  <div class="flex items-center gap-4">
    <div class="flex size-18 items-center justify-center overflow-hidden rounded-full bg-primary-tint text-primary">
      <img v-if="src" :src="src" alt="" class="size-full object-cover" />
      <BaseIcon v-else name="user" :size="30" />
    </div>
    <div class="flex flex-col gap-1.5">
      <BaseButton variant="secondary" size="sm" icon="upload">Promijeni fotografiju</BaseButton>
      <p class="text-[13px] text-text-muted">{{ hint }}</p>
    </div>
  </div>
</template>
