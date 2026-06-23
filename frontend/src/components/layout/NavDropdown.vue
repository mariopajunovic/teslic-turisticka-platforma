<script setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
import BaseIcon from '@/components/base/BaseIcon.vue'

defineProps({
  item: { type: Object, required: true },
})

const open = ref(false)
let timer

function show() {
  clearTimeout(timer)
  open.value = true
}
function hide() {
  timer = setTimeout(() => (open.value = false), 120)
}
function onFocusout(e) {
  if (!e.currentTarget.contains(e.relatedTarget)) open.value = false
}
</script>

<template>
  <div class="relative" @mouseenter="show" @mouseleave="hide" @focusout="onFocusout">
    <RouterLink
      :to="item.to"
      class="inline-flex items-center gap-1 text-sm font-medium text-text transition-colors hover:text-primary"
      active-class="text-primary"
      :aria-expanded="open"
      @focus="show"
    >
      {{ item.label }}
      <BaseIcon name="chevron-down" :size="14" class="text-text-muted" />
    </RouterLink>
    <Transition name="dropdown">
      <div
        v-if="open"
        class="absolute left-0 top-full z-50 mt-1 min-w-56 rounded-md border border-border bg-surface p-2 shadow-[var(--shadow-md)]"
      >
        <RouterLink
          v-for="c in item.children"
          :key="c.to"
          :to="c.to"
          class="block rounded-sm px-3 py-2 text-sm text-text transition-colors hover:bg-primary-tint hover:text-primary-dark"
        >
          {{ c.label }}
        </RouterLink>
      </div>
    </Transition>
  </div>
</template>

<style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
  transition:
    opacity 0.15s ease,
    transform 0.15s ease;
}
.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-4px);
}
</style>
