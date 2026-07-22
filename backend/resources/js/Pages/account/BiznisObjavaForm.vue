<script setup>
import { computed } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { biznisNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'
import FormField from '@/components/forms/FormField.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import RichTextField from '@/administracija/components/RichTextField.vue'

const props = defineProps({
  objava: { type: Object, default: null },
  kategorije: { type: Array, default: () => [] },
})

const { tm } = useI18n()
const dani = computed(() => tm('cal.daysFull'))

const praznoVrijeme = () => Array.from({ length: 7 }, () => ({ zatvoreno: false, od: '', do: '' }))

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
    adresa: props.objava?.kontakt?.adresa ?? '',
  },
  drustvene: {
    facebook: props.objava?.drustvene?.facebook ?? '',
    instagram: props.objava?.drustvene?.instagram ?? '',
    youtube: props.objava?.drustvene?.youtube ?? '',
    tiktok: props.objava?.drustvene?.tiktok ?? '',
  },
  usluge: props.objava?.usluge ?? '',
  nacin_placanja: {
    gotovina: props.objava?.nacin_placanja?.gotovina ?? false,
    kartica: props.objava?.nacin_placanja?.kartica ?? false,
    virman: props.objava?.nacin_placanja?.virman ?? false,
  },
  cijena_raspon: props.objava?.cijena_raspon ?? '',
  godina_osnivanja: props.objava?.godina_osnivanja ?? '',
  jib: props.objava?.jib ?? '',
  radno_vrijeme: props.objava?.radno_vrijeme?.length ? props.objava.radno_vrijeme : praznoVrijeme(),
  lat: props.objava?.lat ?? '',
  lng: props.objava?.lng ?? '',
  naslovna: null,
  galerija: [],
  action: 'nacrt',
})

