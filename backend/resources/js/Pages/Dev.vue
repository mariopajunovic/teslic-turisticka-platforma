<script setup>
import { ref, computed } from 'vue'
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
// F5 kompozitne
import Hero from '@/components/common/Hero.vue'
import CTASection from '@/components/common/CTASection.vue'
import SegmentControl from '@/components/common/SegmentControl.vue'
import Stepper from '@/components/common/Stepper.vue'
import SearchInput from '@/components/common/SearchInput.vue'
import FilterBar from '@/components/common/FilterBar.vue'
import Gallery from '@/components/common/Gallery.vue'
import VideoPlayer from '@/components/common/VideoPlayer.vue'
import InfoPanel from '@/components/common/InfoPanel.vue'
import MiniMap from '@/components/common/MiniMap.vue'
import RelatedContent from '@/components/common/RelatedContent.vue'
import AuthorBlock from '@/components/common/AuthorBlock.vue'
// F6 mapa + F7 kalendar
import MapInteractive from '@/components/map/MapInteractive.vue'
import MapFilterPanel from '@/components/map/MapFilterPanel.vue'
import ResultsList from '@/components/map/ResultsList.vue'
import MapPopup from '@/components/map/MapPopup.vue'
import EventCalendar from '@/components/calendar/EventCalendar.vue'

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

// --- F5 demo state ---
const prikaz = ref('lista')
const upit = ref('')
const filterKat = ref('')
const aktivniFilteri = ref([
  { key: 'kat', label: 'Hrana' },
  { key: 'mjesto', label: 'Borje' },
])
const prikazOpcije = [
  { value: 'lista', label: 'Lista', icon: 'list' },
  { value: 'kalendar', label: 'Kalendar', icon: 'calendar' },
]
const galerija = [
  { src: '', alt: 'Borje 1' },
  { src: '', alt: 'Borje 2', type: 'video' },
  { src: '', alt: 'Banja Vrućica' },
  { src: '', alt: 'Očauš' },
  { src: '', alt: 'Centar' },
  { src: '', alt: 'Festival' },
]
const infoItems = [
  { icon: 'map-pin', label: 'Lokacija', value: 'Planina Borja, Teslić' },
  { icon: 'clock', label: 'Radno vrijeme', value: '08:00 — 20:00' },
  { icon: 'phone', label: 'Telefon', value: '053/430-058', href: 'tel:053430058' },
  { icon: 'ticket', label: 'Ulaznice', value: 'Besplatan ulaz' },
]
const koraci = [
  { title: 'Prijava', text: 'Popunite formu i pošaljite prijavu biznisa ili priče.' },
  { title: 'Pregled', text: 'Administrator pregleda i provjerava prijavu.' },
  { title: 'Objava', text: 'Nakon odobrenja sadržaj je vidljiv posjetiocima.' },
]
const autor = {
  ime: 'Marko Marković',
  bio: 'Lokalni autor i pčelar sa Borja koji piše o domaćinima i tradiciji kraja.',
}
function ukloniFilter(key) {
  aktivniFilteri.value = aktivniFilteri.value.filter((c) => c.key !== key)
}

// --- F6 mapa demo ---
const aktivneKat = ref([])
const odabranPin = ref(null)
const pinovi = [
  { slug: 'banja-vrucica', naslov: 'Banja Vrućica', kategorija: 'smjestaj', lokacija: 'Banja Vrućica', lat: 44.626, lng: 17.861 },
  { slug: 'planina-borja', naslov: 'Planina Borja', kategorija: 'priroda', lokacija: 'Borje', lat: 44.66, lng: 17.79 },
  { slug: 'vrh-ocaus', naslov: 'Vrh Očauš', kategorija: 'priroda', lokacija: 'Očauš', lat: 44.69, lng: 17.81 },
  { slug: 'pcelarstvo-vrucica', naslov: 'Pčelarstvo Vrućica', kategorija: 'hrana', lokacija: 'Banja Vrućica', lat: 44.63, lng: 17.85 },
  { slug: 'stari-zanati-borje', naslov: 'Stari zanati Borje', kategorija: 'zanat', lokacija: 'Borje, Teslić', lat: 44.652, lng: 17.8 },
  { slug: 'servis-teslic', naslov: 'Servis i usluge Teslić', kategorija: 'usluge', lokacija: 'Teslić, centar', lat: 44.6078, lng: 17.8569 },
]
const vidljiviPinovi = computed(() =>
  aktivneKat.value.length === 0
    ? pinovi
    : pinovi.filter((p) => aktivneKat.value.includes(p.kategorija)),
)

