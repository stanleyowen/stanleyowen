export const locales = ["en", "zh"] as const;
export type Locale = (typeof locales)[number];

/** Used when the visitor hasn't picked a language yet. */
export const defaultLocale: Locale = "en";

/** Cookie the language switch writes and proxy.ts reads. */
export const LOCALE_COOKIE = "lang";
export const LOCALE_COOKIE_MAX_AGE = 60 * 60 * 24 * 365; // one year

export const hasLocale = (value: string): value is Locale =>
  (locales as readonly string[]).includes(value);

/** BCP 47 tag for `<html lang>` and Turnstile. */
export const languageTag: Record<Locale, string> = {
  en: "en",
  zh: "zh-TW",
};

export const openGraphLocale: Record<Locale, string> = {
  en: "en_US",
  zh: "zh_TW",
};
