<script setup>
import { Link } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import PostRow from '@/components/account/PostRow.vue'
import EmptyState from '@/components/common/EmptyState.vue'

defineProps({
  oglasi: { type: Array, default: () => [] },
})
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="font-heading text-[28px] font-bold text-heading">Oglasi</h1>
          <p class="mt-1 text-[15px] text-text-muted">Vaši oglasi i njihov status.</p>
        </div>
        <BaseButton to="/nalog/biznis/oglasi/novi" variant="primary" icon="plus">Novi oglas</BaseButton>
      </div>

      <div v-if="oglasi.length" class="space-y-3">
        <Link v-for="o in oglasi" :key="o.id" :href="o.editUrl" class="block">
          <PostRow :item="o" />
        </Link>
      </div>

      <EmptyState v-else title="Još nema oglasa" text="Kreirajte prvi oglas i pošaljite ga na odobrenje." />
    </div>
  </AccountLayout>
</template>
