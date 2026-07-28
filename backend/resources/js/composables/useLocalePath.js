import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export function useLocalePath() {
  const page = usePage()

  const localePrefix = computed(() => {
    const languages = page.props.locale?.languages ?? []
    return languages.find((l) => l.active)?.prefix ?? ''
  })

  const localePath = (path) => {
    const p = String(path ?? '/')
    const rel = p.startsWith('/') ? p : `/${p}`
    if (!localePrefix.value) {
      return rel
    }
    return `/${localePrefix.value}${rel === '/' ? '' : rel}`
  }

  return { localePath, localePrefix }
}
