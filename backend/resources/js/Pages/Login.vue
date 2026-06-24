<script setup>
import { computed } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import AppContainer from '@/components/layout/AppContainer.vue'
import FormField from '@/components/forms/FormField.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const page = usePage()
const status = computed(() => page.props.flash?.status)

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <section class="bg-surface-alt">
    <AppContainer class="flex min-h-[600px] items-center justify-center py-16">
      <div class="w-full max-w-[420px] space-y-5 rounded-2xl border border-border bg-surface p-8">
        <h1 class="font-heading text-2xl font-bold text-heading">Prijava</h1>

        <div
          v-if="status"
          class="flex gap-3 rounded-md bg-info-tint p-4 text-sm text-info"
          role="status"
        >
          <BaseIcon name="clock-3" :size="20" class="mt-0.5 shrink-0" />
          <span>{{ status }}</span>
        </div>

        <div
          v-if="form.errors.email"
          class="flex gap-2.5 rounded-md bg-error-tint p-3.5 text-sm text-error"
          role="alert"
        >
          <BaseIcon name="circle-alert" :size="20" class="mt-0.5 shrink-0" />
          <span>{{ form.errors.email }}</span>
        </div>

        <form class="space-y-5" @submit.prevent="submit">
          <FormField
            v-model="form.email"
            label="E-mail"
            type="email"
            placeholder="marko@primjer.ba"
          />
          <FormField
            v-model="form.password"
            label="Lozinka"
            type="password"
            placeholder="••••••••"
          />

          <div class="flex items-center justify-between">
            <FormCheckbox v-model="form.remember" label="Zapamti me" />
            <Link href="/zaboravljena-lozinka" class="text-sm font-medium text-primary hover:underline">
              Zaboravljena lozinka?
            </Link>
          </div>

          <BaseButton type="submit" variant="primary" block :disabled="form.processing">
            Prijava
          </BaseButton>
        </form>

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
