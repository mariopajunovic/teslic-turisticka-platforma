import { usePage } from '@inertiajs/vue3'

export function useTexts() {
  const page = usePage()
  return (key, fallback = '') => page.props.texts?.[key] ?? fallback
}
