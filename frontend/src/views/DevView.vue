<script setup>
import { ref } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseChip from '@/components/base/BaseChip.vue'
import BaseBadge from '@/components/base/BaseBadge.vue'
import BaseAlert from '@/components/base/BaseAlert.vue'
import FormField from '@/components/forms/FormField.vue'
import FormSelect from '@/components/forms/FormSelect.vue'
import FormTextarea from '@/components/forms/FormTextarea.vue'
import FormCheckbox from '@/components/forms/FormCheckbox.vue'
import FormCaptcha from '@/components/forms/FormCaptcha.vue'
// F4
import BusinessCard from '@/components/cards/BusinessCard.vue'
import LocationCard from '@/components/cards/LocationCard.vue'
import EventCard from '@/components/cards/EventCard.vue'
import AdCard from '@/components/cards/AdCard.vue'
import StoryCard from '@/components/cards/StoryCard.vue'
import StoryFeaturedCard from '@/components/cards/StoryFeaturedCard.vue'
import Skeleton from '@/components/common/Skeleton.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import Pagination from '@/components/common/Pagination.vue'

const ime = ref('')
const kat = ref('')
const poruka = ref('')
const saglasnost = ref(false)
const captcha = ref(false)
const aktivanFilter = ref('med')
const stranica = ref(3)

const filteri = ['med', 'rakija', 'sir']
const buttons = ['primary', 'secondary', 'ghost', 'akcent', 'sekundarna']
const badges = [
  'objavljeno',
  'na-odobrenju',
  'nacrt',
  'isteklo',
  'odbijeno',
  'preporuceno',
  'zavrseno',
]

// --- Mock podaci (ijekavica, lokalni primjeri) ---
const biznisi = [
  {
    slug: 'stari-zanati-borje',
    naslov: 'Stari zanati Borje',
    opis: 'Tradicionalna izrada drvenih suvenira i predmeta domaće radinosti.',
    kategorija: { label: 'Zanat', icon: 'zanat' },
    lokacija: 'Borje, Teslić',
    preporuceno: true,
  },
  {
    slug: 'pcelarstvo-vrucica',
    naslov: 'Pčelarstvo Vrućica',
    opis: 'Domaći med, vosak i pčelinji proizvodi sa obronaka planine Borje.',
    kategorija: { label: 'Hrana', icon: 'hrana' },
    lokacija: 'Banja Vrućica',
  },
  {
    slug: 'rakija-ocaus',
    naslov: 'Rakija Očauš',
    opis: 'Šljivovica i travarica po recepturi koja se prenosi generacijama.',
    kategorija: { label: 'Hrana', icon: 'hrana' },
    lokacija: 'Očauš',
  },
  {
    slug: 'servis-teslic',
    naslov: 'Servis i usluge Teslić',
    opis: 'Pouzdane lokalne usluge i servisi za domaćinstvo i turiste.',
    kategorija: { label: 'Usluge', icon: 'usluge' },
    lokacija: 'Teslić, centar',
  },
]

const lokaliteti = [
  {
    slug: 'planina-borja',
    naslov: 'Planina Borja',
    opis: 'Netaknuta priroda, planinarske staze i vidikovci nadomak grada.',
    kategorija: { label: 'Priroda', icon: 'priroda' },
    lokacija: 'Borja',
    preporuceno: true,
  },
  {
    slug: 'banja-vrucica',
    naslov: 'Banja Vrućica',
    opis: 'Termalna voda i wellness ponuda jedne od najpoznatijih banja.',
    kategorija: { label: 'Smještaj', icon: 'smjestaj' },
    lokacija: 'Banja Vrućica',
  },
  {
    slug: 'vrh-ocaus',
    naslov: 'Vrh Očauš',
    opis: 'Najviši vrh Borja s panoramskim pogledom na cijeli kraj.',
    kategorija: { label: 'Priroda', icon: 'priroda' },
    lokacija: 'Očauš',
  },
]

