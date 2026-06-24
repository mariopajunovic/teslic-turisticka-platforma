<script setup>
import { useForm } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import FormField from '@/components/forms/FormField.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'

const props = defineProps({
  oglas: { type: Object, default: null },
  vrste: { type: Array, default: () => [] },
})

const form = useForm({
  naslov: props.oglas?.naslov ?? '',
  category_id: props.oglas?.category_id ?? null,
  izdavac: props.oglas?.izdavac ?? '',
  lokacija: props.oglas?.lokacija ?? '',
  rok: props.oglas?.rok ?? '',
  opis_dug: props.oglas?.opis_dug ?? '',
  action: 'nacrt',
})

function submit(action) {
  form.action = action
  if (props.oglas) {
    form.put(`/nalog/biznis/oglasi/${props.oglas.id}`)
  } else {
    form.post('/nalog/biznis/oglasi')
  }
}
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div>
        <h1 class="font-heading text-[28px] font-bold text-heading">
          {{ oglas ? 'Uredi oglas' : 'Novi oglas' }}
        </h1>
        <p class="mt-1 text-[15px] text-text-muted">Popunite oglas i pošaljite ga na odobrenje.</p>
      </div>

      <BaseAlert
        v-if="form.errors.naslov"
        variant="greska"
        title="Provjerite unesene podatke"
        text="Naslov je obavezan."
      />

      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.naslov" label="Naslov" :error="form.errors.naslov" />
          <FormSelect
            v-model="form.category_id"
            label="Vrsta"
            placeholder="Odaberite vrstu"
            :options="vrste"
          />
        </div>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.izdavac" label="Izdavač" />
          <FormField v-model="form.lokacija" label="Lokacija" />
        </div>
        <FormField v-model="form.rok" label="Rok važenja" type="date" />
        <FormTextarea v-model="form.opis_dug" label="Opis" :rows="6" />
      </div>

      <div class="flex flex-wrap justify-end gap-3">
        <BaseButton variant="secondary" icon="save" :disabled="form.processing" @click="submit('nacrt')">
          Sačuvaj nacrt
        </BaseButton>
        <BaseButton variant="primary" icon="send" :disabled="form.processing" @click="submit('posalji')">
          Pošalji na odobrenje
        </BaseButton>
      </div>
    </div>
  </AccountLayout>
</template>
