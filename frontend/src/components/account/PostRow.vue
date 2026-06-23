<script setup>
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'

// Red objave u nalogu. item: { naslov, meta, status (BaseBadge variant), thumb? }
defineProps({
  item: { type: Object, required: true },
})
defineEmits(['edit', 'delete'])
</script>

<template>
  <div class="flex items-center gap-4 rounded-md border border-border bg-surface p-4">
    <div class="size-14 shrink-0 overflow-hidden rounded-md bg-primary-tint">
      <img v-if="item.thumb" :src="item.thumb" alt="" class="size-full object-cover" />
    </div>
    <div class="min-w-0 flex-1">
      <p class="truncate font-semibold text-heading">{{ item.naslov }}</p>
      <p class="text-[13px] text-text-muted">{{ item.meta }}</p>
    </div>
    <BaseBadge v-if="item.status" :variant="item.status" />
    <div class="flex gap-2">
      <button
        type="button"
        class="grid size-9 place-items-center rounded-md bg-surface-alt text-text-muted hover:text-primary"
        aria-label="Uredi"
        @click="$emit('edit', item)"
      >
        <BaseIcon name="pencil" :size="16" />
      </button>
      <button
        type="button"
        class="grid size-9 place-items-center rounded-md bg-surface-alt text-text-muted hover:text-error"
        aria-label="Obriši"
        @click="$emit('delete', item)"
      >
        <BaseIcon name="trash-2" :size="16" />
      </button>
    </div>
  </div>
</template>
