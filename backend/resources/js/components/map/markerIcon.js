const categoryColors = {
  zanat: '#E88828',
  hrana: '#0E8275',
  usluge: '#1C68B5',
  priroda: '#1E7D3C',
  kultura: '#8C5810',
  smjestaj: '#0A645A',
  dogadjaj: '#C8D848',
}

// Kategorije sa svijetlom bojom traže taman simbol radi kontrasta.
const darkSymbol = new Set(['dogadjaj'])

const DEFAULT_COLOR = '#5C6573'

export function categoryColor(categoryKey) {
  return categoryColors[categoryKey] || DEFAULT_COLOR
}

export function categoryIcon(L, categoryKey) {
  const color = categoryColor(categoryKey)
  const dot = darkSymbol.has(categoryKey) ? '#12151C' : '#FFFFFF'

  const html = `
    <span class="map-pin-marker" style="--pin-color:${color}">
      <svg width="32" height="40" viewBox="0 0 32 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M16 0C7.163 0 0 7.163 0 16c0 10.5 16 24 16 24s16-13.5 16-24C32 7.163 24.837 0 16 0z" fill="${color}"/>
        <circle cx="16" cy="16" r="6" fill="${dot}"/>
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
