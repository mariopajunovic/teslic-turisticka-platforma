<script setup>
import AppContainer from '@/components/layout/AppContainer.vue'
import Hero from '@/components/common/Hero.vue'
import Breadcrumb from '@/components/common/Breadcrumb.vue'
import CTASection from '@/components/common/CTASection.vue'
import BaseButton from '@/components/base/BaseButton.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const ciljevi = [
  {
    icon: 'store',
    title: 'Promocija lokalne ponude',
    text: 'Vidljivost domaćih proizvoda, usluga i atrakcija Teslića na jednom mjestu.',
  },
  {
    icon: 'sparkles',
    title: 'Vidljivost biznisa',
    text: 'Mali proizvođači i obrti dobijaju moderan profil i dolaze do posjetilaca.',
  },
  {
    icon: 'book-open',
    title: 'Autentične priče',
    text: 'Priče domaćina, zanatlija i autora koje oslikavaju duh kraja.',
  },
  {
    icon: 'user',
    title: 'Profili subjekata',
    text: 'Detaljni profili biznisa i lokaliteta s kontaktima, galerijom i mapom.',
  },
  {
    icon: 'map',
    title: 'Interaktivna mapa',
    text: 'Pregled cjelokupne ponude na mapi — brzo pronalaženje sadržaja u blizini.',
  },
  {
    icon: 'compass',
    title: 'Samostalno upravljanje',
    text: 'Subjekti samostalno objavljuju i ažuriraju svoje sadržaje uz pregled administratora.',
  },
]

const publika = [
  {
    icon: 'users',
    title: 'Posjetioci',
    text: 'Istražite prirodu, smještaj, događaje i domaću ponudu Teslića na jednom mjestu.',
    cta: 'Istraži ponudu',
    to: '/turizam',
  },
  {
    icon: 'store',
    title: 'Biznisi',
    text: 'Predstavite svoj proizvod ili uslugu i dođite do novih kupaca i gostiju.',
    cta: 'Registruj biznis',
    to: '/pridruzi-se/biznis',
  },
  {
    icon: 'pen',
    title: 'Autori',
    text: 'Pišite priče o ljudima, mjestima i tradiciji kraja i podijelite ih sa svijetom.',
    cta: 'Postani autor',
    to: '/pridruzi-se/autor',
  },
]

const partneri = [
  'Turistička organizacija Teslić',
  'Opština Teslić',
  'Banja Vrućica',
  'Lokalni proizvođači',
]
</script>

<template>
  <main class="pb-12 md:pb-16">
    <Hero
      variant="split"
      kicker="O projektu"
      title="Platforma turističke ponude Teslića"
      subtitle="Jedinstveno mjesto koje povezuje posjetioce, lokalne biznise i autore — i predstavlja sve što Teslić nudi."
    />

    <AppContainer class="pt-8">
      <Breadcrumb :items="[{ label: 'Početna', to: '/' }, { label: 'O projektu' }]" />
    </AppContainer>

    <!-- Misija i svrha -->
    <section class="py-12 md:py-16">
      <AppContainer>
        <div class="max-w-3xl">
          <h2 class="font-heading text-2xl font-bold text-heading md:text-3xl">Misija i svrha</h2>
          <p class="mt-4 text-lg text-text-muted">
            Cilj platforme je da na modernom i preglednom mjestu objedini turističku i privrednu
            ponudu Teslića. Želimo da posjetioci lako pronađu prirodu, smještaj, događaje i domaće
            proizvode, a da lokalni domaćini i biznisi dobiju vidljivost koju zaslužuju.
          </p>
          <p class="mt-4 text-lg text-text-muted">
            Posebnu pažnju posvećujemo autentičnim pričama kraja — ljudima, zanatima i tradiciji koji
            čine Teslić prepoznatljivim.
          </p>
        </div>
      </AppContainer>
    </section>

    <!-- Ciljevi projekta -->
    <section class="bg-surface-alt py-12 md:py-16">
      <AppContainer>
        <h2 class="font-heading text-2xl font-bold text-heading md:text-3xl">Ciljevi projekta</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <div
            v-for="cilj in ciljevi"
            :key="cilj.title"
            class="rounded-md border border-border bg-surface p-6 shadow-[var(--shadow-sm)]"
          >
            <span
              class="flex size-12 items-center justify-center rounded-md bg-primary-tint text-primary"
            >
              <BaseIcon :name="cilj.icon" :size="24" />
            </span>
            <h3 class="mt-4 text-lg font-semibold text-heading">{{ cilj.title }}</h3>
            <p class="mt-2 text-sm text-text-muted">{{ cilj.text }}</p>
          </div>
        </div>
      </AppContainer>
    </section>

    <!-- Kome je namijenjena -->
    <section class="py-12 md:py-16">
      <AppContainer>
        <h2 class="font-heading text-2xl font-bold text-heading md:text-3xl">
          Kome je namijenjena
        </h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
          <div
            v-for="grupa in publika"
            :key="grupa.title"
            class="flex flex-col rounded-lg border border-border bg-surface p-6 shadow-[var(--shadow-sm)]"
          >
            <span
              class="flex size-14 items-center justify-center rounded-full bg-primary text-white"
            >
              <BaseIcon :name="grupa.icon" :size="26" />
            </span>
            <h3 class="mt-4 text-xl font-semibold text-heading">{{ grupa.title }}</h3>
            <p class="mt-2 flex-1 text-text-muted">{{ grupa.text }}</p>
            <BaseButton
              variant="secondary"
              size="sm"
              icon="arrow-right"
              icon-position="right"
              :to="grupa.to"
              class="mt-5 self-start"
            >
              {{ grupa.cta }}
            </BaseButton>
          </div>
        </div>
      </AppContainer>
    </section>

    <!-- Nosilac i partneri -->
    <section class="bg-surface-alt py-12 md:py-16">
      <AppContainer>
        <h2 class="font-heading text-2xl font-bold text-heading md:text-3xl">Nosilac i partneri</h2>
        <p class="mt-4 max-w-3xl text-text-muted">
          Platformu vodi Turistička organizacija Teslić u saradnji s lokalnom zajednicom,
          proizvođačima i institucijama koje podržavaju razvoj turizma kraja.
        </p>
        <div class="mt-8 flex flex-wrap gap-4">
          <div
            v-for="p in partneri"
            :key="p"
            class="flex h-20 min-w-[180px] flex-1 items-center justify-center rounded-md border border-border bg-surface px-6 text-center text-sm font-semibold text-text-muted"
          >
            {{ p }}
          </div>
        </div>
      </AppContainer>
    </section>

    <!-- CTA -->
    <section class="py-12 md:py-16">
      <AppContainer>
        <CTASection
          title="Pridružite se platformi"
          text="Predstavite svoj biznis ili podijelite priču iz Teslića."
        >
          <BaseButton variant="sekundarna" to="/pridruzi-se">Pridruži se</BaseButton>
        </CTASection>
      </AppContainer>
    </section>
  </main>
</template>
