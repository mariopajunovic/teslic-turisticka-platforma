<script setup>
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'

// Red objave/oglasa/priče u nalogu (1:1 RedObjave).
// item: { naslov, meta, status (BaseBadge variant), thumb?, reason? }
defineProps({
  item: { type: Object, required: true },
})
defineEmits(['edit', 'delete'])
</script>

<template>
  <div class="overflow-hidden rounded-md border border-border bg-surface">
    <div class="flex items-center gap-4 p-4">
      <div class="size-14 shrink-0 overflow-hidden rounded-md bg-primary-tint">
        <img v-if="item.thumb" :src="item.thumb" alt="" class="size-full object-cover" />
      </div>
      <div class="min-w-0 flex-1">
        <p class="truncate font-semibold text-heading">{{ item.naslov }}</p>
        <p class="text-[13px] text-text-muted">{{ item.meta }}</p>
      </div>
      <div class="flex flex-col items-end gap-1">
        <BaseBadge v-if="item.status" :variant="item.status" />
        <BaseBadge v-if="item.pendingStanje === 'na_cekanju'" variant="na-odobrenju" label="Izmjene na čekanju" />
        <BaseBadge v-else-if="item.pendingStanje === 'vraceno'" variant="odbijeno" label="Vraćeno na doradu" />
      </div>
      <div class="flex gap-2">
        <button
          type="button"
          class="grid size-9 place-items-center rounded-md bg-surface-alt text-text-muted hover:text-primary"
          :aria-label="$t('ui.edit')"
          @click="$emit('edit', item)"
        >
          <BaseIcon name="pencil" :size="16" />
        </button>
        <button
          type="button"
          class="grid size-9 place-items-center rounded-md bg-surface-alt text-text-muted hover:text-error"
          :aria-label="$t('ui.delete')"
          @click="$emit('delete', item)"
        >
          <BaseIcon name="trash-2" :size="16" />
        </button>
      </div>
    </div>
    <div
      v-if="item.reason"
      class="flex items-start gap-2 border-t border-border bg-error-tint px-4 py-2.5 text-[13px] text-error"
    >
      <BaseIcon name="info" :size="16" class="mt-0.5 shrink-0" />
      <span>{{ item.reason }}</span>
    </div>
    <div
      v-if="item.pendingRazlog"
      class="flex items-start gap-2 border-t border-border bg-error-tint px-4 py-2.5 text-[13px] text-error"
    >
      <BaseIcon name="info" :size="16" class="mt-0.5 shrink-0" />
      <span>Izmjene vraćene na doradu: <span class="font-semibold">{{ item.pendingRazlog }}</span></span>
    </div>
  </div>
</template>
