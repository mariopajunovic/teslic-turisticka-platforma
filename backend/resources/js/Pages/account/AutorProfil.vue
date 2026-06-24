<script setup>
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { autorNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import FormField from '@/components/forms/FormField.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'

const props = defineProps({
  profil: { type: Object, default: () => ({}) },
})

const form = useForm({
  name: props.profil.name ?? '',
  bio: props.profil.bio ?? '',
  avatar: null,
})

const preview = computed(() => {
  if (form.avatar) return URL.createObjectURL(form.avatar)
  return props.profil.avatar || ''
})

const initials = computed(() =>
  (form.name || '')
    .split(' ')
    .map((p) => p[0])
    .slice(0, 2)
    .join('')
    .toUpperCase(),
)

function onAvatar(e) {
  form.avatar = e.target.files[0] ?? null
}

function submit() {
  form.post('/nalog/autor/profil', { preserveScroll: true })
}
</script>

<template>
  <AccountLayout :items="autorNav">
    <div class="space-y-6">
      <div>
        <h1 class="font-heading text-[28px] font-bold text-heading">Autorski profil</h1>
        <p class="mt-1 text-[15px] text-text-muted">Vaše javne informacije kao autora priča.</p>
      </div>

      <BaseAlert v-if="$page.props.flash?.status" variant="uspjeh" title="Sačuvano" :text="$page.props.flash.status" />

      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <div class="flex items-center gap-5">
          <span class="size-18 shrink-0 overflow-hidden rounded-full bg-primary-tint">
            <img v-if="preview" :src="preview" alt="" class="size-full object-cover" />
            <span v-else class="flex size-full items-center justify-center text-2xl font-bold text-primary">
              {{ initials }}
            </span>
          </span>
          <label class="cursor-pointer">
            <span class="inline-flex items-center rounded-sm border border-border px-3 py-2 text-sm font-semibold text-heading hover:bg-surface-alt">
              Promijeni fotografiju
            </span>
            <input type="file" accept="image/*" class="hidden" @change="onAvatar" />
          </label>
        </div>

        <FormField v-model="form.name" label="Ime i prezime" :error="form.errors.name" />
        <FormTextarea v-model="form.bio" label="Biografija" :rows="4" :maxlength="1000" />

        <div class="flex justify-end">
          <BaseButton variant="primary" icon="check" :disabled="form.processing" @click="submit">
            Sačuvaj profil
          </BaseButton>
        </div>
      </div>
    </div>
  </AccountLayout>
</template>
