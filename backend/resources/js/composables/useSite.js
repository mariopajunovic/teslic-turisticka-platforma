import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import * as fallback from '@/constants/navigation'

export function useSite() {
  const page = usePage()
  const site = computed(() => page.props.site || {})

  return {
    mainNav: computed(() => site.value.mainNav ?? fallback.mainNav),
    secondaryNav: computed(() => site.value.secondaryNav ?? fallback.secondaryNav),
    footerLinks: computed(() => site.value.footerLinks ?? fallback.footerLinks),
    kontakt: computed(() => site.value.kontakt ?? fallback.kontakt),
    postavke: computed(() => site.value.postavke ?? {}),
  }
}
