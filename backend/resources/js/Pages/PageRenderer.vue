<script setup>
import { Head } from '@inertiajs/vue3'
import BlockHero from '@/components/blocks/BlockHero.vue'
import BlockSectionHeader from '@/components/blocks/BlockSectionHeader.vue'
import BlockRichText from '@/components/blocks/BlockRichText.vue'
import BlockCTA from '@/components/blocks/BlockCTA.vue'
import BlockCardGrid from '@/components/blocks/BlockCardGrid.vue'
import BlockCategoryNav from '@/components/blocks/BlockCategoryNav.vue'
import BlockGallery from '@/components/blocks/BlockGallery.vue'
import BlockVideo from '@/components/blocks/BlockVideo.vue'
import BlockMap from '@/components/blocks/BlockMap.vue'
import BlockSpacer from '@/components/blocks/BlockSpacer.vue'

const props = defineProps({
  page: { type: Object, default: () => ({}) },
  blocks: { type: Array, default: () => [] },
})

const registry = {
  hero: BlockHero,
  section_header: BlockSectionHeader,
  rich_text: BlockRichText,
  cta: BlockCTA,
  card_grid: BlockCardGrid,
  category_nav: BlockCategoryNav,
  gallery: BlockGallery,
  video: BlockVideo,
  map: BlockMap,
  spacer: BlockSpacer,
}
</script>

<template>
  <div class="pb-16">
    <Head :title="page.meta_title || page.title">
      <meta v-if="page.meta_description" name="description" :content="page.meta_description" />
    </Head>

    <template v-for="(block, i) in blocks" :key="i">
      <component
        :is="registry[block.type]"
        v-if="registry[block.type] && (block.data?.visible ?? true)"
        :data="block.data"
      />
    </template>
  </div>
</template>
