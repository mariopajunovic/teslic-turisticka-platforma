// Kategorije ponude — ikona (BaseIcon naziv) + boja pina za mapu.
export const categories = [
  { key: 'zanat', label: 'Zanatski proizvodi', icon: 'zanat' },
  { key: 'hrana', label: 'Hrana i piće', icon: 'hrana' },
  { key: 'usluge', label: 'Usluge i servisi', icon: 'usluge' },
  { key: 'priroda', label: 'Prirodne atrakcije', icon: 'priroda' },
  { key: 'kultura', label: 'Kultura', icon: 'kultura' },
  { key: 'smjestaj', label: 'Smještaj', icon: 'smjestaj' },
  { key: 'dogadjaj', label: 'Događaji', icon: 'dogadjaj' },
]

export const categoryByKey = Object.fromEntries(categories.map((c) => [c.key, c]))
