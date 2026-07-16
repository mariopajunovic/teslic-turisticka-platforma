<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { useTexts } from '@/composables/useTexts'
import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import FormField from '@/components/forms/FormField.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'

const t = useTexts()

const form = useForm({
  role: 'autor',
  name: '',
  email: '',
  telefon: '',
  password: '',
  password_confirmation: '',
  saglasnost: false,
})

function submit() {
  form.post('/register')
}
</script>

<template>
  <section class="bg-surface-alt">
    <AppContainer class="py-12">
      <Breadcrumb
        :items="[
          { label: $t('common.home'), to: '/' },
          { label: $t('action.join'), to: '/pridruzi-se' },
          { label: $t('auth.authorBc') },
        ]"
      />

      <div class="mx-auto mt-6 w-full max-w-[560px] space-y-5 rounded-2xl border border-border bg-surface p-8">
        <div>
          <h1 class="font-heading text-2xl font-bold text-heading">{{ t('reg_autor_naslov', 'Uključi se kao autor') }}</h1>
          <p class="mt-2 text-sm text-text-muted">
            {{ t('reg_autor_uvod', 'Nakon registracije nalog ide na pregled administratora. Priče kreiraš i šalješ na odobrenje nakon prijave.') }}
          </p>
        </div>

        <BaseAlert
          v-if="Object.keys(form.errors).length"
          variant="greska"
          :title="$t('auth.regErrorTitle')"
          :text="$t('auth.regErrorText')"
        />

        <form class="space-y-5" @submit.prevent="submit">
          <FormField v-model="form.name" :label="$t('contact.name')" :error="form.errors.name" />
          <FormField v-model="form.email" :label="$t('contact.email')" type="email" :error="form.errors.email" />
          <FormField v-model="form.telefon" :label="$t('detail.phone')" :error="form.errors.telefon" />
          <FormField
            v-model="form.password"
            :label="$t('auth.password')"
            type="password"
            :error="form.errors.password"
          />
          <FormField
            v-model="form.password_confirmation"
            :label="$t('auth.passwordConfirm')"
            type="password"
          />

          <FormCheckbox
            v-model="form.saglasnost"
            :label="$t('auth.terms')"
          />

          <BaseButton type="submit" variant="primary" block :disabled="form.processing || !form.saglasnost">
            {{ $t('auth.register') }}
          </BaseButton>
        </form>

        <p class="text-center text-sm text-text-muted">
          {{ $t('auth.haveAccount') }}
          <Link href="/prijava" class="font-semibold text-primary hover:underline">{{ $t('action.login') }}</Link>
        </p>
      </div>
    </AppContainer>
  </section>
</template>
