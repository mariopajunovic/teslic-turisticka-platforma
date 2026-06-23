import { defineStore } from 'pinia'
import { ref } from 'vue'

const STORAGE_KEY = 'to-teslic-cookie-consent'

// Saglasnost za kolačiće (CookieBanner). Trajno u localStorage.
export const useConsentStore = defineStore('consent', () => {
  const accepted = ref(localStorage.getItem(STORAGE_KEY) === 'true')

  function accept() {
    accepted.value = true
    localStorage.setItem(STORAGE_KEY, 'true')
  }

  return { accepted, accept }
})
