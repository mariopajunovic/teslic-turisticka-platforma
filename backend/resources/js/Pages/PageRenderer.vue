<script setup>
import BlockShell from '@/components/blocks/BlockShell.vue'
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
import BlockStepper from '@/components/blocks/BlockStepper.vue'
import BlockInfoPanel from '@/components/blocks/BlockInfoPanel.vue'
import BlockFaq from '@/components/blocks/BlockFaq.vue'
import BlockStats from '@/components/blocks/BlockStats.vue'
import BlockPartners from '@/components/blocks/BlockPartners.vue'
import BlockFeaturedStory from '@/components/blocks/BlockFeaturedStory.vue'
import BlockAuthor from '@/components/blocks/BlockAuthor.vue'

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
  stepper: BlockStepper,
  info_panel: BlockInfoPanel,
  faq: BlockFaq,
  stats: BlockStats,
  partners: BlockPartners,
  featured_story: BlockFeaturedStory,
  author: BlockAuthor,
}

const isVisible = (block) => !(block.data?.settings?.hidden)
</script>

<template>
  <div class="pb-16">
    <template v-for="(block, i) in blocks" :key="i">
      <BlockShell
        v-if="registry[block.type] && isVisible(block)"
        :settings="block.data?.settings || {}"
      >
        <component :is="registry[block.type]" :data="block.data" />
      </BlockShell>
    </template>
  </div>
</template>
