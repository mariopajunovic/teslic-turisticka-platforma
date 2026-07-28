<script setup>
import { computed } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'

const props = defineProps({
  seo: { type: Object, default: () => ({}) },
})

const page = usePage()

const data = computed(() => {
  const s = props.seo || {}
  const postavke = page.props.site?.postavke || {}
  const brandNaziv = postavke.brandNaziv || 'TO Teslić'
  return {
    title: s.title ? `${s.title} - ${brandNaziv}` : brandNaziv,
    description:
      s.description ||
      postavke.seoOpis ||
      'Digitalna platforma za promociju turizma, domaćih proizvoda i usluga opštine Teslić.',
    canonical: s.canonical || '',
    image: s.image || postavke.ogDefaultImage || '',
    type: s.type || 'website',
  }
})

const robots = computed(() =>
  page.props.site?.postavke?.indeksiranje === false ? 'noindex, nofollow' : 'index, follow',
)

const locale = computed(() => page.props.locale || {})

const hreflangMap = { sr: 'sr', en: 'en', de: 'de' }

const alternates = computed(() =>
  Object.entries(locale.value.alternates || {}).map(([lang, href]) => ({
    hreflang: hreflangMap[lang] || lang,
    href,
  })),
)

const defaultAlternate = computed(() => locale.value.alternates?.sr || '')

const ogLocale = computed(() => (locale.value.htmlLang || 'sr-Latn').replace('-', '_'))

const jsonLdString = computed(() => (props.seo?.jsonLd ? JSON.stringify(props.seo.jsonLd) : ''))
</script>

<template>
  <Head :title="data.title">
    <meta name="robots" :content="robots" head-key="robots" />
    <meta name="description" :content="data.description" head-key="description" />
    <link v-if="data.canonical" rel="canonical" :href="data.canonical" head-key="canonical" />
    <meta property="og:title" :content="data.title" head-key="og:title" />
    <meta property="og:description" :content="data.description" head-key="og:description" />
    <meta property="og:type" :content="data.type" head-key="og:type" />
    <meta v-if="data.canonical" property="og:url" :content="data.canonical" head-key="og:url" />
    <meta v-if="data.image" property="og:image" :content="data.image" head-key="og:image" />
    <meta v-if="data.image" name="twitter:image" :content="data.image" head-key="twitter:image" />
    <meta property="og:locale" :content="ogLocale" head-key="og:locale" />
    <meta name="twitter:card" :content="data.image ? 'summary_large_image' : 'summary'" head-key="twitter:card" />
    <link
      v-for="a in alternates"
      :key="a.hreflang"
      rel="alternate"
      :hreflang="a.hreflang"
      :href="a.href"
      :head-key="'alt-' + a.hreflang"
    />
    <link v-if="defaultAlternate" rel="alternate" hreflang="x-default" :href="defaultAlternate" head-key="alt-x-default" />
    <component :is="'script'" v-if="jsonLdString" type="application/ld+json" v-html="jsonLdString" />
  </Head>
</template>
