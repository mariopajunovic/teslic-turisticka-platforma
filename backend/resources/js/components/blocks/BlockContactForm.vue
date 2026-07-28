<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { useSite } from '@/composables/useSite'
import AppContainer from '@/components/layout/AppContainer.vue'
import MiniMap from '@/components/common/MiniMap.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import FormField from '@/components/forms/FormField.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import FormCaptcha from '@/components/forms/FormCaptcha.vue'

const props = defineProps({ data: { type: Object, default: () => ({}) } })

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
  { icon: 'map-pin', labelKey: 'contact.address', value: kontakt.value.adresa },
  { icon: 'phone', labelKey: 'contact.phone', value: kontakt.value.telefon, href: `tel:${kontakt.value.telefon}` },
  { icon: 'mail', labelKey: 'contact.email', value: kontakt.value.email, href: `mailto:${kontakt.value.email}` },
  { icon: 'clock', labelKey: 'contact.hours', valueKey: 'contact.hoursValue' },
])

const prikaziMapu = computed(() => props.data.prikaziMapu !== false)

function posalji() {
  greska.value = false
  poslano.value = false
  if (!ime.value.trim() || !email.value.trim() || !poruka.value.trim() || !saglasnost.value || !captcha.value) {
    greska.value = true
    return
  }
  router.post(
    '/kontakt',
    { ime: ime.value, email: email.value, tema: tema.value, poruka: poruka.value },
    {
      preserveScroll: true,
      onSuccess: () => {
        poslano.value = true
        ime.value = ''; email.value = ''; tema.value = ''; poruka.value = ''
        saglasnost.value = false; captcha.value = false
      },
      onError: () => { greska.value = true },
    },
  )
}
</script>

<template>
  <AppContainer class="mt-8">
    <div class="grid gap-8 lg:grid-cols-2">
      <div>
        <h2 class="font-heading text-xl font-semibold text-heading">{{ data.naslov || $t('contact.sendMessage') }}</h2>
        <form class="mt-5 space-y-4" @submit.prevent="posalji">
          <BaseAlert v-if="poslano" variant="uspjeh" :title="$t('contact.sentTitle')" :text="$t('contact.sentText')" />
          <BaseAlert v-if="greska" variant="greska" :title="$t('contact.errorTitle')" :text="$t('contact.errorText')" />

          <FormField v-model="ime" :label="$t('contact.name')" :placeholder="$t('contact.namePlaceholder')" required />
          <FormField v-model="email" :label="$t('contact.email')" type="email" :placeholder="$t('contact.emailPlaceholder')" required />
          <FormField v-model="tema" :label="$t('contact.subject')" :placeholder="$t('contact.subjectPlaceholder')" />
          <FormTextarea v-model="poruka" :label="$t('contact.message')" :maxlength="800" :placeholder="$t('contact.messagePlaceholder')" required />
          <FormCheckbox v-model="saglasnost" required>{{ $t('contact.consent') }}</FormCheckbox>
          <FormCaptcha v-model="captcha" />
          <BaseButton type="submit" variant="primary" icon="send">{{ $t('contact.send') }}</BaseButton>
        </form>
      </div>

      <div class="space-y-6">
        <div class="rounded-lg border border-border bg-surface p-6 shadow-[var(--shadow-sm)]">
          <h2 class="font-heading text-xl font-semibold text-heading">{{ $t('contact.orgName') }}</h2>
          <ul class="mt-5 space-y-4">
            <li v-for="info in kontaktInfo" :key="info.labelKey" class="flex items-start gap-3">
              <span class="mt-0.5 shrink-0 text-primary"><BaseIcon :name="info.icon" :size="20" /></span>
              <div>
                <p class="text-sm font-semibold text-heading">{{ $t(info.labelKey) }}</p>
                <a v-if="info.href" :href="info.href" class="text-text-muted hover:text-primary hover:underline">{{ info.value }}</a>
                <p v-else class="text-text-muted">{{ info.valueKey ? $t(info.valueKey) : info.value }}</p>
              </div>
            </li>
          </ul>
        </div>

        <MiniMap v-if="prikaziMapu" label="Svetog Save 15, Teslić" :to="localePath('/mapa')" />
      </div>
    </div>
  </AppContainer>
</template>
