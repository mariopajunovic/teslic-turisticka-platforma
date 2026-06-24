<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import FormField from '@/components/forms/FormField.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const DEMO_EMAIL = 'demo@komteldoo.com'
const DEMO_LOZINKA = 'demo'

const props = defineProps({
  stanje: { type: String, default: 'default' },
})

const email = ref('')
const lozinka = ref('')
const zapamti = ref(false)
const stanjeLocal = ref(['greska', 'odobrenje'].includes(props.stanje) ? props.stanje : 'default')

function submit() {
  if (email.value.trim().toLowerCase() === DEMO_EMAIL && lozinka.value === DEMO_LOZINKA) {
    router.visit('/nalog/biznis/profil')
  } else {
    stanjeLocal.value = 'greska'
  }
}
</script>

<template>
  <section class="bg-surface-alt">
    <AppContainer class="flex min-h-[600px] items-center justify-center py-16">
      <div class="w-full max-w-[420px] space-y-5 rounded-2xl border border-border bg-surface p-8">
        <div v-if="stanjeLocal === 'odobrenje'" class="flex items-center justify-between gap-3">
          <h1 class="font-heading text-2xl font-bold text-heading">Prijava</h1>
          <BaseBadge variant="na-odobrenju" />
        </div>
        <h1 v-else class="font-heading text-2xl font-bold text-heading">Prijava</h1>

        <div
          v-if="stanjeLocal === 'greska'"
          class="flex gap-2.5 rounded-md bg-error-tint p-3.5 text-sm text-error"
          role="alert"
        >
          <BaseIcon name="circle-alert" :size="20" class="mt-0.5 shrink-0" />
          <span>Pogrešan e-mail ili lozinka. Provjerite podatke i pokušajte ponovo.</span>
        </div>

        <div v-if="stanjeLocal === 'odobrenje'" class="flex gap-3 rounded-md bg-info-tint p-4">
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
          :error="stanjeLocal === 'greska' ? 'Provjerite unesenu adresu' : ''"
        />
        <FormField
          v-model="lozinka"
          label="Lozinka"
          type="password"
          placeholder="••••••••"
          :error="stanjeLocal === 'greska' ? 'Pogrešan e-mail ili lozinka' : ''"
        />

        <div v-if="stanjeLocal !== 'odobrenje'" class="flex items-center justify-between">
          <FormCheckbox v-model="zapamti" label="Zapamti me" />
          <Link
            href="/zaboravljena-lozinka"
            class="text-sm font-medium text-primary hover:underline"
          >
            Zaboravljena lozinka?
          </Link>
        </div>

        <BaseButton variant="primary" block @click="submit">Prijava</BaseButton>

        <p v-if="stanjeLocal === 'greska'" class="text-[13px] text-text-muted">
          Previše pokušaja — pokušajte ponovo za nekoliko minuta.
        </p>

        <p class="rounded-md bg-info-tint px-3 py-2 text-[13px] text-text">
          <span class="font-semibold">Demo pristup:</span> demo@komteldoo.com / demo
        </p>

        <hr class="border-border" />

        <p class="text-center text-sm text-text-muted">
          Nemaš nalog?
          <Link href="/registracija" class="font-semibold text-primary hover:underline">
            Pridruži se
          </Link>
        </p>
      </div>
    </AppContainer>
  </section>
</template>
