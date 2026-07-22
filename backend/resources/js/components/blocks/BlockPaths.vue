<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

defineProps({
  data: { type: Object, default: () => ({}) },
})
</script>

<template>
  <AppContainer class="space-y-8">
    <div v-if="data.naslov || data.podnaslov" class="mx-auto max-w-2xl space-y-3 text-center">
      <h2 v-if="data.naslov" class="font-heading text-3xl font-bold text-heading md:text-[34px]">
        {{ data.naslov }}
      </h2>
      <p v-if="data.podnaslov" class="text-base leading-relaxed text-text-muted">
        {{ data.podnaslov }}
      </p>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
      <div
        v-for="(p, i) in data.paths || []"
        :key="i"
        class="flex flex-col gap-5 rounded-xl border border-border bg-surface p-8 md:p-9"
      >
        <div class="flex size-16 items-center justify-center rounded-xl bg-primary-tint">
          <BaseIcon :name="p.icon || 'circle'" :size="30" class="text-primary" />
        </div>
        <h3 class="font-heading text-2xl font-bold text-heading">{{ p.title }}</h3>
        <p class="text-[15px] leading-relaxed text-text-muted">{{ p.text }}</p>
        <ul class="space-y-2.5 py-1">
          <li v-for="(f, j) in p.features || []" :key="j" class="flex items-start gap-2.5">
            <BaseIcon name="check" :size="18" class="mt-0.5 shrink-0 text-primary" />
            <span class="text-sm text-text">{{ f.text ?? f }}</span>
          </li>
        </ul>
        <div class="mt-auto pt-1">
          <BaseButton
            :to="p.buttonUrl || '#'"
            :variant="p.buttonVariant || 'primary'"
            icon="arrow-right"
            icon-position="right"
          >
            {{ p.buttonLabel || p.title }}
          </BaseButton>
        </div>
      </div>
    </div>
  </AppContainer>
</template>
