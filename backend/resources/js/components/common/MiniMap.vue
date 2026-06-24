<script setup>
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

defineProps({
  label: { type: String, default: '' },
  to: { type: [String, Object], default: '/mapa' },
})
</script>

<template>
  <div class="overflow-hidden rounded-md border border-border bg-surface shadow-[var(--shadow-sm)]">
    <div
      class="relative flex h-[180px] items-center justify-center bg-primary-tint"
      role="img"
      :aria-label="label ? `Mapa: ${label}` : 'Mapa'"
    >
      <span
        class="pointer-events-none absolute inset-0 opacity-40"
        style="
          background-image:
            linear-gradient(var(--color-primary-tint-2) 1px, transparent 1px),
            linear-gradient(90deg, var(--color-primary-tint-2) 1px, transparent 1px);
          background-size: 28px 28px;
        "
        aria-hidden="true"
      />
      <span class="relative text-primary">
        <BaseIcon name="map-pin" :size="48" />
      </span>
    </div>

    <div class="flex flex-col gap-3 p-4">
      <div v-if="label" class="flex items-center gap-2 text-text">
        <span class="shrink-0 text-primary"><BaseIcon name="map-pin" :size="18" /></span>
        <span class="font-medium">{{ label }}</span>
      </div>
      <BaseButton variant="secondary" size="sm" icon="map" :to="to" block>
        Prikaži na mapi
      </BaseButton>
    </div>
  </div>
</template>
