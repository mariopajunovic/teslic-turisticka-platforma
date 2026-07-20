<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { usePage } from '@inertiajs/vue3'
import FormCheckbox from './FormCheckbox.vue'

const model = defineModel({ default: false })

const page = usePage()
const siteKey = computed(() => page.props.site?.postavke?.captchaSiteKey || '')

const el = ref(null)
let widgetId = null
const SRC = 'https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit'

function ucitajSkriptu() {
  return new Promise((resolve) => {
    if (window.turnstile) return resolve()
    const postojeca = document.querySelector('script[data-turnstile]')
    if (postojeca) {
      postojeca.addEventListener('load', () => resolve())
      return
    }
    const s = document.createElement('script')
    s.src = SRC
    s.async = true
    s.defer = true
    s.setAttribute('data-turnstile', '')
    s.onload = () => resolve()
    document.head.appendChild(s)
  })
}

onMounted(async () => {
  if (!siteKey.value || !el.value) return

  await ucitajSkriptu()

  const pocetak = Date.now()
  while (!window.turnstile && Date.now() - pocetak < 6000) {
    await new Promise((r) => setTimeout(r, 50))
  }
  if (!window.turnstile) return

  widgetId = window.turnstile.render(el.value, {
    sitekey: siteKey.value,
    callback: (token) => { model.value = token },
    'expired-callback': () => { model.value = '' },
    'error-callback': () => { model.value = '' },
  })
})

onBeforeUnmount(() => {
  if (widgetId != null && window.turnstile) {
    try { window.turnstile.remove(widgetId) } catch { /* widget already gone */ }
  }
})
</script>

<template>
  <div v-if="siteKey" ref="el" class="cf-turnstile"></div>
  <div
    v-else
    class="flex h-[74px] w-[300px] items-center justify-between gap-3 rounded-sm border border-border bg-surface px-4"
  >
    <FormCheckbox v-model="model" :label="$t('ui.notRobot')" />
    <div class="flex flex-col items-center gap-0.5 text-text-muted">
      <span class="text-[11px] font-semibold uppercase tracking-wide">captcha</span>
      <span class="text-[10px]">{{ $t('ui.privacyTerms') }}</span>
    </div>
  </div>
</template>
