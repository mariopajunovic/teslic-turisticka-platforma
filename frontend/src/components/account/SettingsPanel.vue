<script setup>
// Sadržaj „Postavke" (1:1): Nalog (e-mail + lozinke) + Obavijesti (toggle) + Sačuvaj.
import { ref } from 'vue'
import FormField from '@/components/forms/FormField.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import ToggleSwitch from './ToggleSwitch.vue'

const email = ref('info@pcelarstvo-djukic.ba')
const nova = ref('')
const potvrda = ref('')
const statusObavijesti = ref(true)
const newsletter = ref(false)
</script>

<template>
  <div class="space-y-6">
    <div>
      <h1 class="font-heading text-[28px] font-bold text-heading">Postavke</h1>
      <p class="mt-1 text-[15px] text-text-muted">Upravljajte nalogom i obavijestima.</p>
    </div>

    <!-- Nalog -->
    <div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7">
      <h2 class="font-heading text-lg font-bold text-heading">Nalog</h2>
      <FormField v-model="email" label="E-mail" type="email" />
      <div class="grid gap-5 md:grid-cols-2">
        <FormField v-model="nova" label="Nova lozinka" type="password" placeholder="••••••••" />
        <FormField
          v-model="potvrda"
          label="Potvrdi novu lozinku"
          type="password"
          placeholder="••••••••"
          helper="Najmanje 8 znakova"
        />
      </div>
    </div>

    <!-- Obavijesti -->
    <div class="rounded-md border border-border bg-surface p-6 md:p-7">
      <h2 class="font-heading text-lg font-bold text-heading">Obavijesti</h2>
      <div class="mt-2 flex items-center gap-4 border-t border-border py-4">
        <div class="flex-1">
          <p class="text-[15px] font-semibold text-heading">E-mail obavijesti o statusu objava</p>
          <p class="text-[13px] text-text-muted">Primajte e-mail kada se status vaše objave promijeni.</p>
        </div>
        <ToggleSwitch v-model="statusObavijesti" label="E-mail obavijesti" />
      </div>
      <div class="flex items-center gap-4 border-t border-border py-4">
        <div class="flex-1">
          <p class="text-[15px] font-semibold text-heading">Newsletter</p>
          <p class="text-[13px] text-text-muted">Novosti, savjeti i obavijesti o platformi.</p>
        </div>
        <ToggleSwitch v-model="newsletter" label="Newsletter" />
      </div>
    </div>

    <div class="flex justify-end">
      <BaseButton variant="primary" icon="check">Sačuvaj izmjene</BaseButton>
    </div>
  </div>
</template>
