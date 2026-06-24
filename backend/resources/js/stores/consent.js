import { defineStore } from 'pinia'
import { ref } from 'vue'

const STORAGE_KEY = 'to-teslic-cookie-consent'

const hasStorage = () => typeof localStorage !== 'undefined'

export const useConsentStore = defineStore('consent', () => {
  const accepted = ref(hasStorage() && localStorage.getItem(STORAGE_KEY) === 'true')

  function accept() {
    accepted.value = true
    if (hasStorage()) localStorage.setItem(STORAGE_KEY, 'true')
  }

  return { accepted, accept }
})
