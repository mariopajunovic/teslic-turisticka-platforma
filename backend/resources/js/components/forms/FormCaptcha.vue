<script setup>
// Placeholder za captcha widget (hCaptcha/reCAPTCHA). Obavezan na javnim formama.
// Pravi widget se ubacuje kasnije; ovdje samo vizuelni okvir + checkbox.
import FormCheckbox from './FormCheckbox.vue'

const model = defineModel({ type: Boolean, default: false })
</script>

<template>
  <div
    class="flex h-[74px] w-[300px] items-center justify-between gap-3 rounded-sm border border-border bg-surface px-4"
  >
    <FormCheckbox v-model="model" label="Nisam robot" />
    <div class="flex flex-col items-center gap-0.5 text-text-muted">
      <span class="text-[11px] font-semibold uppercase tracking-wide">captcha</span>
      <span class="text-[10px]">privatnost · uslovi</span>
    </div>
  </div>
</template>
