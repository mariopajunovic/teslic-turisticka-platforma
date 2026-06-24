<script setup>
import { useForm } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { autorNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import FormField from '@/components/forms/FormField.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'

const props = defineProps({
  story: { type: Object, default: null },
  kategorije: { type: Array, default: () => [] },
})

const form = useForm({
  naslov: props.story?.naslov ?? '',
  category_id: props.story?.category_id ?? null,
  izvod: props.story?.izvod ?? '',
  sadrzaj: props.story?.sadrzaj ?? '',
  action: 'nacrt',
})

function submit(action) {
  form.action = action
  if (props.story) {
    form.put(`/nalog/autor/price/${props.story.id}`)
  } else {
    form.post('/nalog/autor/price')
  }
}
</script>

<template>
  <AccountLayout :items="autorNav">
    <div class="space-y-6">
      <div>
        <h1 class="font-heading text-[28px] font-bold text-heading">
          {{ story ? 'Uredi priču' : 'Nova priča' }}
        </h1>
        <p class="mt-1 text-[15px] text-text-muted">
          Napišite priču i pošaljite je na odobrenje administratoru.
        </p>
      </div>

      <BaseAlert
        v-if="Object.keys(form.errors).length"
        variant="greska"
        title="Provjerite unesene podatke"
        text="Naslov je obavezan."
      />

      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.naslov" label="Naslov" :error="form.errors.naslov" />
          <FormSelect
            v-model="form.category_id"
            label="Kategorija"
            placeholder="Odaberite kategoriju"
            :options="kategorije"
          />
        </div>

        <FormTextarea v-model="form.izvod" label="Kratak izvod" :rows="2" />
        <FormTextarea v-model="form.sadrzaj" label="Sadržaj priče" :rows="10" />
      </div>

      <div class="flex flex-wrap justify-end gap-3">
        <BaseButton
          variant="secondary"
          icon="save"
          :disabled="form.processing"
          @click="submit('nacrt')"
        >
          Sačuvaj nacrt
        </BaseButton>
        <BaseButton
          variant="primary"
          icon="send"
          :disabled="form.processing"
          @click="submit('posalji')"
        >
          Pošalji na odobrenje
        </BaseButton>
      </div>
    </div>
  </AccountLayout>
</template>
