<script setup>
// 1:1 → „Autor – AutorskiProfil" (+ pregled Blok o autoru).
import { ref } from 'vue'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { autorNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import FormField from '@/components/forms/FormField.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'
import AvatarUpload from '@/components/account/AvatarUpload.vue'

const ime = ref('Marko Đukić')
const bio = ref(
  'Rođen u Tesliću, pišem o ljudima, zanatima i mjestima rodnog kraja. Pratim domaće proizvođače i priče koje se prenose s koljena na koljeno.',
)
</script>

<template>
  <AccountLayout :items="autorNav">
    <div class="space-y-6">
      <div>
        <h1 class="font-heading text-[28px] font-bold text-heading">Autorski profil</h1>
        <p class="mt-1 text-[15px] text-text-muted">Vaše javne informacije kao autora priča.</p>
      </div>

      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <AvatarUpload />
        <FormField v-model="ime" label="Ime i prezime" />
        <FormTextarea v-model="bio" label="Biografija" :maxlength="500" />
        <div class="flex flex-wrap justify-end gap-3">
          <BaseButton variant="secondary" icon="save">Sačuvaj nacrt</BaseButton>
          <BaseButton variant="primary" icon="send">Pošalji na odobrenje</BaseButton>
        </div>
      </div>

      <!-- Pregled — Blok o autoru -->
      <div class="space-y-3">
        <p class="text-[13px] font-semibold uppercase tracking-wide text-text-muted">
          Pregled — Blok o autoru
        </p>
        <div class="flex gap-5 rounded-md border border-border bg-surface p-6">
          <span
            class="flex size-18 shrink-0 items-center justify-center rounded-full bg-primary-tint text-2xl font-bold text-primary"
          >
            MĐ
          </span>
          <div class="space-y-1.5">
            <p class="text-xs font-bold uppercase tracking-wider text-text-muted">O autoru</p>
            <p class="font-heading text-xl font-bold text-heading">{{ ime }}</p>
            <p class="leading-relaxed text-text">{{ bio }}</p>
          </div>
        </div>
      </div>
    </div>
  </AccountLayout>
</template>
