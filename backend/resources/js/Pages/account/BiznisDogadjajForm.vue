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
  dogadjaj: { type: Object, default: null },
  vrste: { type: Array, default: () => [] },
})

const form = useForm({
  naslov: props.dogadjaj?.naslov ?? '',
  category_id: props.dogadjaj?.category_id ?? null,
  datum: props.dogadjaj?.datum ?? '',
  vrijeme: props.dogadjaj?.vrijeme ?? '',
  lokacija: props.dogadjaj?.lokacija ?? '',
  organizator: props.dogadjaj?.organizator ?? '',
  opis_dug: props.dogadjaj?.opis_dug ?? '',
  action: 'nacrt',
})

function submit(action) {
  form.action = action
  if (props.dogadjaj) {
    form.put(`/nalog/biznis/dogadjaji/${props.dogadjaj.id}`)
  } else {
    form.post('/nalog/biznis/dogadjaji')
  }
}
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div>
        <h1 class="font-heading text-[28px] font-bold text-heading">
          {{ dogadjaj ? $t('acc.editEvent') : $t('acc.newEvent') }}
        </h1>
        <p class="mt-1 text-[15px] text-text-muted">{{ $t('acc.fillEvent') }}</p>
      </div>

      <BaseAlert
        v-if="form.errors.naslov || form.errors.datum"
        variant="greska"
        :title="$t('auth.regErrorTitle')"
        :text="form.errors.datum || $t('acc.titleRequired')"
      />

      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.naslov" :label="$t('acc.title')" :error="form.errors.naslov" />
          <FormSelect
            v-model="form.category_id"
            :label="$t('acc.type')"
            :placeholder="$t('acc.selectType')"
            :options="vrste"
          />
        </div>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.datum" :label="$t('acc.eventDate')" type="date" :error="form.errors.datum" />
          <FormField v-model="form.vrijeme" :label="$t('acc.eventTime')" placeholder="npr. 20:00" />
        </div>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.lokacija" :label="$t('detail.location')" />
          <FormField v-model="form.organizator" :label="$t('detail.organizer')" />
        </div>
        <FormTextarea v-model="form.opis_dug" :label="$t('acc.description')" :rows="6" />
      </div>

      <div class="flex flex-wrap justify-end gap-3">
        <BaseButton variant="secondary" icon="save" :disabled="form.processing" @click="submit('nacrt')">
          {{ $t('acc.saveDraft') }}
        </BaseButton>
        <BaseButton variant="primary" icon="send" :disabled="form.processing" @click="submit('posalji')">
          {{ $t('acc.submitApproval') }}
        </BaseButton>
      </div>
    </div>
  </AccountLayout>
</template>
