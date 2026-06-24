<script setup>
import { computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import FormField from '@/components/forms/FormField.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'

const page = usePage()
const status = computed(() => page.props.flash?.status)
const user = computed(() => page.props.auth?.user || {})

const profil = useForm({
  name: user.value.name ?? '',
  email: user.value.email ?? '',
})

const lozinka = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

function sacuvajProfil() {
  profil.put('/user/profile-information', { preserveScroll: true })
}

function promijeniLozinku() {
  lozinka.put('/user/password', {
    preserveScroll: true,
    onSuccess: () => lozinka.reset(),
  })
}
</script>

<template>
  <div class="space-y-6">
    <div>
      <h1 class="font-heading text-[28px] font-bold text-heading">Postavke</h1>
      <p class="mt-1 text-[15px] text-text-muted">Upravljajte podacima naloga i lozinkom.</p>
    </div>

    <BaseAlert v-if="status" variant="uspjeh" title="Sačuvano" :text="status" />

    <div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7">
      <h2 class="font-heading text-lg font-bold text-heading">E-mail adresa</h2>
      <p class="text-[13px] text-text-muted">Ime, telefon i ostale podatke uređujete na stranici „Moj profil".</p>
      <FormField v-model="profil.email" label="E-mail" type="email" :error="profil.errors.email" />
      <div class="flex justify-end">
        <BaseButton variant="primary" icon="check" :disabled="profil.processing" @click="sacuvajProfil">
          Sačuvaj e-mail
        </BaseButton>
      </div>
    </div>

    <div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7">
      <h2 class="font-heading text-lg font-bold text-heading">Promjena lozinke</h2>
      <FormField
        v-model="lozinka.current_password"
        label="Trenutna lozinka"
        type="password"
        :error="lozinka.errors.current_password"
      />
      <div class="grid gap-5 md:grid-cols-2">
        <FormField
          v-model="lozinka.password"
          label="Nova lozinka"
          type="password"
          :error="lozinka.errors.password"
        />
        <FormField
          v-model="lozinka.password_confirmation"
          label="Potvrdi novu lozinku"
          type="password"
          helper="Najmanje 8 znakova"
        />
      </div>
      <div class="flex justify-end">
        <BaseButton variant="secondary" icon="key" :disabled="lozinka.processing" @click="promijeniLozinku">
          Promijeni lozinku
        </BaseButton>
      </div>
    </div>
  </div>
</template>
