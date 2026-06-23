<script setup>
import { computed } from 'vue'
import AppContainer from '@/components/layout/AppContainer.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'

const props = defineProps({
  doc: { type: String, default: 'privatnost' },
})

const dokumenti = {
  privatnost: {
    naslov: 'Politika privatnosti',
    uvod:
      'Ova politika opisuje kako platforma turističke ponude Teslić prikuplja, koristi i štiti lične podatke korisnika.',
    sekcije: [
      {
        h: 'Koje podatke prikupljamo',
        p: 'Prikupljamo podatke koje nam dobrovoljno dostavite putem kontakt forme ili prilikom registracije biznisa ili autorskog naloga (ime, e-mail adresa, kontakt podaci) te osnovne tehničke podatke o korištenju platforme.',
      },
      {
        h: 'Svrha obrade',
        p: 'Podatke koristimo isključivo radi odgovaranja na upite, objavljivanja i upravljanja sadržajem koji ste prijavili te poboljšanja rada platforme.',
      },
      {
        h: 'Čuvanje i dijeljenje',
        p: 'Podatke čuvamo onoliko dugo koliko je potrebno za navedene svrhe i ne dijelimo ih s trećim stranama osim kada to nalaže zakon.',
      },
      {
        h: 'Vaša prava',
        p: 'Imate pravo na pristup, ispravak i brisanje svojih podataka. Za ostvarivanje ovih prava obratite nam se putem kontakt forme.',
      },
    ],
  },
  kolacici: {
    naslov: 'Politika kolačića',
    uvod:
      'Platforma koristi kolačiće (cookies) kako bi osigurala ispravan rad i bolje korisničko iskustvo.',
    sekcije: [
      {
        h: 'Šta su kolačići',
        p: 'Kolačići su male tekstualne datoteke koje se pohranjuju na vašem uređaju prilikom posjete web stranici.',
      },
      {
        h: 'Vrste kolačića koje koristimo',
        p: 'Koristimo neophodne kolačiće za osnovne funkcije platforme te analitičke kolačiće za razumijevanje načina korištenja sadržaja.',
      },
      {
        h: 'Upravljanje kolačićima',
        p: 'Kolačiće možete u svakom trenutku onemogućiti ili obrisati u postavkama svog internet pregledača. Napominjemo da to može uticati na funkcionalnost platforme.',
      },
    ],
  },
  uslovi: {
    naslov: 'Uslovi korištenja',
    uvod:
      'Korištenjem platforme turističke ponude Teslić prihvatate sljedeće uslove korištenja.',
    sekcije: [
      {
        h: 'Korištenje sadržaja',
        p: 'Sadržaj platforme namijenjen je informisanju posjetilaca o turističkoj i privrednoj ponudi Teslića. Zabranjena je zloupotreba sadržaja u nezakonite svrhe.',
      },
      {
        h: 'Objava sadržaja',
        p: 'Korisnici koji objavljuju sadržaj (biznisi, autori) odgovorni su za tačnost i zakonitost objavljenih informacija. Administrator zadržava pravo pregleda i uklanjanja neprimjerenog sadržaja.',
      },
      {
        h: 'Odgovornost',
        p: 'Platforma se trudi osigurati tačnost informacija, ali ne preuzima odgovornost za eventualne greške ili promjene u ponudi pojedinih subjekata.',
      },
      {
        h: 'Izmjene uslova',
        p: 'Zadržavamo pravo izmjene ovih uslova. Aktuelna verzija uvijek je dostupna na ovoj stranici.',
      },
    ],
  },
}

const dok = computed(() => dokumenti[props.doc] || dokumenti.privatnost)
</script>

<template>
  <main class="pb-12 md:pb-16">
    <AppContainer class="pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: dok.naslov }]" />
    </AppContainer>

    <AppContainer class="mt-6">
      <article class="max-w-3xl">
        <h1 class="font-heading text-3xl font-bold text-heading md:text-4xl">{{ dok.naslov }}</h1>
        <p class="mt-4 text-lg text-text-muted">{{ dok.uvod }}</p>

        <section v-for="sekcija in dok.sekcije" :key="sekcija.h" class="mt-8">
          <h2 class="font-heading text-xl font-semibold text-heading">{{ sekcija.h }}</h2>
          <p class="mt-3 text-text-muted">{{ sekcija.p }}</p>
        </section>

        <p class="mt-10 text-sm text-text-muted">
          Napomena: ovo je preliminarni tekst i bit će dopunjen konačnom pravnom verzijom.
        </p>
      </article>
    </AppContainer>
  </main>
</template>
