import { ref, computed, onMounted, onUnmounted } from 'vue'

// Reaktivna širina prozora + pomoćni flagovi po breakpointima dizajna.
// Mobile 375 / Tablet 768 / Desktop 1440 (sadržaj ≤1200).
export function useBreakpoint() {
  const width = ref(typeof window !== 'undefined' ? window.innerWidth : 1440)

  const onResize = () => {
    width.value = window.innerWidth
  }

  onMounted(() => window.addEventListener('resize', onResize, { passive: true }))
  onUnmounted(() => window.removeEventListener('resize', onResize))

  const isMobile = computed(() => width.value < 768)
  const isTablet = computed(() => width.value >= 768 && width.value < 1024)
  const isDesktop = computed(() => width.value >= 1024)

  return { width, isMobile, isTablet, isDesktop }
}
