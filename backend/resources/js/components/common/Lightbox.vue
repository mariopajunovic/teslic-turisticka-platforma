<script setup>
// Fullscreen lightbox za slike/video. Teleport + scroll-lock + tastatura.
import { ref, computed, watch, onBeforeUnmount } from 'vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const open = defineModel({ type: Boolean })

const props = defineProps({
  items: { type: Array, default: () => [] },
  startIndex: { type: Number, default: 0 },
})

const index = ref(props.startIndex)

const current = computed(() => props.items[index.value] || null)
const total = computed(() => props.items.length)

function clamp(i) {
  if (total.value === 0) return 0
  return (i + total.value) % total.value
}
function next() {
  index.value = clamp(index.value + 1)
}
function prev() {
  index.value = clamp(index.value - 1)
}
function close() {
  open.value = false
}

function onKeydown(e) {
  if (e.key === 'Escape') close()
  else if (e.key === 'ArrowRight') next()
  else if (e.key === 'ArrowLeft') prev()
}

watch(open, (v) => {
  if (v) {
    index.value = clamp(props.startIndex)
    document.body.style.overflow = 'hidden'
    window.addEventListener('keydown', onKeydown)
  } else {
    document.body.style.overflow = ''
    window.removeEventListener('keydown', onKeydown)
  }
})

onBeforeUnmount(() => {
  document.body.style.overflow = ''
  window.removeEventListener('keydown', onKeydown)
})
</script>

<template>
  <Teleport to="body">
    <Transition name="fade">
      <div
        v-if="open"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-overlay"
        role="dialog"
        aria-modal="true"
        @click.self="close"
      >
        <button
          type="button"
          class="absolute right-4 top-4 inline-flex size-11 items-center justify-center rounded-sm text-white hover:bg-white/10"
          aria-label="Zatvori"
          @click="close"
        >
          <BaseIcon name="x" :size="26" />
        </button>

        <button
          v-if="total > 1"
          type="button"
          class="absolute left-2 top-1/2 inline-flex size-11 -translate-y-1/2 items-center justify-center rounded-sm text-white hover:bg-white/10 sm:left-4"
          aria-label="Prethodno"
          @click="prev"
        >
          <BaseIcon name="chevron-left" :size="32" />
        </button>

        <div class="flex max-h-[88vh] max-w-[92vw] items-center justify-center">
          <video
            v-if="current && current.type === 'video'"
            :src="current.src"
            controls
            autoplay
            class="max-h-[88vh] max-w-[92vw] rounded-md bg-black object-contain"
          />
          <img
            v-else-if="current"
            :src="current.src"
            :alt="current.alt || ''"
            class="max-h-[88vh] max-w-[92vw] rounded-md object-contain"
          />
        </div>

        <button
          v-if="total > 1"
          type="button"
          class="absolute right-2 top-1/2 inline-flex size-11 -translate-y-1/2 items-center justify-center rounded-sm text-white hover:bg-white/10 sm:right-4"
          aria-label="Sljedeće"
          @click="next"
        >
          <BaseIcon name="chevron-right" :size="32" />
        </button>

        <div
          v-if="total > 1"
          class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-pill bg-black/50 px-3 py-1 text-sm font-medium text-white"
        >
          {{ index + 1 }} / {{ total }}
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
