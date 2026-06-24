<script setup>
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'

const props = defineProps({
  seo: { type: Object, default: () => ({}) },
})

const page = usePage()

const data = computed(() => {
  const s = props.seo || {}
  const appName = page.props.site?.postavke?.brandNaziv || 'TO Teslić'
  return {
    title: s.title || appName,
    description:
      s.description ||
      'Digitalna platforma za promociju turizma, domaćih proizvoda i usluga opštine Teslić.',
    canonical: s.canonical || '',
    image: s.image || '',
    type: s.type || 'website',
  }
})

const jsonLdString = computed(() => (props.seo?.jsonLd ? JSON.stringify(props.seo.jsonLd) : ''))
</script>

<template>
  <Head :title="data.title">
    <meta name="description" :content="data.description" head-key="description" />
    <link v-if="data.canonical" rel="canonical" :href="data.canonical" head-key="canonical" />
    <meta property="og:title" :content="data.title" head-key="og:title" />
    <meta property="og:description" :content="data.description" head-key="og:description" />
    <meta property="og:type" :content="data.type" head-key="og:type" />
    <meta v-if="data.canonical" property="og:url" :content="data.canonical" head-key="og:url" />
    <meta v-if="data.image" property="og:image" :content="data.image" head-key="og:image" />
    <meta name="twitter:card" :content="data.image ? 'summary_large_image' : 'summary'" head-key="twitter:card" />
    <component :is="'script'" v-if="jsonLdString" type="application/ld+json" v-html="jsonLdString" />
  </Head>
</template>
