// Apstrakcija podatkovnog sloja. Danas vraća mock JSON iz src/data/,
// sutra se ovdje samo zamijeni implementacija pravim API pozivima (fetch/axios)
// bez diranja stranica/komponenti.

const delay = (ms = 300) => new Promise((r) => setTimeout(r, ms))

async function load(name) {
  const modules = import.meta.glob('../data/*.json')
  const path = `../data/${name}.json`
  if (!modules[path]) return []
  const mod = await modules[path]()
  return mod.default
}

export const api = {
  async list(resource, { signal } = {}) {
    await delay()
    if (signal?.aborted) throw new DOMException('Aborted', 'AbortError')
    return load(resource)
  },

  async get(resource, slug) {
    await delay()
    const items = await load(resource)
    return items.find((i) => i.slug === slug) || null
  },
}
