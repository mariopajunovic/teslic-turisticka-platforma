import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  { path: '/', name: 'home', component: () => import('@/views/HomeView.vue') },
  { path: '/o-projektu', name: 'about', component: () => import('@/views/AboutView.vue') },

  {
    path: '/domace-je-najbolje',
    name: 'local',
    component: () => import('@/views/LocalListingView.vue'),
  },
  {
    path: '/domace-je-najbolje/:slug',
    name: 'business',
    component: () => import('@/views/BusinessProfileView.vue'),
  },

  { path: '/turizam', name: 'tourism', component: () => import('@/views/TourismListingView.vue') },
  {
    path: '/turizam/:slug',
    name: 'location',
    component: () => import('@/views/LocationDetailView.vue'),
  },

  { path: '/dogadjaji', name: 'events', component: () => import('@/views/EventsView.vue') },
  {
    path: '/dogadjaji/:slug',
    name: 'event',
    component: () => import('@/views/EventDetailView.vue'),
  },

  { path: '/oglasi', name: 'ads', component: () => import('@/views/AdsListingView.vue') },
  { path: '/oglasi/:slug', name: 'ad', component: () => import('@/views/AdDetailView.vue') },

  { path: '/mapa', name: 'map', component: () => import('@/views/MapView.vue') },

  { path: '/price', name: 'stories', component: () => import('@/views/StoriesListingView.vue') },
  { path: '/price/:slug', name: 'story', component: () => import('@/views/StoryDetailView.vue') },

  { path: '/pridruzi-se', name: 'join', component: () => import('@/views/JoinHubView.vue') },
  {
    path: '/pridruzi-se/biznis',
    name: 'join-business',
    component: () => import('@/views/RegisterBusinessView.vue'),
  },
  {
    path: '/pridruzi-se/autor',
    name: 'join-author',
    component: () => import('@/views/RegisterAuthorView.vue'),
  },

  { path: '/kontakt', name: 'contact', component: () => import('@/views/ContactView.vue') },

  // Nalog / auth (12_Prijava)
  { path: '/prijava', name: 'login', component: () => import('@/views/LoginView.vue') },
  {
    path: '/zaboravljena-lozinka',
    name: 'forgot-password',
    component: () => import('@/views/ForgotPasswordView.vue'),
  },
  { path: '/registracija', name: 'register', component: () => import('@/views/RegisterChoiceView.vue') },

  // Nalog / dashboard (13_Moj-profil) — vlastita ljuska
  {
    path: '/nalog/biznis/profil',
    name: 'biznis-profil',
    component: () => import('@/views/account/BiznisProfilView.vue'),
    meta: { layout: 'account' },
  },
  {
    path: '/nalog/biznis/objave',
    name: 'biznis-objave',
    component: () => import('@/views/account/BiznisObjaveView.vue'),
    meta: { layout: 'account' },
  },
  {
    path: '/nalog/biznis/oglasi',
    name: 'biznis-oglasi',
    component: () => import('@/views/account/BiznisOglasiView.vue'),
    meta: { layout: 'account' },
  },
  {
    path: '/nalog/biznis/mediji',
    name: 'biznis-mediji',
    component: () => import('@/views/account/BiznisMedijiView.vue'),
    meta: { layout: 'account' },
  },
  {
    path: '/nalog/biznis/postavke',
    name: 'biznis-postavke',
    component: () => import('@/views/account/BiznisPostavkeView.vue'),
    meta: { layout: 'account' },
  },
  {
    path: '/nalog/autor/price',
    name: 'autor-price',
    component: () => import('@/views/account/AutorPriceView.vue'),
    meta: { layout: 'account' },
  },
  {
    path: '/nalog/autor/nova-prica',
    name: 'autor-nova-prica',
    component: () => import('@/views/account/AutorNovaPricaView.vue'),
    meta: { layout: 'account' },
  },
  {
    path: '/nalog/autor/profil',
    name: 'autor-profil',
    component: () => import('@/views/account/AutorProfilView.vue'),
    meta: { layout: 'account' },
  },
  {
    path: '/nalog/autor/postavke',
    name: 'autor-postavke',
    component: () => import('@/views/account/AutorPostavkeView.vue'),
    meta: { layout: 'account' },
  },

  {
    path: '/politika-privatnosti',
    name: 'privacy',
    component: () => import('@/views/LegalView.vue'),
    props: { doc: 'privatnost' },
  },
  {
    path: '/politika-kolacica',
    name: 'cookies',
    component: () => import('@/views/LegalView.vue'),
    props: { doc: 'kolacici' },
  },
  {
    path: '/uslovi-koristenja',
    name: 'terms',
    component: () => import('@/views/LegalView.vue'),
    props: { doc: 'uslovi' },
  },

  // Privremena dev ruta — showcase komponenti (ukloniti pred produkciju).
  { path: '/_dev', name: 'dev', component: () => import('@/views/DevView.vue') },

  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: () => import('@/views/NotFoundView.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    return { top: 0 }
  },
})

export default router
