<script setup>
// Responzivni grid kartica: 4→2→1 (desktop/tablet/mobile), gutter 24/16.
defineProps({
  cols: { type: Number, default: 4 }, // max kolona na desktopu (3 ili 4)
})
</script>

<template>
  <div
    class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6"
    :class="cols === 3 ? 'lg:grid-cols-3' : 'lg:grid-cols-4'"
  >
    <slot />
  </div>
</template>
