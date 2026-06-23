<script setup>
// 1:1 prema pencil/01_Pocetna.pen → „Pocetna – KonceptA – Desktop/Mobile".
// Sadržaj (naslovi/opisi/slike) je dio dizajna pa je inline (curated), kao u .pen-u.
import { RouterLink } from 'vue-router'
import AppContainer from '@/components/layout/AppContainer.vue'
import CardGrid from '@/components/layout/CardGrid.vue'
import SectionHeader from '@/components/common/SectionHeader.vue'
import BusinessCard from '@/components/cards/BusinessCard.vue'
import EventCard from '@/components/cards/EventCard.vue'
import StoryCard from '@/components/cards/StoryCard.vue'
import CTASection from '@/components/common/CTASection.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const img = (id) => `https://images.unsplash.com/photo-${id}?auto=format&fit=crop&w=1080&q=80`

const heroImg = img('1574410187921-bca6826880c0')

const kategorije = [
  { label: 'Domaće je najbolje', icon: 'hrana', to: '/domace-je-najbolje' },
  { label: 'Turizam', icon: 'priroda', to: '/turizam' },
  { label: 'Događaji', icon: 'calendar', to: '/dogadjaji' },
  { label: 'Mapa ponude', icon: 'map-pin', to: '/mapa' },
  { label: 'Priče', icon: 'book-open', to: '/price' },
  { label: 'Oglasi', icon: 'briefcase', to: '/oglasi' },
]

const proizvodi = [
  { slug: 'pcelarstvo-borja', naslov: 'Pčelarstvo Borja', opis: 'Domaći bagremov i livadski med sa obronaka Borja.', kategorija: { label: 'Hrana i piće', icon: 'hrana' }, lokacija: 'Borja', slika: img('1619522893151-bb5138b60292') },
  { slug: 'rakija-ocaus', naslov: 'Rakija Očauš', opis: 'Prepečenica i šljiva po starom receptu iz sela pod Očaušem.', kategorija: { label: 'Hrana i piće', icon: 'hrana' }, lokacija: 'Očauš', slika: img('1766388974047-a993ab02d5a9') },
  { slug: 'sirana-vrucica', naslov: 'Sirana Vrućica', opis: 'Mladi i zreli domaći sir od svježeg kravljeg mlijeka.', kategorija: { label: 'Hrana i piće', icon: 'hrana' }, lokacija: 'Banja Vrućica', slika: img('1615932744704-683bbbab07fe') },
  { slug: 'drveni-suveniri', naslov: 'Drveni suveniri', opis: 'Ručno izrađeni predmeti od domaćeg drveta.', kategorija: { label: 'Zanat', icon: 'zanat' }, lokacija: 'Teslić', slika: img('1773612973407-3b65988ce51a') },
]

const preporuceno = [
  { slug: 'med-sa-borja', naslov: 'Med sa Borja — nagrađeni', opis: 'Izbor turističke organizacije za 2026.', kategorija: { label: 'Hrana i piće', icon: 'hrana' }, lokacija: 'Borja', slika: img('1679941279735-b3b35e8bc476'), preporuceno: true },
  { slug: 'banja-vrucica-wellness', naslov: 'Banja Vrućica — wellness', opis: 'Termalni bazeni i odmor uz prirodu.', kategorija: { label: 'Smještaj', icon: 'smjestaj' }, lokacija: 'Banja Vrućica', slika: img('1498110132731-7a56e6f8ccd7'), preporuceno: true },
  { slug: 'etno-selo-borje', naslov: 'Etno selo Borje', opis: 'Autentičan smještaj uz domaću kuhinju.', kategorija: { label: 'Smještaj', icon: 'smjestaj' }, lokacija: 'Borje', slika: img('1706048085718-622d130a3349'), preporuceno: true },
]

const atrakcije = [
  { slug: 'banja-vrucica', naslov: 'Banja Vrućica', opis: 'Termalni izvori i jedan od najvećih spa centara u BiH.', kategorija: { label: 'Smještaj', icon: 'smjestaj' }, lokacija: 'Vrućica', slika: img('1725118342556-6f3ff8588451') },
  { slug: 'planina-borja', naslov: 'Planina Borja', opis: 'Šume, planinarske staze i vidikovci.', kategorija: { label: 'Priroda', icon: 'priroda' }, lokacija: 'Borja', slika: img('1621766299596-2637f1bf6eb9') },
  { slug: 'vrh-ocaus', naslov: 'Vrh Očauš', opis: 'Najviši vrh kraja s panoramskim pogledom.', kategorija: { label: 'Priroda', icon: 'priroda' }, lokacija: 'Očauš', slika: img('1503293317069-f8ea8304b4f9') },
  { slug: 'stari-grad', naslov: 'Stari grad', opis: 'Tragovi prošlosti teslićkog kraja.', kategorija: { label: 'Kultura', icon: 'kultura' }, lokacija: 'Teslić', slika: img('1632945167111-57cde0a03df2') },
]

