<script setup>
import { ref, computed } from 'vue'
import { useSite } from '@/composables/useSite'
import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import MiniMap from '@/components/common/MiniMap.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import FormField from '@/components/forms/FormField.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import FormCaptcha from '@/components/forms/FormCaptcha.vue'

const ime = ref('')
const email = ref('')
const tema = ref('')
const poruka = ref('')
const saglasnost = ref(false)
const captcha = ref(false)

const poslano = ref(false)
const greska = ref(false)

const { kontakt } = useSite()

const kontaktInfo = computed(() => [
  { icon: 'map-pin', label: 'Adresa', value: kontakt.value.adresa },
  { icon: 'phone', label: 'Telefon', value: kontakt.value.telefon, href: `tel:${kontakt.value.telefon}` },
  { icon: 'mail', label: 'E-mail', value: kontakt.value.email, href: `mailto:${kontakt.value.email}` },
  { icon: 'clock', label: 'Radno vrijeme', value: 'Pon–Pet 08:00–16:00' },
])

function posalji() {
  greska.value = false
  poslano.value = false
  if (!ime.value.trim() || !email.value.trim() || !poruka.value.trim() || !saglasnost.value || !captcha.value) {
    greska.value = true
    return
  }
  // Slanje je placeholder — pravi API poziv dolazi kasnije.
  poslano.value = true
  ime.value = ''
  email.value = ''
  tema.value = ''
  poruka.value = ''
  saglasnost.value = false
  captcha.value = false
}
</script>

<template>
  <main class="pb-12 md:pb-16">
    <AppContainer class="pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'Kontakt' }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <h1 class="font-heading text-3xl font-bold text-heading md:text-4xl">Kontakt</h1>
      <p class="mt-2 max-w-2xl text-text-muted">
        Imate pitanje, prijedlog ili želite saradnju? Pošaljite nam poruku ili nas kontaktirajte
        direktno.
      </p>
    </AppContainer>

    <AppContainer class="mt-8">
      <div class="grid gap-8 lg:grid-cols-2">
        <!-- Forma -->
        <div>
          <h2 class="font-heading text-xl font-semibold text-heading">Pošaljite poruku</h2>
          <form class="mt-5 space-y-4" @submit.prevent="posalji">
            <BaseAlert
              v-if="poslano"
              variant="uspjeh"
              title="Poruka je poslana"
              text="Hvala na poruci! Javit ćemo vam se u najkraćem mogućem roku."
            />
            <BaseAlert
              v-if="greska"
              variant="greska"
              title="Provjerite obavezna polja"
              text="Molimo popunite ime, e-mail i poruku te potvrdite saglasnost i captchu."
            />

            <FormField v-model="ime" label="Ime i prezime" placeholder="npr. Marko Marković" required />
            <FormField
              v-model="email"
              label="E-mail"
              type="email"
              placeholder="vasa@adresa.com"
              required
            />
            <FormField v-model="tema" label="Tema / predmet" placeholder="O čemu se radi?" />
            <FormTextarea
              v-model="poruka"
              label="Poruka"
              :maxlength="800"
              placeholder="Vaša poruka…"
              required
            />
            <FormCheckbox v-model="saglasnost" required>
              Saglasan/na sam s obradom mojih podataka radi odgovora na upit.
            </FormCheckbox>
            <FormCaptcha v-model="captcha" />
            <BaseButton type="submit" variant="primary" icon="send">Pošalji</BaseButton>
          </form>
        </div>

        <!-- Kontakt info + mapa -->
        <div class="space-y-6">
          <div class="rounded-lg border border-border bg-surface p-6 shadow-[var(--shadow-sm)]">
            <h2 class="font-heading text-xl font-semibold text-heading">
              Turistička organizacija Teslić
            </h2>
            <ul class="mt-5 space-y-4">
              <li v-for="info in kontaktInfo" :key="info.label" class="flex items-start gap-3">
                <span class="mt-0.5 shrink-0 text-primary"><BaseIcon :name="info.icon" :size="20" /></span>
                <div>
                  <p class="text-sm font-semibold text-heading">{{ info.label }}</p>
                  <a
                    v-if="info.href"
                    :href="info.href"
                    class="text-text-muted hover:text-primary hover:underline"
                  >
                    {{ info.value }}
                  </a>
                  <p v-else class="text-text-muted">{{ info.value }}</p>
                </div>
              </li>
            </ul>
          </div>

          <MiniMap label="Svetog Save 15, Teslić" to="/mapa" />
        </div>
      </div>
    </AppContainer>
  </main>
</template>
