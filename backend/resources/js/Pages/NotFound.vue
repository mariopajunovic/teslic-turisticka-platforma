<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
import AppContainer from '@/components/layout/AppContainer.vue'
import BaseButton from '@/components/base/BaseButton.vue'
</script>

<template>
  <AppContainer as="main" class="py-20 text-center">
    <p class="text-6xl font-bold text-primary">404</p>
    <h1 class="mt-4 text-3xl font-bold text-heading">{{ $t('misc.notFoundTitle') }}</h1>
    <p class="mx-auto mt-3 max-w-md text-text-muted">
      {{ $t('misc.notFoundText') }}
    </p>
    <div class="mt-8 flex justify-center">
      <BaseButton :to="localePath('/')" variant="primary" icon="arrow-right" icon-position="right">
        {{ $t('misc.backHome') }}
      </BaseButton>
    </div>
  </AppContainer>
</template>
