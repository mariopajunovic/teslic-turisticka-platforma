import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export function useSite() {
  const page = usePage()
  const site = computed(() => page.props.site || {})

  return {
    mainNav: computed(() => site.value.mainNav ?? []),
    secondaryNav: computed(() => site.value.secondaryNav ?? []),
    footerLinks: computed(() => site.value.footerLinks ?? { brzi: [], istrazi: [], pravno: [] }),
    kontakt: computed(() => site.value.kontakt ?? {}),
    postavke: computed(() => site.value.postavke ?? {}),
  }
}
