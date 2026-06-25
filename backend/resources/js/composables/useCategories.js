import { usePage } from '@inertiajs/vue3'

export function useCategories() {
  const page = usePage()
  // Kategorije se dijele globalno pod `site` (SiteData), uz fallback na top-level prop.
  const categories = page.props.site?.kategorije || page.props.kategorije || []
  const categoryByKey = Object.fromEntries(categories.map((c) => [c.key, c]))
  return { categories, categoryByKey }
}
