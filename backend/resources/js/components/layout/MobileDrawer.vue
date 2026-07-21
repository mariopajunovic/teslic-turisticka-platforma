<script setup>
import { ref, watch } from 'vue'
import { Link, router as inertiaRouter } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useSite } from '@/composables/useSite'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

const { mainNav, secondaryNav, postavke } = useSite()
const { t } = useI18n()

const open = defineModel({ type: Boolean, default: false })
const expanded = ref(null)
const searchTerm = ref('')

function toggle(label) {
  expanded.value = expanded.value === label ? null : label
}
function close() {
  open.value = false
}
function submitSearch() {
  const q = searchTerm.value.trim()
  close()
  if (q) inertiaRouter.visit(`/mapa?q=${encodeURIComponent(q)}`)
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
          class="absolute right-0 top-0 flex h-full w-[88%] max-w-sm flex-col bg-surface shadow-[var(--shadow-lg)]"
        >
          <!-- Vrh -->
          <div class="flex h-14 shrink-0 items-center justify-between border-b border-border px-4">
            <Link href="/" class="flex items-center" :aria-label="postavke.brandLogoTekst" @click="close">
              <img v-if="postavke.brandLogo" :src="postavke.brandLogo" :alt="postavke.brandLogoTekst" class="max-h-9 w-auto object-contain" />
              <span v-else class="text-xl font-extrabold text-primary">{{ postavke.brandLogoTekst }}</span>
            </Link>
            <button
              type="button"
              class="inline-flex size-10 items-center justify-center rounded-sm text-heading hover:bg-surface-alt"
              :aria-label="t('a11y.closeMenu')"
              @click="close"
            >
              <BaseIcon name="x" :size="22" />
            </button>
          </div>

          <!-- Navigacija -->
          <nav class="flex-1 overflow-y-auto p-2 pt-3">
            <template v-for="item in mainNav" :key="item.label">
              <div v-if="item.children">
                <button
                  type="button"
                  class="flex w-full items-center justify-between rounded-sm px-3 py-3 text-left text-base font-medium hover:bg-surface-alt"
                  :class="expanded === item.label ? 'bg-primary-tint text-primary' : 'text-text'"
                  :aria-expanded="expanded === item.label"
                  @click="toggle(item.label)"
                >
                  {{ item.label }}
                  <BaseIcon
                    name="chevron-down"
                    :size="18"
                    class="transition-transform"
                    :class="expanded === item.label ? 'rotate-180 text-primary' : 'text-text-muted'"
                  />
                </button>
                <div v-show="expanded === item.label" class="mb-1 ml-3 border-l border-border pl-3">
                  <Link
                    v-for="c in item.children"
                    :key="c.to"
                    :href="c.to"
                    class="block rounded-sm px-3 py-2 text-sm text-text-muted hover:text-primary"
                    @click="close"
                  >
                    {{ c.label }}
                  </Link>
                </div>
              </div>
              <Link
                v-else
                :href="item.to"
                class="flex items-center justify-between rounded-sm px-3 py-3 text-base font-medium text-text hover:bg-surface-alt hover:text-primary"
                @click="close"
              >
                {{ item.label }}
                <BaseIcon name="chevron-right" :size="18" class="text-text-muted" />
              </Link>
            </template>

            <div class="my-2 border-t border-border" />

            <Link
              v-for="item in secondaryNav"
              :key="item.to"
              :href="item.to"
              class="flex items-center justify-between rounded-sm px-3 py-3 text-base font-medium text-text hover:bg-surface-alt hover:text-primary"
              @click="close"
            >
              {{ item.label }}
              <BaseIcon name="chevron-right" :size="18" class="text-text-muted" />
            </Link>
          </nav>

          <!-- Akcije -->
          <div class="shrink-0 space-y-2 border-t border-border p-4">
            <BaseButton to="/prijava" variant="secondary" block @click="close">{{ t('action.login') }}</BaseButton>
            <BaseButton to="/pridruzi-se" variant="primary" block @click="close">
              Pridruži se
            </BaseButton>
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
