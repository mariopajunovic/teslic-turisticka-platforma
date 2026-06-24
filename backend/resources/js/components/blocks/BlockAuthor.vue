<script setup>
import { computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import AuthorBlock from '@/components/common/AuthorBlock.vue'

const props = defineProps({
  data: { type: Object, default: () => ({}) },
})

const author = computed(() => ({
  ime: props.data.ime,
  uloga: props.data.uloga,
  bio: props.data.bio,
  avatar: props.data.avatar,
}))
</script>

<template>
  <AppContainer>
    <AuthorBlock :author="author" />
  </AppContainer>
</template>
