<script setup>
// Centrirani kontejner sadržaja: max 1200px, bočni padding 24/16.
defineProps({
  as: { type: String, default: 'div' },
})
</script>

<template>
  <component :is="as" class="mx-auto w-full max-w-[var(--container-content)] px-4 md:px-6">
    <slot />
  </component>
</template>
