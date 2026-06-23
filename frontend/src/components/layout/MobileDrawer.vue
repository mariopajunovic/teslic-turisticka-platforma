<script setup>
import { ref, watch } from 'vue'
import { RouterLink } from 'vue-router'
import { mainNav } from '@/constants/navigation'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

const open = defineModel({ type: Boolean, default: false })
const expanded = ref(null)

function toggle(label) {
  expanded.value = expanded.value === label ? null : label
}
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
        <aside
          class="absolute right-0 top-0 flex h-full w-[86%] max-w-sm flex-col bg-surface shadow-[var(--shadow-lg)]"
        >
          <div class="flex h-14 items-center justify-between border-b border-border px-4">
            <RouterLink to="/" class="text-xl font-extrabold text-primary" @click="close">
              teslić
            </RouterLink>
            <button
              type="button"
              class="inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt"
              aria-label="Zatvori meni"
              @click="close"
            >
              <BaseIcon name="x" :size="22" />
            </button>
          </div>

          <nav class="flex-1 overflow-y-auto p-2">
            <template v-for="item in mainNav" :key="item.to">
              <div v-if="item.children">
                <button
                  type="button"
                  class="flex w-full items-center justify-between rounded-sm px-3 py-3 text-left text-base font-medium text-text hover:bg-surface-alt"
                  :aria-expanded="expanded === item.label"
                  @click="toggle(item.label)"
                >
                  {{ item.label }}
                  <BaseIcon
                    name="chevron-down"
                    :size="18"
                    class="text-text-muted transition-transform"
                    :class="expanded === item.label ? 'rotate-180' : ''"
                  />
                </button>
                <div v-show="expanded === item.label" class="mb-1 ml-3 border-l border-border pl-3">
                  <RouterLink
                    v-for="c in item.children"
                    :key="c.to"
                    :to="c.to"
                    class="block rounded-sm px-3 py-2 text-sm text-text-muted hover:text-primary"
                    @click="close"
                  >
                    {{ c.label }}
                  </RouterLink>
                </div>
              </div>
              <RouterLink
                v-else
                :to="item.to"
                class="block rounded-sm px-3 py-3 text-base font-medium text-text hover:bg-surface-alt hover:text-primary"
                active-class="text-primary"
                @click="close"
              >
                {{ item.label }}
              </RouterLink>
            </template>
          </nav>

          <div class="space-y-2 border-t border-border p-4">
            <BaseButton to="/pridruzi-se" variant="primary" block @click="close">
              Pridruži se
            </BaseButton>
            <BaseButton href="#" variant="ghost" block>Prijava</BaseButton>
          </div>
        </aside>
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
