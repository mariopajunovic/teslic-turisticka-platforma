<script setup>
import { useForm } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import FormField from '@/components/forms/FormField.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'

const props = defineProps({
  token: { type: String, default: '' },
  email: { type: String, default: '' },
})

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post('/reset-password', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <section class="bg-surface-alt">
    <AppContainer class="flex min-h-[600px] items-center justify-center py-16">
      <form class="w-full max-w-[420px] space-y-5 rounded-2xl border border-border bg-surface p-8" @submit.prevent="submit">
        <h1 class="font-heading text-2xl font-bold text-heading">Nova lozinka</h1>
        <p class="text-sm leading-relaxed text-text-muted">
          Postavite novu lozinku za nalog {{ form.email }}.
        </p>

        <BaseAlert v-if="form.errors.email" variant="greska" :text="form.errors.email" />

        <FormField
          v-model="form.email"
          label="E-mail adresa"
          type="email"
          disabled
        />
        <FormField
          v-model="form.password"
          label="Nova lozinka"
          type="password"
          placeholder="••••••••"
          required
          :error="form.errors.password"
        />
        <FormField
          v-model="form.password_confirmation"
          label="Potvrdi lozinku"
          type="password"
          placeholder="••••••••"
          required
        />

        <BaseButton type="submit" variant="primary" block :disabled="form.processing">
          Postavi lozinku
        </BaseButton>
        <BaseButton to="/prijava" variant="ghost" block icon="arrow-left">
          Nazad na prijavu
        </BaseButton>
      </form>
    </AppContainer>
  </section>
</template>