const dogadjaji = [
  { slug: 'ljetni-festival-2026', naslov: 'Ljetni festival Teslić 2026', dan: '12', mjesec: 'JUL', vrijeme: '19:00', lokacija: 'Centar Teslića', slika: img('1781595452029-400aef872fb0') },
  { slug: 'sajam-domacih-proizvoda', naslov: 'Sajam domaćih proizvoda', dan: '20', mjesec: 'JUL', vrijeme: '10:00', lokacija: 'Banja Vrućica', slika: img('1757609908147-440f77e2af25') },
  { slug: 'planinarski-uspon-ocaus', naslov: 'Planinarski uspon na Očauš', dan: '03', mjesec: 'AVG', vrijeme: '08:00', lokacija: 'Borja', slika: img('1547203928-d8c7cc83e56f') },
  { slug: 'vece-folklora', naslov: 'Veče folklora', dan: '15', mjesec: 'AVG', vrijeme: '20:00', lokacija: 'Vrućica', slika: img('1741376478037-80ae743ace47') },
]

const price = [
  { slug: 'kako-nastaje-med-sa-borja', naslov: 'Kako nastaje med sa Borja', kategorija: { label: 'Domaćini pričaju', icon: 'book-open' }, autor: 'Marko P.', datum: '10.06.2026.', izvod: 'Priča pčelara o životu uz košnice na planini.', slika: img('1736578147442-503d594222b4') },
  { slug: 'banja-vrucica-kroz-generacije', naslov: 'Banja Vrućica kroz generacije', kategorija: { label: 'Ljudi i biznisi', icon: 'book-open' }, autor: 'Jelena S.', datum: '02.06.2026.', izvod: 'Porodična tradicija banjskog turizma.', slika: img('1774876549411-52e4eaff626e') },
  { slug: 'jedan-dan-na-ocausu', naslov: 'Jedan dan na Očaušu', kategorija: { label: 'Naša svakodnevica', icon: 'book-open' }, autor: 'Nikola T.', datum: '28.05.2026.', izvod: 'Uspon, pogled i tišina najvišeg vrha.', slika: img('1706195292026-ae27145ff403') },
]

const galerija = [
  img('1652552888460-334e60915994'),
  img('1611458182018-c043f4e947ec'),
  img('1654156109213-00399ebbd802'),
  img('1725118345125-3ceaa0599620'),
]
</script>

