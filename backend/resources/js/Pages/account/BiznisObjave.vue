<script setup>
// 1:1 → „Biznis – MojeObjave".
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import PostRow from '@/components/account/PostRow.vue'

const objave = [
  { naslov: 'Pčelarstvo Đukić — domaći med sa Borja', meta: 'Ažurirano 20.06.2026. · Biznis profil', status: 'objavljeno' },
  { naslov: 'Akcija — bagremov med 1kg', meta: 'Poslano 21.06.2026. · Oglas', status: 'na-odobrenju' },
  {
    naslov: 'Posjetite našu pčelinju farmu na Borju',
    meta: 'Ažurirano 18.06.2026. · Priča',
    status: 'odbijeno',
    reason: 'Razlog odbijanja: Fotografije su niske rezolucije. Dodajte oštrije slike i pošaljite ponovo.',
  },
  { naslov: 'Zimski med — najava nove sezone', meta: 'Sačuvano 17.06.2026. · Nacrt', status: 'nacrt' },
]
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="font-heading text-[28px] font-bold text-heading">Moje objave</h1>
          <p class="mt-1 text-[15px] text-text-muted">Pregled i upravljanje vašim objavama.</p>
        </div>
        <BaseButton variant="primary" icon="plus">Nova objava</BaseButton>
      </div>
      <div class="space-y-3">
        <PostRow v-for="(o, i) in objave" :key="i" :item="o" />
      </div>
    </div>
  </AccountLayout>
</template>
