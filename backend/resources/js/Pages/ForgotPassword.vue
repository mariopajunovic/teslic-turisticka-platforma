<script setup>
import { useLocalePath } from '@/composables/useLocalePath'
const { localePath } = useLocalePath()
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
          <FormField v-model="email" :label="$t('contact.email')" type="email" :placeholder="$t('auth.emailPlaceholder')" />
          <BaseButton variant="primary" block @click="poslano = true">
            {{ $t('auth.sendReset') }}
          </BaseButton>
          <BaseButton :to="localePath('/prijava')" variant="ghost" block icon="arrow-left">
            {{ $t('auth.backToLogin') }}
          </BaseButton>
        </template>

        <template v-else>
          <h1 class="font-heading text-2xl font-bold text-heading">{{ $t('auth.checkEmail') }}</h1>
          <BaseAlert
            variant="uspjeh"
            :title="$t('auth.linkSent')"
            :text="$t('auth.linkSentText')"
          />
          <p class="text-[13px] leading-relaxed text-text-muted">
            {{ $t('auth.noEmailHelp') }}
          </p>
          <BaseButton :to="localePath('/prijava')" variant="ghost" block icon="arrow-left">
            {{ $t('auth.backToLogin') }}
          </BaseButton>
        </template>
      </div>
    </AppContainer>
  </section>
</template>
