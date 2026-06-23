<script setup>
// Privremena zaštita preview-a: ništa se ne prikazuje dok se ne unese šifra.
import { ref } from 'vue'
import { useGateStore } from '@/stores/gate'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const gate = useGateStore()
const sifra = ref('')
const greska = ref(false)

function provjeri() {
  if (!gate.unlock(sifra.value)) {
    greska.value = true
    sifra.value = ''
  }
}
</script>

<template>
  <div class="flex min-h-screen items-center justify-center bg-surface-alt p-4">
    <form
      class="w-full max-w-[380px] space-y-5 rounded-2xl border border-border bg-surface p-8 text-center"
      @submit.prevent="provjeri"
    >
      <div class="flex flex-col items-center gap-3">
        <span class="flex size-14 items-center justify-center rounded-full bg-primary-tint text-primary">
          <BaseIcon name="lock" :size="26" />
        </span>
        <div>
          <p class="text-2xl font-extrabold tracking-tight text-primary">teslić</p>
          <p class="mt-1 text-sm text-text-muted">Privatni pregled — unesite šifru za pristup.</p>
        </div>
      </div>

      <div class="text-left">
        <input
          v-model="sifra"
          type="password"
          placeholder="Šifra"
          autofocus
          class="h-11 w-full rounded-sm border bg-surface px-4 text-text outline-none transition-colors focus:border-primary"
          :class="greska ? 'border-error' : 'border-border'"
          @input="greska = false"
        />
        <p v-if="greska" class="mt-1.5 text-[13px] text-error">Pogrešna šifra. Pokušajte ponovo.</p>
      </div>

      <BaseButton type="submit" variant="primary" block>Uđi</BaseButton>
    </form>
  </div>
</template>
