<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import BaseIcon from '@/components/base/BaseIcon.vue'

const page = usePage()
const open = ref(false)

const locale = computed(() => page.props.locale ?? {})
const languages = computed(() => locale.value.languages ?? [])
const alternates = computed(() => locale.value.alternates ?? {})
const current = computed(() => languages.value.find((l) => l.active) ?? languages.value[0])
const isSerbian = computed(() => locale.value.language === 'sr')
const script = computed(() => locale.value.script ?? 'lat')
</script>

<template>
  <div v-if="languages.length" class="relative">
    <button
      type="button"
      class="inline-flex h-10 items-center gap-1 rounded-sm px-2.5 text-[13px] font-bold text-heading hover:bg-surface-alt"
      :aria-expanded="open"
      :aria-label="$t('a11y.language')"
      @click="open = !open"
    >
      <BaseIcon name="globe" :size="18" />
      <span>{{ current?.short }}<template v-if="isSerbian"> · {{ script === 'cir' ? 'ЋИР' : 'LAT' }}</template></span>
      <BaseIcon name="chevron-down" :size="14" />
    </button>

    <div v-if="open" class="fixed inset-0 z-40" @click="open = false" />

    <div
      v-if="open"
      class="absolute right-0 z-50 mt-1 w-48 overflow-hidden rounded-sm border border-border bg-surface py-1 shadow-lg"
    >
      <p class="px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-text-muted">{{ $t('misc.langSection') }}</p>
      <a
        v-for="l in languages"
        :key="l.key"
        :href="alternates[l.key] || '/'"
        class="flex items-center justify-between px-3 py-2 text-sm hover:bg-surface-alt"
        :class="l.active ? 'font-bold text-primary' : 'text-text'"
      >
        {{ l.label }}
        <BaseIcon v-if="l.active" name="check" :size="15" />
      </a>

      <template v-if="isSerbian">
        <div class="my-1 border-t border-border" />
        <p class="px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-text-muted">{{ $t('misc.scriptSection') }}</p>
        <a
          href="/pismo/lat"
          class="flex items-center justify-between px-3 py-2 text-sm hover:bg-surface-alt"
          :class="script === 'lat' ? 'font-bold text-primary' : 'text-text'"
        >
          Latinica
          <BaseIcon v-if="script === 'lat'" name="check" :size="15" />
        </a>
        <a
          href="/pismo/cir"
          class="flex items-center justify-between px-3 py-2 text-sm hover:bg-surface-alt"
          :class="script === 'cir' ? 'font-bold text-primary' : 'text-text'"
        >
          Ћирилица
          <BaseIcon v-if="script === 'cir'" name="check" :size="15" />
        </a>
      </template>
    </div>
  </div>
</template>
