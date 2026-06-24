<script setup>
// 1:1 → „Autor – NovaPrica".
import { ref } from 'vue'
import AccountLayout from '@/components/layout/AccountLayout.vue'
import { autorNav } from '@/constants/account'
import BaseButton from '@/components/base/BaseButton.vue'
import FormField from '@/components/forms/FormField.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import RichEditor from '@/components/account/RichEditor.vue'
import UploadBox from '@/components/account/UploadBox.vue'

const naslov = ref('')
const kategorija = ref('Priče iz kraja')
const biznis = ref('Pčelarstvo Đukić — Borje')
const lokacija = ref('Borje')
const dogadjaj = ref('')
</script>

<template>
  <AccountLayout :items="autorNav">
    <div class="space-y-6">
      <div>
        <h1 class="font-heading text-[28px] font-bold text-heading">Nova priča</h1>
        <p class="mt-1 text-[15px] text-text-muted">
          Napišite priču i pošaljite je na odobrenje administratoru.
        </p>
      </div>

      <div class="space-y-6 rounded-md border border-border bg-surface p-6 md:p-7">
        <div class="grid gap-5 md:grid-cols-2">
          <FormField v-model="naslov" label="Naslov" placeholder="npr. Borje — gdje med ima ukus planine" />
          <FormSelect
            v-model="kategorija"
            label="Kategorija"
            :options="['Priče iz kraja', 'Domaćini pričaju', 'Ljudi i biznisi', 'Naša svakodnevica']"
          />
        </div>

        <div class="space-y-1.5">
          <p class="text-sm font-semibold text-heading">Sadržaj priče</p>
          <RichEditor />
        </div>

        <div class="space-y-1.5">
          <p class="text-sm font-semibold text-heading">Galerija fotografija</p>
          <UploadBox title="Dodajte fotografije za priču" hint="JPG ili PNG, do 5 MB po fotografiji" />
        </div>

        <div class="space-y-3 border-t border-border pt-6">
          <div>
            <h2 class="font-heading text-lg font-bold text-heading">Poveži sa</h2>
            <p class="text-sm text-text-muted">
              Povežite priču sa biznisom, lokacijom ili događajem iz Teslića.
            </p>
          </div>
          <div class="grid gap-5 md:grid-cols-3">
            <FormSelect v-model="biznis" label="Biznis" :options="['Pčelarstvo Đukić — Borje', 'Sirana Vrućica']" />
            <FormSelect v-model="lokacija" label="Lokacija" :options="['Borje', 'Banja Vrućica', 'Očauš']" />
            <FormSelect v-model="dogadjaj" label="Događaj" placeholder="Odaberite događaj" :options="['Ljetni festival Teslić 2026', 'Sajam domaćih proizvoda']" />
          </div>
        </div>
      </div>

      <div class="flex flex-wrap justify-end gap-3">
        <BaseButton variant="secondary" icon="save">Sačuvaj nacrt</BaseButton>
        <BaseButton variant="primary" icon="send">Pošalji na odobrenje</BaseButton>
      </div>
    </div>
  </AccountLayout>
</template>
