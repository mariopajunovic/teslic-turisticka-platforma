<script setup>
import { Link } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import PostRow from '@/components/account/PostRow.vue'
import EmptyState from '@/components/common/EmptyState.vue'

defineProps({
  objave: { type: Array, default: () => [] },
})
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 class="font-heading text-[28px] font-bold text-heading">Moje objave</h1>
          <p class="mt-1 text-[15px] text-text-muted">Vaše biznis objave i njihov status.</p>
        </div>
        <BaseButton to="/nalog/biznis/objave/nova" variant="primary" icon="plus">Nova objava</BaseButton>
      </div>

      <div v-if="objave.length" class="space-y-3">
        <Link v-for="o in objave" :key="o.id" :href="o.editUrl" class="block">
          <PostRow :item="o" />
        </Link>
      </div>

      <EmptyState v-else title="Još nema objava" text="Kreirajte prvu objavu i pošaljite je na odobrenje." />
    </div>
  </AccountLayout>
</template>
