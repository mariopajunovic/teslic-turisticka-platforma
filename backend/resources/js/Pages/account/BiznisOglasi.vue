<script setup>
// 1:1 → „Biznis – Oglasi".
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import PostRow from '@/components/account/PostRow.vue'

const oglasi = [
  { naslov: 'Bagremov med 1kg — 18 KM', meta: 'Rok važenja: 15.07.2026.', status: 'objavljeno' },
  { naslov: 'Prodaja pčelinjih društava', meta: 'Rok važenja: 01.07.2026.', status: 'na-odobrenju' },
  { naslov: 'Vosak za svijeće — veleprodaja', meta: 'Isteklo: 10.06.2026.', status: 'isteklo' },
  { naslov: 'Cvjetni med — sezonska akcija', meta: 'Sačuvano kao nacrt', status: 'nacrt' },
]
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="font-heading text-[28px] font-bold text-heading">Oglasi</h1>
          <p class="mt-1 text-[15px] text-text-muted">Vaši oglasi i njihov rok važenja.</p>
        </div>
        <BaseButton variant="primary" icon="plus">Novi oglas</BaseButton>
      </div>
      <div class="space-y-3">
        <PostRow v-for="(o, i) in oglasi" :key="i" :item="o" />
      </div>
    </div>
  </AccountLayout>
</template>
