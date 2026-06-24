<script setup>
import { Link } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { autorNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import PostRow from '@/components/account/PostRow.vue'
import EmptyState from '@/components/common/EmptyState.vue'

defineProps({
  price: { type: Array, default: () => [] },
})
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

      <div v-if="price.length" class="space-y-3">
        <Link v-for="p in price" :key="p.id" :href="p.editUrl" class="block">
          <PostRow :item="p" />
        </Link>
      </div>

      <EmptyState
        v-else
        title="Još nema priča"
        text="Kreirajte prvu priču i pošaljite je na odobrenje."
      />
    </div>
  </AccountLayout>
</template>
