import { ref, watchEffect } from 'vue'

// Generički data-fetch helper nad servisnim slojem (services/api.js).
// `fn` je funkcija koja vraća Promise; pozvati reaktivne izvore UNUTAR fn
// (npr. route.params.slug) da bi se refetch dogodio na njihovu promjenu.
// Vraća { data, loading, error, retry }.
export function useFetch(fn) {
  const data = ref(null)
  const loading = ref(true)
  const error = ref(null)

  async function run(signal) {
    loading.value = true
    error.value = null
    try {
      data.value = await fn({ signal })
    } catch (e) {
      if (e.name !== 'AbortError') error.value = e
    } finally {
      loading.value = false
    }
  }

  watchEffect((onCleanup) => {
    const controller = new AbortController()
    onCleanup(() => controller.abort())
    run(controller.signal)
  })

  function retry() {
    run()
  }

  return { data, loading, error, retry }
}
