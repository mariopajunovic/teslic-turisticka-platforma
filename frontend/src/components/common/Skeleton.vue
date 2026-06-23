<script setup>
// Loading placeholder kartice. Renderuje `count` skeletona (ubaci u CardGrid).
defineProps({
  count: { type: Number, default: 1 },
})
</script>

<template>
  <div
    v-for="n in count"
    :key="n"
    class="overflow-hidden rounded-md border border-border bg-surface"
    aria-hidden="true"
  >
    <div class="aspect-[16/10] animate-pulse bg-neutral-tint" />
    <div class="flex flex-col gap-2.5 p-4">
      <div class="h-5 w-20 animate-pulse rounded-pill bg-neutral-tint" />
      <div class="h-4 w-full animate-pulse rounded bg-neutral-tint" />
      <div class="h-3 w-full animate-pulse rounded bg-neutral-tint" />
      <div class="h-3 w-40 animate-pulse rounded bg-neutral-tint" />
    </div>
  </div>
</template>
