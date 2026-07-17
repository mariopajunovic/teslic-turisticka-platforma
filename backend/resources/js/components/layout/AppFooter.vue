<script setup>
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useSite } from '@/composables/useSite'
import AppContainer from './AppContainer.vue'
import BaseIcon from '@/components/base/BaseIcon.vue'

const { footerLinks, kontakt, postavke } = useSite()
const { t } = useI18n()
</script>

<template>
  <footer class="border-t border-border bg-surface">
    <!-- Kolone: 1 (mobile) → 2 (linkovi) → 4 (desktop) -->
    <AppContainer class="py-10 md:py-12">
      <div class="grid gap-8 md:gap-10 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr]">
        <!-- Brend -->
        <div class="max-w-sm">
          <Link href="/" class="inline-block text-2xl font-extrabold tracking-tight text-primary">
            <img v-if="postavke.brandLogo" :src="postavke.brandLogo" :alt="postavke.brandLogoTekst" :style="{ height: (postavke.logoVisina || 40) + 'px' }" class="w-auto" />
            <span v-else>{{ postavke.brandLogoTekst }}</span>
          </Link>
          <p class="mt-3 text-sm leading-relaxed text-text-muted [&_a]:text-primary [&_a]:underline" v-html="postavke.footerOpis"></p>
          <div class="mt-4 flex gap-2">
            <a
              v-for="s in postavke.social || []"
              :key="s.name"
              :href="s.href"
              :aria-label="s.label"
              class="inline-flex size-9 items-center justify-center rounded-full bg-surface-alt text-primary transition-colors hover:bg-primary-tint"
            >
              <BaseIcon :name="s.name" :size="18" />
            </a>
          </div>
        </div>

        <!-- Linkovi (2 kolone na mobilnom u istom redu) -->
        <div class="grid grid-cols-2 gap-8 md:contents">
          <div>
            <h3 class="text-[13px] font-bold uppercase tracking-wider text-text-muted">{{ t('footer.quickLinks') }}</h3>
            <ul class="mt-3 space-y-3">
              <li v-for="l in footerLinks.brzi" :key="l.to">
                <Link :href="l.to" class="text-sm text-text transition-colors hover:text-primary">
                  {{ l.label }}
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h3 class="text-[13px] font-bold uppercase tracking-wider text-text-muted">{{ t('footer.explore') }}</h3>
            <ul class="mt-3 space-y-3">
              <li v-for="l in footerLinks.istrazi" :key="l.to">
                <Link :href="l.to" class="text-sm text-text transition-colors hover:text-primary">
                  {{ l.label }}
                </Link>
              </li>
            </ul>
          </div>
        </div>

        <!-- Kontakt -->
        <div>
          <h3 class="text-[13px] font-bold uppercase tracking-wider text-text-muted">{{ t('footer.contact') }}</h3>
          <ul class="mt-3 space-y-3 text-sm text-text">
            <li class="flex items-start gap-2">
              <BaseIcon name="map-pin" :size="16" class="mt-0.5 shrink-0 text-primary" />
              <span>{{ kontakt.adresa }}</span>
            </li>
            <li class="flex items-start gap-2">
              <BaseIcon name="phone" :size="16" class="mt-0.5 shrink-0 text-primary" />
              <a :href="`tel:${kontakt.telefon}`" class="hover:text-primary">{{ kontakt.telefon }}</a>
            </li>
            <li class="flex items-start gap-2">
              <BaseIcon name="mail" :size="16" class="mt-0.5 shrink-0 text-primary" />
              <a :href="`mailto:${kontakt.email}`" class="break-all hover:text-primary">
                {{ kontakt.email }}
              </a>
            </li>
          </ul>
        </div>
      </div>
    </AppContainer>

    <!-- Partneri -->
    <div v-if="(postavke.partneri || []).length || postavke.partneriTekst" class="bg-surface-alt">
      <AppContainer class="py-7">
        <h3 class="text-xs font-bold uppercase tracking-wider text-text-muted">{{ t('footer.partners') }}</h3>
        <p v-if="postavke.partneriTekst" class="mt-2 text-xs leading-relaxed text-text-muted [&_a]:text-primary [&_a]:underline" v-html="postavke.partneriTekst"></p>
        <div v-if="(postavke.partneri || []).length" class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
          <component
            :is="p.href ? 'a' : 'div'"
            v-for="(p, i) in postavke.partneri || []"
            :key="i"
            :href="p.href || undefined"
            :target="p.href ? '_blank' : undefined"
            :rel="p.href ? 'noopener' : undefined"
            :title="p.naziv"
            class="flex h-24 items-center justify-center rounded-md border border-border bg-surface p-4 text-sm text-text-muted transition-colors hover:border-primary"
          >
            <img v-if="p.logo" :src="p.logo" :alt="p.naziv" class="max-h-16 w-auto object-contain" />
            <span v-else class="truncate text-center">{{ p.naziv }}</span>
          </component>
        </div>
      </AppContainer>
    </div>

    <!-- Pravna traka -->
    <div class="bg-primary-darker">
      <AppContainer
        class="flex flex-col gap-2 py-4 text-[13px] text-primary-tint sm:flex-row sm:items-center sm:justify-between"
      >
        <p class="[&_a]:underline [&_a]:hover:text-white" v-html="postavke.copyright"></p>
        <nav class="flex flex-wrap gap-x-4 gap-y-1">
          <Link
            v-for="l in footerLinks.pravno"
            :key="l.to"
            :href="l.to"
            class="hover:text-white"
          >
            {{ l.label }}
          </Link>
        </nav>
      </AppContainer>
    </div>
  </footer>
</template>
