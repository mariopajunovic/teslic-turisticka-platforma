<script setup>
import { router, useForm } from '@inertiajs/vue3'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import FormField from '@/components/forms/FormField.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'

const props = defineProps({
  objava: { type: Object, default: null },
  kategorije: { type: Array, default: () => [] },
})

const form = useForm({
  naslov: props.objava?.naslov ?? '',
  category_id: props.objava?.category_id ?? null,
  opis: props.objava?.opis ?? '',
  opis_dug: props.objava?.opis_dug ?? '',
  lokacija: props.objava?.lokacija ?? '',
  kontakt: {
    telefon: props.objava?.kontakt?.telefon ?? '',
    email: props.objava?.kontakt?.email ?? '',
    web: props.objava?.kontakt?.web ?? '',
    radnoVrijeme: props.objava?.kontakt?.radnoVrijeme ?? '',
    adresa: props.objava?.kontakt?.adresa ?? '',
  },
  lat: props.objava?.lat ?? '',
  lng: props.objava?.lng ?? '',
  naslovna: null,
  galerija: [],
  action: 'nacrt',
})

function onNaslovna(e) {
  form.naslovna = e.target.files[0] ?? null
}
function onGalerija(e) {
  form.galerija = Array.from(e.target.files)
}

function submit(action) {
  form.action = action
  const url = props.objava ? `/nalog/biznis/objave/${props.objava.id}` : '/nalog/biznis/objave'
  form.post(url, { preserveScroll: true })
}

function ukloniMedij(id) {
  router.delete(`/nalog/biznis/objave/medij/${id}`, { preserveScroll: true })
}
</script>

<template>
  <AccountLayout :items="biznisNav">
    <div class="space-y-6">
      <div class="flex items-center gap-3">
        <h1 class="font-heading text-[28px] font-bold text-heading">
          {{ objava ? 'Uredi objavu' : 'Nova objava' }}
        </h1>
        <BaseBadge v-if="objava" :variant="objava.status" />
      </div>

      <BaseAlert v-if="$page.props.flash?.status" variant="uspjeh" title="Sačuvano" :text="$page.props.flash.status" />
      <BaseAlert v-if="form.errors.naslov" variant="greska" title="Provjerite podatke" text="Naziv je obavezan." />

      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.naslov" label="Naziv" :error="form.errors.naslov" />
          <FormSelect v-model="form.category_id" label="Kategorija" placeholder="Odaberite kategoriju" :options="kategorije" />
        </div>
        <FormField v-model="form.opis" label="Kratak opis" />
        <FormTextarea v-model="form.opis_dug" label="Detaljan opis" :rows="5" />

        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.lokacija" label="Lokacija (tekst)" />
          <FormField v-model="form.kontakt.adresa" label="Adresa" />
        </div>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.kontakt.telefon" label="Telefon" type="tel" />
          <FormField v-model="form.kontakt.email" label="E-mail" type="email" />
        </div>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.kontakt.web" label="Web" />
          <FormField v-model="form.kontakt.radnoVrijeme" label="Radno vrijeme" />
        </div>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.lat" label="Geo. širina (lat)" />
          <FormField v-model="form.lng" label="Geo. dužina (lng)" />
        </div>
      </div>

      <div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7">
        <h2 class="font-heading text-lg font-bold text-heading">Fotografije</h2>
        <div class="grid gap-5 md:grid-cols-2">
          <div class="space-y-2">
            <p class="text-sm font-semibold text-heading">Naslovna</p>
            <div class="mb-2 flex h-32 items-center justify-center overflow-hidden rounded-md bg-primary-tint">
              <img v-if="objava?.naslovna" :src="objava.naslovna" alt="" class="size-full object-cover" />
              <BaseIcon v-else name="image" :size="28" class="text-primary-tint-2" />
            </div>
            <input type="file" accept="image/*" @change="onNaslovna" />
          </div>
          <div class="space-y-2">
            <p class="text-sm font-semibold text-heading">Dodaj u galeriju</p>
            <input type="file" accept="image/*" multiple @change="onGalerija" />
          </div>
        </div>

        <div v-if="objava?.galerija?.length" class="grid grid-cols-3 gap-3 sm:grid-cols-4">
          <div v-for="m in objava.galerija" :key="m.id" class="relative h-28 overflow-hidden rounded-md bg-primary-tint">
            <img :src="m.src" alt="" class="size-full object-cover" />
            <button
              type="button"
              class="absolute right-1.5 top-1.5 inline-flex size-7 items-center justify-center rounded-full bg-surface/90 text-error"
              aria-label="Ukloni"
              @click="ukloniMedij(m.id)"
            >
              <BaseIcon name="trash-2" :size="14" />
            </button>
          </div>
        </div>
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
