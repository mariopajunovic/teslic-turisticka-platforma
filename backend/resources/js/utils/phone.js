function sanitize(raw) {
  let d = String(raw ?? '').trim().replace(/[^\d+]/g, '')
  if (d.startsWith('00')) d = '+' + d.slice(2)
  return d
}

export function telHref(raw) {
  const d = sanitize(raw)
  return d ? `tel:${d}` : ''
}

export function phoneDisplay(raw) {
  const original = String(raw ?? '').trim()
  if (!original) return ''

  const d = sanitize(raw)

  let national = ''
  if (d.startsWith('+387')) national = '0' + d.slice(4)
  else if (d.startsWith('387')) national = '0' + d.slice(3)
  else if (d.startsWith('0')) national = d
  else national = d.replace(/^\+/, '')

  if (/^0\d{8}$/.test(national)) {
    return `${national.slice(0, 3)}/${national.slice(3, 6)}-${national.slice(6)}`
  }
  if (/^0\d{7}$/.test(national)) {
    return `${national.slice(0, 3)}/${national.slice(3, 5)}-${national.slice(5)}`
  }

  return original
}
