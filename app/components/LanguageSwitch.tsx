"use client";

import { LOCALE_COOKIE, LOCALE_COOKIE_MAX_AGE, type Locale } from "../i18n/config";

export default function LanguageSwitch({
  locale,
  hrefLang,
  label,
  ariaLabel,
}: {
  /** The language to switch to. */
  locale: Locale;
  hrefLang: string;
  label: string;
  ariaLabel: string;
}) {
  return (
    <button
      type="button"
      lang={hrefLang}
      aria-label={ariaLabel}
      title={ariaLabel}
      // Save the choice and reload the same URL; the server reads the cookie
      // and renders that language. Reloading keeps the hash and scroll spot.
      onClick={() => {
        document.cookie = `${LOCALE_COOKIE}=${locale}; path=/; max-age=${LOCALE_COOKIE_MAX_AGE}; samesite=lax`;
        window.location.reload();
      }}
      className="flex min-w-12 cursor-pointer items-center justify-center rounded-lg border border-zinc-200 bg-white/80 px-3 text-sm font-medium text-zinc-700 shadow-lg backdrop-blur-sm transition-colors hover:bg-zinc-100 hover:text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900/80 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white"
    >
      {label}
    </button>
  );
}
