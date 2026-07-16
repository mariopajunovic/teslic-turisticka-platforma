import { createI18n } from 'vue-i18n'
import { messages } from './messages'
import { deepCyrillic } from './cyr'

// Serbian Cyrillic UI is derived from the Latin messages by transliteration.
const allMessages = {
  ...messages,
  'sr-Cyrl': deepCyrillic(messages.sr),
}

// Maps the shared locale prop (language + script) to a vue-i18n locale key.
export function resolveUiLocale(locale) {
  if (!locale) return 'sr'
  if (locale.language === 'en') return 'en'
  if (locale.language === 'de') return 'de'
  return locale.script === 'cir' ? 'sr-Cyrl' : 'sr'
}

export const i18n = createI18n({
  legacy: false,
  globalInjection: true,
  locale: 'sr',
  fallbackLocale: 'sr',
  messages: allMessages,
})