<template>
  <!-- HERO -->
  <section class="bg-surface py-8 md:py-12">
    <AppContainer>
      <div class="relative min-h-[420px] overflow-hidden rounded-2xl bg-primary-darker">
        <img :src="heroImg" alt="" class="absolute inset-0 size-full object-cover" />
        <div class="absolute inset-0" style="background-color: #0a2c27cc"></div>
        <div class="relative max-w-[620px] px-8 py-16 md:px-14 md:py-24">
          <p class="text-sm font-semibold uppercase tracking-[0.1em] text-secondary">
            Dobrodošli u Teslić
          </p>
          <h1
            class="mt-4 font-heading text-[32px] font-bold leading-[1.12] text-white md:text-[46px]"
          >
            Teslić — domaće, autentično, blizu
          </h1>
          <p class="mt-4 max-w-[560px] text-base text-primary-tint md:text-lg">
            Termalna Banja Vrućica, planine Borja i Očauš, domaći proizvodi i ljudi koji ih prave —
            sve na jednom mjestu.
          </p>
          <div class="mt-6 flex flex-wrap gap-3">
            <BaseButton variant="sekundarna" icon="sparkles">Istraži ponudu</BaseButton>
            <RouterLink
              to="/pridruzi-se"
              class="inline-flex h-11 items-center justify-center rounded-sm border-[1.5px] border-white px-5 font-semibold text-white transition-colors hover:bg-white/10"
            >
              Pridruži se
            </RouterLink>
          </div>
        </div>
      </div>
    </AppContainer>
  </section>

  <!-- KATEGORIJE -->
  <section class="bg-surface-alt py-10">
    <AppContainer class="space-y-5">
      <h2 class="font-heading text-[22px] font-bold text-heading md:text-[28px]">
        Istražite po kategoriji
      </h2>
      <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
        <RouterLink
          v-for="k in kategorije"
          :key="k.label"
          :to="k.to"
          class="flex flex-col items-center gap-3 rounded-md border border-border bg-surface px-3 py-5 text-center transition-shadow hover:shadow-[var(--shadow-md)]"
        >
          <span
            class="flex size-12 items-center justify-center rounded-full bg-primary-tint text-primary"
          >
            <BaseIcon :name="k.icon" :size="22" />
          </span>
          <span class="text-sm font-semibold leading-tight text-heading">{{ k.label }}</span>
        </RouterLink>
      </div>
    </AppContainer>
  </section>

  <!-- LOKALNI PROIZVODI -->
  <section class="bg-surface py-12 md:py-16">
    <AppContainer class="space-y-6">
      <SectionHeader
        title="Lokalni proizvodi i usluge"
        link-text="Vidi sve"
        to="/domace-je-najbolje"
      />
      <CardGrid>
        <BusinessCard v-for="p in proizvodi" :key="p.slug" :item="p" />
      </CardGrid>
    </AppContainer>
  </section>

  <!-- PREPORUČENO -->
  <section class="bg-primary-tint py-12 md:py-16">
    <AppContainer class="space-y-6">
      <SectionHeader
        title="Preporučeno iz prve ruke"
        link-text="Vidi sve"
        to="/domace-je-najbolje"
      />
      <CardGrid :cols="3">
        <BusinessCard v-for="p in preporuceno" :key="p.slug" :item="p" />
      </CardGrid>
    </AppContainer>
  </section>

  <!-- ATRAKCIJE -->
  <section class="bg-surface py-12 md:py-16">
    <AppContainer class="space-y-6">
      <SectionHeader title="Turističke atrakcije" link-text="Vidi sve" to="/turizam" />
      <CardGrid>
        <BusinessCard v-for="a in atrakcije" :key="a.slug" :item="a" :to="`/turizam/${a.slug}`" />
      </CardGrid>
    </AppContainer>
  </section>

  <!-- MAPA ISJEČAK -->
  <section class="bg-surface-alt py-12 md:py-16">
    <AppContainer class="space-y-6">
      <SectionHeader title="Istraži na mapi" link-text="Otvori mapu" to="/mapa" />
      <div
        class="flex h-[340px] flex-col items-center justify-center gap-4 rounded-2xl bg-primary-tint px-4 text-center"
      >
        <span class="flex size-16 items-center justify-center rounded-full bg-surface text-primary">
          <BaseIcon name="map-pin" :size="30" />
        </span>
        <p class="text-xl font-semibold text-heading">Interaktivna mapa turističke ponude</p>
        <BaseButton to="/mapa" variant="primary" icon="map">Otvori mapu</BaseButton>
      </div>
    </AppContainer>
  </section>

  <!-- DOGAĐAJI -->
  <section class="bg-surface py-12 md:py-16">
    <AppContainer class="space-y-6">
      <SectionHeader title="Nadolazeći događaji" link-text="Kalendar" to="/dogadjaji" />
      <CardGrid>
        <EventCard v-for="d in dogadjaji" :key="d.slug" :item="d" />
      </CardGrid>
    </AppContainer>
  </section>

  <!-- PRIČE -->
  <section class="bg-surface-alt py-12 md:py-16">
    <AppContainer class="space-y-6">
      <SectionHeader title="Priče iz Teslića" link-text="Sve priče" to="/price" />
      <CardGrid :cols="3">
        <StoryCard v-for="s in price" :key="s.slug" :item="s" />
      </CardGrid>
    </AppContainer>
  </section>

  <!-- GALERIJA -->
  <section class="bg-surface py-12 md:py-16">
    <AppContainer class="space-y-6">
      <SectionHeader title="Galerija" link-text="Vidi sve" to="/price" />
      <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        <img
          v-for="(g, i) in galerija"
          :key="i"
          :src="g"
          alt=""
          loading="lazy"
          class="h-[220px] w-full rounded-md object-cover"
        />
      </div>
    </AppContainer>
  </section>

  <!-- CTA -->
  <section class="bg-surface py-12 md:py-16">
    <AppContainer>
      <CTASection
        title="Pridružite se platformi Teslić"
        text="Predstavite svoj biznis hiljadama posjetilaca ili podijelite svoju priču o teslićkom kraju."
      >
        <BaseButton variant="sekundarna">Registruj biznis</BaseButton>
        <BaseButton variant="secondary">Postani autor</BaseButton>
      </CTASection>
    </AppContainer>
  </section>
</template>
