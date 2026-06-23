<script setup>
defineProps({
  title: { type: String, default: '' },
  text: { type: String, default: '' },
})
</script>

<template>
  <div class="flex flex-col items-center rounded-lg bg-primary px-8 py-12 text-center">
    <h2 class="font-heading text-3xl font-bold text-white md:text-4xl">{{ title }}</h2>
    <p v-if="text" class="mt-3 max-w-2xl text-lg text-primary-tint">{{ text }}</p>
    <div v-if="$slots.default" class="mt-8 flex flex-wrap justify-center gap-3"><slot /></div>
  </div>
</template>