// --- F7 kalendar demo ---
const odabraniDan = ref('')
const danEvents = ref([])
const kalEvents = [
  { slug: 'ljeto-na-borju', naslov: 'Ljeto na Borju — festival', date: '2026-06-12', vrijeme: '18:00', lokacija: 'Planina Borja' },
  { slug: 'sajam-meda', naslov: 'Sajam domaćeg meda i rakije', date: '2026-06-12', vrijeme: '10:00', lokacija: 'Trg' },
  { slug: 'izlozba', naslov: 'Izložba zanatlija', date: '2026-06-21', lokacija: 'Galerija' },
  { slug: 'koncert-vrucica', naslov: 'Ljetni koncert', date: '2026-06-28', vrijeme: '20:00', lokacija: 'Banja Vrućica' },
]
function onSelectDay({ events }) {
  danEvents.value = events
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

    <hr class="border-border" />

    <!-- ============ F5: KOMPOZITNE ============ -->
    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Hero — slika-pozadina</h2>
      <Hero
        variant="slika-pozadina"
        kicker="Dobrodošli u Teslić"
        title="Domaće, autentično, blizu"
        subtitle="Otkrijte prirodu, lokalne proizvode i priče kraja oko planine Borje i Banje Vrućice."
      >
        <BaseButton variant="primary" icon="arrow-right" icon-position="right">Istraži ponudu</BaseButton>
        <BaseButton variant="sekundarna">Pridruži se</BaseButton>
      </Hero>

      <h2 class="pt-4 text-xl font-bold text-heading">Hero — split</h2>
      <Hero
        variant="split"
        kicker="Priča sedmice"
        title="Ljudi koji čuvaju duh Teslića"
        subtitle="Domaćini, zanatlije i autori koji svojim radom oblikuju turističku ponudu kraja."
      >
        <BaseButton variant="primary">Pročitaj priču</BaseButton>
      </Hero>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">SegmentControl + SearchInput</h2>
      <div class="flex flex-wrap items-center gap-4">
        <SegmentControl v-model="prikaz" :options="prikazOpcije" />
        <span class="text-sm text-text-muted">Aktivno: {{ prikaz }}</span>
      </div>
      <div class="max-w-md"><SearchInput v-model="upit" placeholder="Pretraži lokalitete…" /></div>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">FilterBar</h2>
      <FilterBar :chips="aktivniFilteri" @clear="aktivniFilteri = []" @remove="ukloniFilter">
        <FormSelect
          v-model="filterKat"
          :options="['Zanat', 'Hrana i piće', 'Usluge']"
          placeholder="Kategorija"
        />
        <SearchInput v-model="upit" placeholder="Pretraga…" />
      </FilterBar>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Galerija + Lightbox</h2>
      <Gallery :items="galerija" />
      <h2 class="pt-4 text-xl font-bold text-heading">VideoPlayer</h2>
      <div class="max-w-xl"><VideoPlayer /></div>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">InfoPanel + MiniMap (dvokolonski)</h2>
      <div class="grid gap-6 sm:grid-cols-2 lg:max-w-2xl">
        <InfoPanel title="Informacije" :items="infoItems">
          <BaseButton variant="primary" icon="send" block>Pošalji upit</BaseButton>
        </InfoPanel>
        <MiniMap label="Planina Borja" />
      </div>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Stepper</h2>
      <Stepper :steps="koraci" />
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">AuthorBlock</h2>
      <AuthorBlock :author="autor" to="/price" />
    </section>

    <section class="space-y-4">
      <RelatedContent title="Povezani sadržaj">
        <BusinessCard v-for="b in biznisi.slice(0, 3)" :key="b.slug" :item="b" />
      </RelatedContent>
    </section>

    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">CTASection</h2>
      <CTASection
        title="Imate biznis ili priču iz Teslića?"
        text="Pridružite se platformi i predstavite svoju ponudu posjetiocima Teslića."
      >
        <BaseButton variant="sekundarna">Registruj biznis</BaseButton>
        <BaseButton variant="secondary">Postani autor</BaseButton>
      </CTASection>
    </section>

    <hr class="border-border" />

    <!-- ============ F6: MAPA ============ -->
    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">Mapa (Leaflet) — FilterPanel + Mapa + Rezultati</h2>
      <div class="grid gap-4 lg:grid-cols-[300px_1fr]">
        <div class="space-y-4">
          <MapFilterPanel v-model="aktivneKat" />
          <ResultsList :items="vidljiviPinovi" @select="odabranPin = $event" />
        </div>
        <MapInteractive
          :items="vidljiviPinovi"
          :active-categories="aktivneKat"
          height="560px"
          @select="odabranPin = $event"
        />
      </div>
      <div v-if="odabranPin" class="max-w-xs">
        <p class="mb-2 text-sm text-text-muted">Odabran pin → MapPopup:</p>
        <MapPopup :item="odabranPin" @close="odabranPin = null" />
      </div>
    </section>

    <hr class="border-border" />

    <!-- ============ F7: KALENDAR ============ -->
    <section class="space-y-4">
      <h2 class="text-xl font-bold text-heading">EventCalendar</h2>
      <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
        <EventCalendar v-model="odabraniDan" :events="kalEvents" @select-day="onSelectDay" />
        <div class="space-y-3">
          <h3 class="font-heading font-semibold text-heading">
            Događaji ({{ odabraniDan || 'odaberi dan' }})
          </h3>
          <p v-if="!danEvents.length" class="text-sm text-text-muted">
            Klikni na dan s tačkom (12, 21, 28. jun) za listu događaja.
          </p>
          <ul v-else class="space-y-2">
            <li
              v-for="e in danEvents"
              :key="e.slug"
              class="rounded-md border border-border bg-surface p-3"
            >
              <p class="font-semibold text-heading">{{ e.naslov }}</p>
              <p class="text-sm text-text-muted">{{ e.vrijeme }} · {{ e.lokacija }}</p>
            </li>
          </ul>
        </div>
      </div>
    </section>
  </AppContainer>
</template>
