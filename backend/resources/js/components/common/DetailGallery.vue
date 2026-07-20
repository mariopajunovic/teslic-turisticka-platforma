<script setup>
import { computed, ref } from 'vue'
import Lightbox from '@/components/common/Lightbox.vue'

const props = defineProps({
  slika: { type: String, default: '' },
  galerija: { type: Array, default: () => [] },
  naslov: { type: String, default: '' },
})

const sveSlike = computed(() => {
  const g = (props.galerija || [])
    .map((m) => ({ src: m.src, alt: m.alt || props.naslov }))
    .filter((x) => x.src)
  return [...(props.slika ? [{ src: props.slika, alt: props.naslov }] : []), ...g]
})

const preview = computed(() => sveSlike.value.slice(0, 3))
const preostalo = computed(() => Math.max(0, sveSlike.value.length - 3))

const lbOpen = ref(false)
const lbIndex = ref(0)
const otvori = (i) => {
  lbIndex.value = i
  lbOpen.value = true
}
</script>

<template>
  <div v-if="sveSlike.length">
    <div class="grid gap-3 md:h-[440px] md:grid-cols-3">
      <button
        type="button"
        class="group relative aspect-[16/10] overflow-hidden rounded-lg bg-primary-tint md:aspect-auto md:h-full"
        :class="preview.length > 1 ? 'md:col-span-2' : 'md:col-span-3'"
        @click="otvori(0)"
      >
        <img :src="preview[0].src" :alt="naslov" class="size-full object-cover transition-transform duration-300 group-hover:scale-[1.02]" />
      </button>

      <div v-if="preview.length > 1" class="grid grid-cols-2 gap-3 md:grid-cols-1">
        <button
          v-for="n in (preview.length - 1)"
          :key="n"
          type="button"
          class="group relative aspect-square overflow-hidden rounded-lg bg-primary-tint md:aspect-auto md:h-[214px]"
          @click="otvori(n)"
        >
          <img :src="preview[n].src" :alt="naslov" class="size-full object-cover transition-transform duration-300 group-hover:scale-[1.02]" />
          <span
            v-if="n === 2 && preostalo > 0"
            class="absolute inset-0 flex items-center justify-center bg-heading/60 text-white transition-colors group-hover:bg-heading/70"
          >
            <span class="font-heading text-2xl font-bold">+{{ preostalo }}</span>
          </span>
        </button>
      </div>
    </div>

    <Lightbox v-model="lbOpen" :items="sveSlike" :start-index="lbIndex" />
  </div>
</template>
