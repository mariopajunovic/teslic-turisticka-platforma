<script setup>
defineProps({
  // steps: niz { title, text }
  steps: { type: Array, default: () => [] },
})
</script>

<template>
  <ol class="flex flex-col gap-6 md:flex-row md:gap-0">
    <li
      v-for="(step, i) in steps"
      :key="i"
      class="relative flex gap-4 md:flex-1 md:flex-col md:gap-4"
    >
      <!-- Konektor (linija između koraka) -->
      <span
        v-if="i < steps.length - 1"
        class="absolute left-5 top-12 h-[calc(100%-0.5rem)] w-px bg-border md:left-auto md:top-5 md:h-px md:w-full md:translate-x-5"
        aria-hidden="true"
      />
      <span
        class="relative z-10 flex size-10 shrink-0 items-center justify-center rounded-full bg-primary font-semibold text-white"
      >
        {{ i + 1 }}
      </span>
      <div class="md:pr-6">
        <h3 class="font-heading font-semibold text-heading">{{ step.title }}</h3>
        <p v-if="step.text" class="mt-1 text-sm text-text-muted">{{ step.text }}</p>
      </div>
    </li>
  </ol>
</template>
