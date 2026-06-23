<script setup>
// 1:1 → „Autor – MojePrice".
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { autorNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import PostRow from '@/components/account/PostRow.vue'

const price = [
  { naslov: 'Borje — gdje med ima ukus planine', meta: 'Objavljeno 19.06.2026. · Priča', status: 'objavljeno' },
  { naslov: 'Pet mjesta za posjetiti u okolini Teslića', meta: 'Poslano 21.06.2026. · Priča', status: 'na-odobrenju' },
  { naslov: 'Stare zanate Teslića čuvaju mladi', meta: 'Sačuvano 16.06.2026. · Nacrt', status: 'nacrt' },
]
</script>

<template>
  <AccountLayout :items="autorNav">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="font-heading text-[28px] font-bold text-heading">Moje priče</h1>
          <p class="mt-1 text-[15px] text-text-muted">Vaše objavljene i sačuvane priče.</p>
        </div>
        <BaseButton to="/nalog/autor/nova-prica" variant="primary" icon="plus">Nova priča</BaseButton>
      </div>
      <div class="space-y-3">
        <PostRow v-for="(p, i) in price" :key="i" :item="p" />
      </div>
    </div>
  </AccountLayout>
</template>
