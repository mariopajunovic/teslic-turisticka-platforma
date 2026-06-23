<script setup>
// 1:1 prema 12_Prijava.pen → „Prijava – Desktop/Mobile" (+ stanja Greska, NalogNaOdobrenju).
import { ref } from 'vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'
import AppContainer from '@/components/layout/AppContainer.vue'
import FormField from '@/components/forms/FormField.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

// Privremeni demo pristup (dok ne stigne backend → services/api.js)
const DEMO_EMAIL = 'demo@komteldoo.com'
const DEMO_LOZINKA = 'demo'

const route = useRoute()
const router = useRouter()
const email = ref('')
const lozinka = ref('')
const zapamti = ref(false)
// 'default' | 'greska' | 'odobrenje' (?stanje= za pregled stanja)
const stanje = ref(['greska', 'odobrenje'].includes(route.query.stanje) ? route.query.stanje : 'default')

function submit() {
  if (email.value.trim().toLowerCase() === DEMO_EMAIL && lozinka.value === DEMO_LOZINKA) {
    router.push('/nalog/biznis/profil')
  } else {
    stanje.value = 'greska'
  }
}
</script>

<template>
  <section class="bg-surface-alt">
    <AppContainer class="flex min-h-[600px] items-center justify-center py-16">
      <div class="w-full max-w-[420px] space-y-5 rounded-2xl border border-border bg-surface p-8">
        <!-- Zaglavlje -->
        <div v-if="stanje === 'odobrenje'" class="flex items-center justify-between gap-3">
          <h1 class="font-heading text-2xl font-bold text-heading">Prijava</h1>
          <BaseBadge variant="na-odobrenju" />
        </div>
        <h1 v-else class="font-heading text-2xl font-bold text-heading">Prijava</h1>

        <!-- Alert: greška -->
        <div
          v-if="stanje === 'greska'"
          class="flex gap-2.5 rounded-md bg-error-tint p-3.5 text-sm text-error"
          role="alert"
        >
          <BaseIcon name="circle-alert" :size="20" class="mt-0.5 shrink-0" />
          <span>Pogrešan e-mail ili lozinka. Provjerite podatke i pokušajte ponovo.</span>
        </div>

        <!-- Alert: nalog na odobrenju -->
        <div v-if="stanje === 'odobrenje'" class="flex gap-3 rounded-md bg-info-tint p-4">
          <BaseIcon name="clock-3" :size="20" class="mt-0.5 shrink-0 text-info" />
          <div class="space-y-1">
            <p class="text-sm font-semibold text-info">Nalog je na pregledu</p>
            <p class="text-sm text-text">
              Vaš nalog je još na pregledu administratora i biće aktivan nakon odobrenja.
            </p>
          </div>
        </div>

        <FormField
          v-model="email"
          label="E-mail"
          type="email"
          placeholder="marko@primjer.ba"
          :error="stanje === 'greska' ? 'Provjerite unesenu adresu' : ''"
        />
        <FormField
          v-model="lozinka"
          label="Lozinka"
          type="password"
          placeholder="••••••••"
          :error="stanje === 'greska' ? 'Pogrešan e-mail ili lozinka' : ''"
        />

        <div v-if="stanje !== 'odobrenje'" class="flex items-center justify-between">
          <FormCheckbox v-model="zapamti" label="Zapamti me" />
          <RouterLink
            to="/zaboravljena-lozinka"
            class="text-sm font-medium text-primary hover:underline"
          >
            Zaboravljena lozinka?
          </RouterLink>
        </div>

        <BaseButton variant="primary" block @click="submit">Prijava</BaseButton>

        <p v-if="stanje === 'greska'" class="text-[13px] text-text-muted">
          Previše pokušaja — pokušajte ponovo za nekoliko minuta.
        </p>

        <p class="rounded-md bg-info-tint px-3 py-2 text-[13px] text-text">
          <span class="font-semibold">Demo pristup:</span> demo@komteldoo.com / demo
        </p>

        <hr class="border-border" />

        <p class="text-center text-sm text-text-muted">
          Nemaš nalog?
          <RouterLink to="/registracija" class="font-semibold text-primary hover:underline">
            Pridruži se
          </RouterLink>
        </p>
      </div>
    </AppContainer>
  </section>
</template>
