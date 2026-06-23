<script setup>
// 1:1 prema 13_Moj-profil.pen → „Biznis – MojProfil – Desktop/Mobile".
import { ref } from 'vue'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import FormField from '@/components/forms/FormField.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'
import AvatarUpload from '@/components/account/AvatarUpload.vue'
import UploadBox from '@/components/account/UploadBox.vue'

const naziv = ref('Pčelarstvo Đukić — Borje')
const kategorija = ref('Domaća radinost')
const opis = ref(
  'Porodično pčelarstvo sa Borja kod Teslića. Proizvodimo livadski, cvjetni i bagremov med, te pčelinje proizvode po tradicionalnoj recepturi.',
)
const adresa = ref('Borje bb, 74270 Teslić')
const telefon = ref('+387 65 123 456')
const email = ref('info@pcelarstvo-djukic.ba')
const radnoVrijeme = ref('Pon–Sub: 08–17h')
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div>
        <div class="flex items-center gap-3">
          <h1 class="font-heading text-[28px] font-bold text-heading">Moj profil</h1>
          <BaseBadge variant="nacrt" />
        </div>
        <p class="mt-1 text-[15px] text-text-muted">Uredite javne informacije o vašem subjektu.</p>
      </div>

      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <AvatarUpload />

        <div class="space-y-5">
          <div class="grid gap-5 md:grid-cols-2">
            <FormField v-model="naziv" label="Naziv subjekta" />
            <FormSelect
              v-model="kategorija"
              label="Kategorija"
              :options="['Domaća radinost', 'Zanat', 'Hrana i piće', 'Usluge', 'Smještaj']"
            />
          </div>
          <FormTextarea v-model="opis" label="Opis" :maxlength="500" />
          <div class="grid gap-5 md:grid-cols-2">
            <FormField v-model="adresa" label="Adresa" />
            <FormField v-model="telefon" label="Telefon" type="tel" />
          </div>
          <div class="grid gap-5 md:grid-cols-2">
            <FormField v-model="email" label="E-mail" type="email" />
            <FormField v-model="radnoVrijeme" label="Radno vrijeme" />
          </div>
        </div>

        <div class="space-y-2.5">
          <p class="text-sm font-semibold text-heading">Fotografije subjekta</p>
          <UploadBox />
        </div>
      </div>

      <div class="flex flex-wrap justify-end gap-3">
        <BaseButton variant="secondary" icon="save">Sačuvaj nacrt</BaseButton>
        <BaseButton variant="primary" icon="send">Pošalji na odobrenje</BaseButton>
      </div>
    </div>
  </AccountLayout>
</template>
