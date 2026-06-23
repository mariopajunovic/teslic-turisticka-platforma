<script setup>
// 1:1 → „Biznis – Mediji".
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import UploadBox from '@/components/account/UploadBox.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const img = (id) => `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=600&q=80`
const mediji = [
  img('1679941060882-f21c7a51330c'),
  img('1586779161220-ec6e587ceadc'),
  img('1591519592341-035d29b05cd1'),
  '',
  img('1718884168768-c5d6e2dca0f9'),
  '',
  '',
  '',
]
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div>
        <h1 class="font-heading text-[28px] font-bold text-heading">Mediji</h1>
        <p class="mt-1 text-[15px] text-text-muted">
          Galerija fotografija i video zapisa vašeg subjekta.
        </p>
      </div>
      <UploadBox
        title="Prevucite fotografije ili kliknite za odabir"
        hint="JPG, PNG ili MP4 — do 5 MB po datoteci"
      />
      <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <div
          v-for="(m, i) in mediji"
          :key="i"
          class="flex h-40 items-center justify-center overflow-hidden rounded-md bg-primary-tint"
        >
          <img v-if="m" :src="m" alt="" loading="lazy" class="size-full object-cover" />
          <BaseIcon v-else name="image" :size="28" class="text-primary-tint-2" />
        </div>
      </div>
    </div>
  </AccountLayout>
</template>
