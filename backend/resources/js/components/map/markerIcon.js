// Fallback boje po ključu (ako kategorija u bazi nema `color`).
const categoryColors = {
  zanat: '#E88828',
  hrana: '#0E8275',
  usluge: '#1C68B5',
  priroda: '#1E7D3C',
  kultura: '#8C5810',
  planine: '#5E8C1E',
  smjestaj: '#0A645A',
  dogadjaj: '#C8D848',
}

const DEFAULT_COLOR = '#5C6573'

// Lucide putanje (24×24) po nazivu ikone (DB `icon`) — crtaju se unutar pina.
const iconPaths = {
  zanat:
    '<path d="m15 12-8.373 8.373a1 1 0 1 1-3-3L12 9"/><path d="m18 15 4-4"/><path d="m21.5 11.5-1.914-1.914A2 2 0 0 1 19 8.172V7l-2.26-2.26a6 6 0 0 0-4.202-1.756L9 2.96l.92.82A6.18 6.18 0 0 1 12 8.4V10l2 2h1.172a2 2 0 0 1 1.414.586L18.5 14.5"/>',
  hrana:
    '<path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/><path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/><path d="m2.1 21.8 6.4-6.3"/><path d="m19 5-7 7"/>',
  usluge:
    '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
  priroda:
    '<path d="M10 10v.2A3 3 0 0 1 8.9 16H5a3 3 0 0 1-1-5.8V10a3 3 0 0 1 6 0Z"/><path d="M7 16v6"/><path d="M13 19v3"/><path d="M12 19h8.3a1 1 0 0 0 .7-1.7L18 14h.3a1 1 0 0 0 .7-1.7L16 9h.2a1 1 0 0 0 .8-1.7L13 3l-1.4 1.5"/>',
  kultura:
    '<line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><line x1="10" x2="10" y1="18" y2="11"/><line x1="14" x2="14" y1="18" y2="11"/><line x1="18" x2="18" y1="18" y2="11"/><polygon points="12 2 20 7 4 7"/>',
  leaf:
    '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
  smjestaj:
    '<path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/>',
  dogadjaj:
    '<path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/>',
}

export function categoryColor(categoryKey) {
  return categoryColors[categoryKey] || DEFAULT_COLOR
}

// Svijetla pozadina → tamni simbol (i obratno) — kontrast iz same boje.
export function isLightColor(hex) {
  const c = String(hex || '').replace('#', '')
  if (c.length < 6) return false
  const r = parseInt(c.slice(0, 2), 16)
  const g = parseInt(c.slice(2, 4), 16)
  const b = parseInt(c.slice(4, 6), 16)
  return 0.299 * r + 0.587 * g + 0.114 * b > 150
}

// opts: { color, icon } — oboje iz baze (Category.color / Category.icon).
export function categoryIcon(L, opts = {}) {
  const color = opts.color || categoryColor(opts.icon) || DEFAULT_COLOR
  const symbol = isLightColor(color) ? '#12151C' : '#FFFFFF'
  const paths = iconPaths[opts.icon]

  const inner = paths
    ? `<g transform="translate(8 7.5) scale(0.6667)" fill="none" stroke="${symbol}" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">${paths}</g>`
    : `<circle cx="16" cy="16" r="6" fill="${symbol}"/>`

  const html = `
    <span class="map-pin-marker" style="--pin-color:${color}">
      <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M16 0C7.163 0 0 7.163 0 16c0 10.5 16 24 16 24s16-13.5 16-24C32 7.163 24.837 0 16 0z" fill="${color}"/>
        ${inner}
      </svg>
    </span>
  `

  return L.divIcon({
    html,
    className: 'map-pin-divicon',
    iconSize: [32, 40],
    iconAnchor: [16, 40],
    popupAnchor: [0, -38],
  })
}
