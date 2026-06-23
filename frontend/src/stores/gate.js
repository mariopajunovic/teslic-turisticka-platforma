import { defineStore } from 'pinia'
import { ref } from 'vue'

// Privremena globalna „kapija" (preview zaštita). NIJE prava sigurnost —
// šifra je u client bundle-u. Za pravu zaštitu koristiti Vercel Edge Middleware.
const KEY = 'to-teslic-gate'
const PASSWORD = import.meta.env.VITE_SITE_PASSWORD || 'teslic2026'

export const useGateStore = defineStore('gate', () => {
  const unlocked = ref(localStorage.getItem(KEY) === '1')

  function unlock(pw) {
    if (pw === PASSWORD) {
      unlocked.value = true
      localStorage.setItem(KEY, '1')
      return true
    }
    return false
  }

  return { unlocked, unlock }
})