const dogadjaji = [
  {
    slug: 'ljeto-na-borju',
    naslov: 'Ljeto na Borju — festival',
    dan: '12',
    mjesec: 'JUL',
    vrijeme: '18:00 — 23:00',
    lokacija: 'Planina Borja',
  },
  {
    slug: 'sajam-meda',
    naslov: 'Sajam domaćeg meda i rakije',
    dan: '05',
    mjesec: 'AVG',
    vrijeme: '10:00 — 16:00',
    lokacija: 'Trg, Teslić',
  },
  {
    slug: 'koncert-vrucica',
    naslov: 'Ljetni koncert u Banji Vrućici',
    dan: '20',
    mjesec: 'JUN',
    vrijeme: '20:00',
    lokacija: 'Banja Vrućica',
    zavrseno: true,
  },
]

const oglasi = [
  {
    slug: 'konobar-kardial',
    naslov: 'Traži se konobar — Banja Vrućica',
    vrsta: { label: 'Posao', icon: 'briefcase' },
    izdavac: 'Hotel Kardial',
    lokacija: 'Banja Vrućica',
    rok: '30.06.2026.',
  },
  {
    slug: 'najam-prostora',
    naslov: 'Izdaje se poslovni prostor u centru',
    vrsta: { label: 'Nekretnine', icon: 'building-2' },
    izdavac: 'Privatni oglašivač',
    lokacija: 'Teslić, centar',
    rok: '15.07.2026.',
  },
  {
    slug: 'stari-oglas',
    naslov: 'Sezonski berači (istekao oglas)',
    vrsta: { label: 'Posao', icon: 'briefcase' },
    izdavac: 'OPG Borje',
    lokacija: 'Borje',
    rok: '01.06.2026.',
    isteklo: true,
  },
]

const price = [
  {
    slug: 'pcelarska-prica-borja',
    naslov: 'Kako je nastala pčelarska priča Borja',
    kategorija: { label: 'Domaćini pričaju', icon: 'book-open' },
    autor: 'Marko M.',
    datum: '22.06.2026.',
    izvod: 'Od nekoliko košnica do brenda — priča porodice koja živi od planine.',
  },
  {
    slug: 'zanatlije-teslica',
    naslov: 'Zanatlije koje čuvaju tradiciju',
    kategorija: { label: 'Ljudi i biznisi', icon: 'book-open' },
    autor: 'Ana K.',
    datum: '18.06.2026.',
    izvod: 'Drvo, vuna i glina — majstori čiji rad postaje suvenir Teslića.',
  },
  {
    slug: 'svakodnevica-vrucica',
    naslov: 'Jutro u Banji Vrućici',
    kategorija: { label: 'Naša svakodnevica', icon: 'book-open' },
    autor: 'Redakcija',
    datum: '15.06.2026.',
    izvod: 'Kako izgleda običan dan u jednom od najposjećenijih mjesta kraja.',
  },
]

const featured = {
  slug: 'ljudi-duh-teslica',
  naslov: 'Ljudi koji čuvaju duh Teslića',
  kategorija: { label: 'Izdvojeno', icon: 'star' },
  autor: 'Redakcija',
  datum: '20.06.2026.',
  izvod:
    'Priče domaćina, zanatlija i autora koji svojim radom oblikuju turističku ponudu kraja.',
}
</script>

