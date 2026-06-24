<script setup>
import { watch } from 'vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

const open = defineModel({ type: Boolean, default: false })

function close() {
  open.value = false
}

// Zaključaj scroll tijela dok je drawer otvoren.
watch(open, (v) => {
  document.body.style.overflow = v ? 'hidden' : ''
})
</script>

<template>
  <Teleport to="body">
    <Transition name="fade">
      <div v-if="open" class="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-overlay" @click="close" />
        <section
          class="absolute inset-x-0 bottom-0 flex max-h-[85%] flex-col rounded-t-lg bg-surface shadow-[var(--shadow-lg)]"
        >
          <div class="flex h-14 shrink-0 items-center justify-between border-b border-border px-4">
            <h2 class="text-lg font-semibold text-heading">Filteri</h2>
            <button
              type="button"
              class="inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt"
              aria-label="Zatvori filtere"
              @click="close"
            >
              <BaseIcon name="x" :size="22" />
            </button>
          </div>

          <div class="flex-1 space-y-4 overflow-y-auto p-4">
            <slot />
          </div>

          <div class="shrink-0 border-t border-border p-4">
            <BaseButton variant="primary" block @click="close">Prikaži rezultate</BaseButton>
          </div>
        </section>
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
