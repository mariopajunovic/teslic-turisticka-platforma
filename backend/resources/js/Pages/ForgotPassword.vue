<script setup>
// 1:1 prema 12_Prijava.pen → „ZaboravljenaLozinka – Desktop/Mobile/Uspjeh".
import { ref } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import FormField from '@/components/forms/FormField.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import { useTexts } from '@/composables/useTexts'

const t = useTexts()
const email = ref('')
const poslano = ref(false)
</script>

<template>
  <section class="bg-surface-alt">
    <AppContainer class="flex min-h-[600px] items-center justify-center py-16">
      <div class="w-full max-w-[420px] space-y-5 rounded-2xl border border-border bg-surface p-8">
        <template v-if="!poslano">
          <h1 class="font-heading text-2xl font-bold text-heading">{{ t('zaboravljena_naslov', 'Zaboravljena lozinka') }}</h1>
          <p class="text-sm leading-relaxed text-text-muted">
            {{ t('zaboravljena_uvod', 'Unesite e-mail adresu vašeg naloga i poslaćemo vam link za postavljanje nove lozinke.') }}
          </p>
          <FormField v-model="email" label="E-mail" type="email" placeholder="marko@primjer.ba" />
          <BaseButton variant="primary" block @click="poslano = true">
            Pošalji link za reset
          </BaseButton>
          <BaseButton to="/prijava" variant="ghost" block icon="arrow-left">
            Nazad na prijavu
          </BaseButton>
        </template>

        <template v-else>
          <h1 class="font-heading text-2xl font-bold text-heading">Provjerite e-mail</h1>
          <BaseAlert
            variant="uspjeh"
            title="Link je poslan"
            text="Link za resetovanje lozinke je poslan na vašu e-mail adresu."
          />
          <p class="text-[13px] leading-relaxed text-text-muted">
            Niste primili e-mail? Provjerite spam folder ili pokušajte ponovo za nekoliko minuta.
          </p>
          <BaseButton to="/prijava" variant="ghost" block icon="arrow-left">
            Nazad na prijavu
          </BaseButton>
        </template>
      </div>
    </AppContainer>
  </section>
</template>
