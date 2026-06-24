<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import FormField from '@/components/forms/FormField.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'

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
          { label: 'Početna', to: '/' },
          { label: 'Pridruži se', to: '/pridruzi-se' },
          { label: 'Uključi se kao autor' },
        ]"
      />

      <div class="mx-auto mt-6 w-full max-w-[560px] space-y-5 rounded-2xl border border-border bg-surface p-8">
        <div>
          <h1 class="font-heading text-2xl font-bold text-heading">Uključi se kao autor</h1>
          <p class="mt-2 text-sm text-text-muted">
            Nakon registracije nalog ide na pregled administratora. Priče kreiraš i šalješ na
            odobrenje nakon prijave.
          </p>
        </div>

        <BaseAlert
          v-if="Object.keys(form.errors).length"
          variant="greska"
          title="Provjerite unesene podatke"
          text="Neka polja nisu ispravno popunjena."
        />

        <form class="space-y-5" @submit.prevent="submit">
          <FormField v-model="form.name" label="Ime i prezime" :error="form.errors.name" />
          <FormField v-model="form.email" label="E-mail" type="email" :error="form.errors.email" />
          <FormField v-model="form.telefon" label="Telefon" :error="form.errors.telefon" />
          <FormField
            v-model="form.password"
            label="Lozinka"
            type="password"
            :error="form.errors.password"
          />
          <FormField
            v-model="form.password_confirmation"
            label="Potvrda lozinke"
            type="password"
          />

          <FormCheckbox
            v-model="form.saglasnost"
            label="Saglasan/na sam s uslovima korištenja i obradom podataka."
          />

          <BaseButton type="submit" variant="primary" block :disabled="form.processing || !form.saglasnost">
            Registruj se
          </BaseButton>
        </form>

        <p class="text-center text-sm text-text-muted">
          Već imaš nalog?
          <Link href="/prijava" class="font-semibold text-primary hover:underline">Prijavi se</Link>
        </p>
      </div>
    </AppContainer>
  </section>
</template>
