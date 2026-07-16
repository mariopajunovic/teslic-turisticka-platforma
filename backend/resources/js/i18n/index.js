import { createI18n } from 'vue-i18n'
import { deepCyrillic } from './cyr'

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
  messages: {},
})

// Applies DB-delivered messages for the active language.
// Serbian Cyrillic is derived from the Latin messages by transliteration.
export function applyMessages(language, messages) {
  if (!language || !messages) return
  i18n.global.setLocaleMessage(language, messages)
  if (language === 'sr') {
    i18n.global.setLocaleMessage('sr-Cyrl', deepCyrillic(messages))
  }
}
