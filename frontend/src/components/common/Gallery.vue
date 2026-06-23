<script setup>
// Galerija sličica (grid ili carousel). Klik otvara interni Lightbox.
import { ref } from 'vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import Lightbox from '@/components/common/Lightbox.vue'

defineProps({
  items: { type: Array, default: () => [] },
  variant: {
    type: String,
    default: 'grid',
    validator: (v) => ['grid', 'carousel'].includes(v),
  },
})

const open = ref(false)
const index = ref(0)

function openAt(i) {
  index.value = i
  open.value = true
}
</script>

<template>
  <div>
    <!-- grid -->
    <div
      v-if="variant === 'grid'"
      class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4"
    >
      <button
        v-for="(item, i) in items"
        :key="i"
        type="button"
        class="group relative aspect-square overflow-hidden rounded-md bg-primary-tint"
        :aria-label="item.alt || 'Otvori stavku galerije'"
        @click="openAt(i)"
      >
        <img
          :src="item.src"
          :alt="item.alt || ''"
          loading="lazy"
          class="size-full object-cover transition-transform duration-300 group-hover:scale-105"
        />
        <span
          v-if="item.type === 'video'"
          class="absolute inset-0 flex items-center justify-center bg-black/30 text-white"
        >
          <BaseIcon name="play" :size="36" />
        </span>
      </button>
    </div>

    <!-- carousel -->
    <div
      v-else
      class="flex snap-x snap-mandatory gap-3 overflow-x-auto pb-2"
    >
      <button
        v-for="(item, i) in items"
        :key="i"
        type="button"
        class="group relative aspect-square w-40 shrink-0 snap-start overflow-hidden rounded-md bg-primary-tint sm:w-48"
        :aria-label="item.alt || 'Otvori stavku galerije'"
        @click="openAt(i)"
      >
        <img
          :src="item.src"
          :alt="item.alt || ''"
          loading="lazy"
          class="size-full object-cover transition-transform duration-300 group-hover:scale-105"
        />
        <span
          v-if="item.type === 'video'"
          class="absolute inset-0 flex items-center justify-center bg-black/30 text-white"
        >
          <BaseIcon name="play" :size="36" />
        </span>
      </button>
    </div>

    <Lightbox v-model="open" :items="items" :start-index="index" />
  </div>
</template>