<template>
  <AppContainer as="main" class="space-y-14 py-12">
    <header>
      <h1 class="text-3xl font-bold text-heading">Komponente — showcase</h1>
      <p class="mt-1 text-text-muted">
        Privremena dev ruta <code>/_dev</code> za vizuelnu provjeru komponenti (F2 atomi + F4
        kartice/stanja).
      </p>
    </header>

    <!-- ============ F2: ATOMI ============ -->
    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Dugmad</h2>
      <div class="flex flex-wrap items-center gap-3">
        <BaseButton
          v-for="v in buttons"
          :key="v"
          :variant="v"
          icon="arrow-right"
          icon-position="right"
        >
          {{ v }}
        </BaseButton>
      </div>
      <div class="flex flex-wrap items-center gap-3">
        <BaseButton v-for="v in buttons" :key="v" :variant="v" size="sm">{{ v }} sm</BaseButton>
        <BaseButton variant="primary" disabled>disabled</BaseButton>
      </div>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Chip / Tag</h2>
      <div class="flex flex-wrap items-center gap-3">
        <BaseChip
          v-for="f in filteri"
          :key="f"
          variant="filter"
          :label="f"
          :active="aktivanFilter === f"
          @click="aktivanFilter = f"
        />
        <BaseChip variant="kategorija" label="Zanat" icon="tag" />
        <BaseChip variant="uklonjiv" label="Borje" />
      </div>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Badge / Status</h2>
      <div class="flex flex-wrap items-center gap-3">
        <BaseBadge v-for="b in badges" :key="b" :variant="b" />
      </div>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Alert / Poruka stanja</h2>
      <div class="grid max-w-xl gap-3">
        <BaseAlert
          variant="uspjeh"
          title="Prijava primljena"
          text="Vaša prijava ide na pregled administratora."
        />
        <BaseAlert variant="greska" title="Greška" text="Molimo provjerite obavezna polja." />
        <BaseAlert variant="info" text="Polja označena zvjezdicom su obavezna." />
      </div>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Forme</h2>
      <div class="grid max-w-xl gap-4">
        <FormField v-model="ime" label="Ime i prezime" placeholder="npr. Marko Marković" required />
        <FormField label="E-mail" type="email" error="Unesite ispravnu e-mail adresu." />
        <FormSelect
          v-model="kat"
          label="Kategorija"
          :options="['Zanat', 'Hrana i piće', 'Usluge']"
          required
        />
        <FormTextarea v-model="poruka" label="Poruka" :maxlength="500" placeholder="Vaša poruka…" />
        <FormCheckbox v-model="saglasnost" required>
          Prihvatam uslove korištenja i obradu podataka
        </FormCheckbox>
        <FormCaptcha v-model="captcha" />
      </div>
    </section>

    <hr class="border-border" />

    <!-- ============ F4: KARTICE ============ -->
    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Kartica/Biznis</h2>
      <CardGrid>
        <BusinessCard v-for="b in biznisi" :key="b.slug" :item="b" />
      </CardGrid>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Kartica/Lokalitet</h2>
      <CardGrid :cols="3">
        <LocationCard v-for="l in lokaliteti" :key="l.slug" :item="l" />
      </CardGrid>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Kartica/Događaj</h2>
      <CardGrid :cols="3">
        <EventCard v-for="d in dogadjaji" :key="d.slug" :item="d" />
      </CardGrid>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Kartica/Oglas</h2>
      <CardGrid :cols="3">
        <AdCard v-for="o in oglasi" :key="o.slug" :item="o" />
      </CardGrid>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Kartica/Priča — Featured</h2>
      <StoryFeaturedCard :item="featured" />
      <h2 class="pt-4 text-xl font-bold text-heading">Kartica/Priča</h2>
      <CardGrid :cols="3">
        <StoryCard v-for="p in price" :key="p.slug" :item="p" />
      </CardGrid>
    </section>

    <hr class="border-border" />

    <!-- ============ F4: STANJA LISTE ============ -->
    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Skeleton (učitavanje)</h2>
      <CardGrid>
        <Skeleton :count="4" />
      </CardGrid>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Prazno stanje</h2>
      <EmptyState
        title="Nema rezultata"
        text="Trenutno nema sadržaja za odabrane filtere. Pokušajte promijeniti pretragu."
      >
        <BaseButton variant="secondary" size="sm">Očisti filtere</BaseButton>
      </EmptyState>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Breadcrumb</h2>
      <Breadcrumb
        :items="[
          { label: 'Početna', to: '/' },
          { label: 'Turizam u Tesliću', to: '/turizam' },
          { label: 'Planina Borja' },
        ]"
      />
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Paginacija (stranica {{ stranica }})</h2>
      <Pagination v-model="stranica" :total="10" />
    </section>
  </AppContainer>
</template>
