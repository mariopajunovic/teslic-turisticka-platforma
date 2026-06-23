// Struktura glavne navigacije (header/footer). Dropdown sekcije imaju `children`.
export const mainNav = [
  {
    label: 'Domaće je najbolje',
    to: '/domace-je-najbolje',
    children: [
      { label: 'Zanatski proizvodi', to: '/domace-je-najbolje?kategorija=zanat' },
      { label: 'Domaća hrana i piće', to: '/domace-je-najbolje?kategorija=hrana' },
      { label: 'Usluge i servisi', to: '/domace-je-najbolje?kategorija=usluge' },
    ],
  },
  {
    label: 'Turizam',
    to: '/turizam',
    children: [
      { label: 'Prirodne atrakcije', to: '/turizam?kategorija=priroda' },
      { label: 'Kulturne manifestacije', to: '/turizam?kategorija=kultura' },
      { label: 'Planine, šume i sela', to: '/turizam?kategorija=planine' },
      { label: 'Gdje odsjesti', to: '/turizam?kategorija=smjestaj' },
    ],
  },
  { label: 'Događaji', to: '/dogadjaji' },
  { label: 'Oglasi', to: '/oglasi' },
  { label: 'Mapa', to: '/mapa' },
  {
    label: 'Priče',
    to: '/price',
    children: [
      { label: 'Domaćini pričaju', to: '/price?kategorija=domacini' },
      { label: 'Ljudi i biznisi', to: '/price?kategorija=ljudi' },
      { label: 'Naša svakodnevica', to: '/price?kategorija=svakodnevica' },
    ],
  },
]

// Sekundarna navigacija — gornja (util) traka headera.
export const secondaryNav = [
  { label: 'O projektu', to: '/o-projektu' },
  { label: 'Kontakt', to: '/kontakt' },
]

// Footer kolone (brzi linkovi / istraži / kontakt info)
export const footerLinks = {
  brzi: [
    { label: 'Početna', to: '/' },
    { label: 'O projektu', to: '/o-projektu' },
    { label: 'Događaji', to: '/dogadjaji' },
    { label: 'Pridruži se', to: '/pridruzi-se' },
  ],
  istrazi: [
    { label: 'Domaće je najbolje', to: '/domace-je-najbolje' },
    { label: 'Turizam', to: '/turizam' },
    { label: 'Mapa ponude', to: '/mapa' },
    { label: 'Priče', to: '/price' },
  ],
  pravno: [
    { label: 'Politika privatnosti', to: '/politika-privatnosti' },
    { label: 'Politika kolačića', to: '/politika-kolacica' },
    { label: 'Uslovi korištenja', to: '/uslovi-koristenja' },
  ],
}

export const kontakt = {
  adresa: 'Svetog Save 15, 74270 Teslić',
  telefon: '053/430-058',
  email: 'turistorg.teslic@gmail.com',
}
