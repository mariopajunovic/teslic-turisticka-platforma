const MAP = {
  DŽ: 'Џ', Dž: 'Џ', dž: 'џ',
  LJ: 'Љ', Lj: 'Љ', lj: 'љ',
  NJ: 'Њ', Nj: 'Њ', nj: 'њ',
  A: 'А', B: 'Б', C: 'Ц', Č: 'Ч', Ć: 'Ћ', D: 'Д', Đ: 'Ђ', E: 'Е', F: 'Ф',
  G: 'Г', H: 'Х', I: 'И', J: 'Ј', K: 'К', L: 'Л', M: 'М', N: 'Н', O: 'О',
  P: 'П', R: 'Р', S: 'С', Š: 'Ш', T: 'Т', U: 'У', V: 'В', Z: 'З', Ž: 'Ж',
  a: 'а', b: 'б', c: 'ц', č: 'ч', ć: 'ћ', d: 'д', đ: 'ђ', e: 'е', f: 'ф',
  g: 'г', h: 'х', i: 'и', j: 'ј', k: 'к', l: 'л', m: 'м', n: 'н', o: 'о',
  p: 'п', r: 'р', s: 'с', š: 'ш', t: 'т', u: 'у', v: 'в', z: 'з', ž: 'ж',
}

const KEYS = Object.keys(MAP).sort((a, b) => b.length - a.length)
const PROTECT = /(<[^>]*>|&[#a-zA-Z0-9]+;|https?:\/\/[^\s"'<>]+|[\w.+-]+@[\w-]+\.[\w.-]+|\{[^}]*\})/u

function mapSegment(text) {
  let out = ''
  for (let i = 0; i < text.length; ) {
    let matched = false
    for (const k of KEYS) {
      if (text.startsWith(k, i)) {
        out += MAP[k]
        i += k.length
        matched = true
        break
      }
    }
    if (!matched) {
      out += text[i]
      i += 1
    }
  }
  return out
}

export function toCyrillic(text) {
  if (typeof text !== 'string' || text === '') return text
  return text
    .split(PROTECT)
    .map((part, idx) => (idx % 2 === 0 ? mapSegment(part) : part))
    .join('')
}

export function deepCyrillic(value) {
  if (typeof value === 'string') return toCyrillic(value)
  if (Array.isArray(value)) return value.map(deepCyrillic)
  if (value && typeof value === 'object') {
    const out = {}
    for (const [k, v] of Object.entries(value)) out[k] = deepCyrillic(v)
    return out
  }
  return value
}
