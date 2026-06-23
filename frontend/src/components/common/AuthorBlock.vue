<script setup>
import BaseIcon from '@/components/base/BaseIcon.vue'
import BaseButton from '@/components/base/BaseButton.vue'

// author: { ime, bio, avatar? }
defineProps({
  author: { type: Object, required: true },
  to: { type: [String, Object], default: null },
})
</script>

<template>
  <div class="rounded-md bg-surface-alt p-5 md:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
      <img
        v-if="author.avatar"
        :src="author.avatar"
        :alt="author.ime"
        class="size-14 shrink-0 rounded-full object-cover"
      />
      <span
        v-else
        class="flex size-14 shrink-0 items-center justify-center rounded-full bg-primary-tint-2 text-primary"
        aria-hidden="true"
      >
        <BaseIcon name="user" :size="28" />
      </span>

      <div class="min-w-0">
        <p class="font-heading font-semibold text-heading">{{ author.ime }}</p>
        <p v-if="author.bio" class="mt-1 text-sm text-text-muted">{{ author.bio }}</p>
        <BaseButton
          v-if="to"
          variant="ghost"
          size="sm"
          icon="arrow-right"
          icon-position="right"
          :to="to"
          class="mt-3 -ml-4"
        >
          Sve priče autora
        </BaseButton>
      </div>
    </div>
  </div>
</template>