const cijene = [
  { value: '€', label: '€' },
  { value: '€€', label: '€€' },
  { value: '€€€', label: '€€€' },
]

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
          {{ objava ? $t('acc.editPost') : $t('acc.newPost') }}
        </h1>
        <BaseBadge v-if="objava" :variant="objava.status" />
      </div>

      <BaseAlert v-if="$page.props.flash?.status" variant="uspjeh" :title="$t('acc.saved')" :text="$page.props.flash.status" />
      <BaseAlert v-if="form.errors.naslov" variant="greska" :title="$t('acc.checkDataShort')" :text="$t('acc.nameRequired')" />
      <BaseAlert v-if="objava?.vraceno" variant="greska" title="Izmjene su vraćene na doradu">
        <span class="font-semibold text-text">{{ objava.vraceno }}</span>
      </BaseAlert>
      <BaseAlert v-else-if="objava?.imaPending" variant="info" :title="$t('acc.pendingChangesTitle')" :text="$t('acc.pendingChangesText')" />
      <BaseAlert v-else-if="objava?.objavljeno" variant="info" :title="$t('acc.editLiveTitle')" :text="$t('acc.editLiveText')" />

      <!-- Informacije -->
      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <h2 class="font-heading text-lg font-bold text-heading">{{ $t('detail.information') }}</h2>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.naslov" :label="$t('acc.name')" :error="form.errors.naslov" />
          <FormSelect v-model="form.category_id" :label="$t('acc.category')" :placeholder="$t('acc.selectCategory')" :options="kategorije" />
        </div>
        <div class="grid gap-5 md:grid-cols-3">
          <FormField v-model="form.jib" :label="$t('detail.jib')" inputmode="numeric" :error="form.errors.jib" />
          <FormField v-model="form.godina_osnivanja" :label="$t('detail.since')" type="number" />
          <FormSelect v-model="form.cijena_raspon" :label="$t('acc.priceRange')" :options="cijene" :placeholder="'—'" />
        </div>
        <FormField v-model="form.opis" :label="$t('acc.shortDesc')" />
        <div class="space-y-1.5">
          <label class="text-sm font-semibold text-heading">{{ $t('acc.detailedDesc') }}</label>
          <RichTextField
            :model-value="{ sr: form.opis_dug }"
            lang="sr"
            upload-url="/nalog/medij"
            @update:model-value="form.opis_dug = $event.sr ?? ''"
          />
        </div>
        <div>
          <p class="mb-2 text-sm font-semibold text-heading">{{ $t('detail.payment') }}</p>
          <div class="flex flex-wrap gap-5">
            <FormCheckbox v-model="form.nacin_placanja.gotovina" :label="$t('acc.cash')" />
            <FormCheckbox v-model="form.nacin_placanja.kartica" :label="$t('acc.card')" />
            <FormCheckbox v-model="form.nacin_placanja.virman" :label="$t('acc.transfer')" />
          </div>
        </div>
        <FormTextarea v-model="form.usluge" :label="$t('detail.services')" :rows="4" :hint="$t('acc.servicesHint')" />
      </div>

      <!-- Kontakt i mreže -->
      <div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7">
        <h2 class="font-heading text-lg font-bold text-heading">{{ $t('detail.contact') }}</h2>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.lokacija" :label="$t('acc.locationText')" />
          <FormField v-model="form.kontakt.adresa" :label="$t('contact.address')" />
          <FormField v-model="form.kontakt.telefon" :label="$t('detail.phone')" type="tel" />
          <FormField v-model="form.kontakt.email" :label="$t('contact.email')" type="email" />
          <FormField v-model="form.kontakt.web" :label="$t('detail.website')" />
        </div>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.drustvene.facebook" label="Facebook" />
          <FormField v-model="form.drustvene.instagram" label="Instagram" />
          <FormField v-model="form.drustvene.youtube" label="YouTube" />
          <FormField v-model="form.drustvene.tiktok" label="TikTok" />
        </div>
      </div>

      <!-- Radno vrijeme -->
      <div class="space-y-4 rounded-md border border-border bg-surface p-6 md:p-7">
        <h2 class="font-heading text-lg font-bold text-heading">{{ $t('detail.hours') }}</h2>
        <div
          v-for="(dan, i) in form.radno_vrijeme"
          :key="i"
          class="grid grid-cols-[1fr_auto] items-center gap-3 sm:grid-cols-[140px_1fr_1fr_auto]"
        >
          <span class="text-sm font-medium text-heading">{{ dani[i] }}</span>
          <template v-if="!dan.zatvoreno">
            <FormField v-model="dan.od" type="time" class="col-start-1 sm:col-start-2" />
            <FormField v-model="dan.do" type="time" />
          </template>
          <span v-else class="col-start-1 text-sm text-text-muted sm:col-span-2 sm:col-start-2">{{ $t('acc.closed') }}</span>
          <FormCheckbox v-model="dan.zatvoreno" :label="$t('acc.closed')" class="justify-self-end" />
        </div>
      </div>

      <!-- Lokacija na mapi -->
      <div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7">
        <h2 class="font-heading text-lg font-bold text-heading">{{ $t('acc.mapLocation') }}</h2>
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="form.lat" :label="$t('acc.lat')" />
          <FormField v-model="form.lng" :label="$t('acc.lng')" />
        </div>
      </div>

      <!-- Fotografije -->
      <div class="space-y-5 rounded-md border border-border bg-surface p-6 md:p-7">
        <h2 class="font-heading text-lg font-bold text-heading">{{ $t('acc.photos') }}</h2>
        <div class="grid gap-5 md:grid-cols-2">
          <div class="space-y-2">
            <p class="text-sm font-semibold text-heading">{{ $t('acc.cover') }}</p>
            <div class="mb-2 flex h-32 items-center justify-center overflow-hidden rounded-md bg-primary-tint">
              <img v-if="objava?.naslovna" :src="objava.naslovna" alt="" class="size-full object-cover" />
              <BaseIcon v-else name="image" :size="28" class="text-primary-tint-2" />
            </div>
            <input type="file" accept="image/*" @change="onNaslovna" />
          </div>
          <div class="space-y-2">
            <p class="text-sm font-semibold text-heading">{{ $t('acc.addToGallery') }}</p>
            <input type="file" accept="image/*" multiple @change="onGalerija" />
          </div>
        </div>

        <div v-if="objava?.galerija?.length" class="grid grid-cols-3 gap-3 sm:grid-cols-4">
          <div v-for="m in objava.galerija" :key="m.id" class="relative h-28 overflow-hidden rounded-md bg-primary-tint">
            <img :src="m.src" alt="" class="size-full object-cover" />
            <button
              type="button"
              class="absolute right-1.5 top-1.5 inline-flex size-7 items-center justify-center rounded-full bg-surface/90 text-error"
              :aria-label="$t('acc.remove')"
              @click="ukloniMedij(m.id)"
            >
              <BaseIcon name="trash-2" :size="14" />
            </button>
          </div>
        </div>
      </div>

      <div class="flex flex-wrap justify-end gap-3">
        <BaseButton
          v-if="objava?.objavljeno"
          variant="primary"
          icon="send"
          :disabled="form.processing"
          @click="submit('posalji')"
        >
          {{ $t('acc.submitChanges') }}
        </BaseButton>
        <template v-else>
          <BaseButton variant="secondary" icon="save" :disabled="form.processing" @click="submit('nacrt')">
            {{ $t('acc.saveDraft') }}
          </BaseButton>
          <BaseButton variant="primary" icon="send" :disabled="form.processing" @click="submit('posalji')">
            {{ $t('acc.submitApproval') }}
          </BaseButton>
        </template>
      </div>
    </div>
  </AccountLayout>
</template>
