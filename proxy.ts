import { NextResponse, type NextRequest } from "next/server";
import {
  LOCALE_COOKIE,
  LOCALE_COOKIE_MAX_AGE,
  defaultLocale,
  hasLocale,
  locales,
} from "./app/i18n/config";

/**
 * Strict Content-Security-Policy with a fresh nonce per request. Next.js reads
 * the nonce from the request's CSP header and adds it to its own scripts; the
 * layout passes it to next-themes for the inline theme script. 'strict-dynamic'
 * lets those trusted scripts load Turnstile's script from Cloudflare.
 *
 * Styles allow 'unsafe-inline' because React renders `style` attributes, which
 * nonces can't cover (and a nonce in style-src would disable 'unsafe-inline').
 */
function contentSecurityPolicy(nonce: string) {
  const isDev = process.env.NODE_ENV === "development";
  return [
    "default-src 'self'",
    `script-src 'self' 'nonce-${nonce}' 'strict-dynamic'${isDev ? " 'unsafe-eval'" : ""}`,
    "style-src 'self' 'unsafe-inline'",
    "img-src 'self' blob: data:",
    "font-src 'self'",
    "connect-src 'self' https://challenges.cloudflare.com",
    "frame-src https://challenges.cloudflare.com",
    "object-src 'none'",
    "base-uri 'self'",
    "form-action 'self'",
    "frame-ancestors 'self'",
    ...(isDev ? [] : ["upgrade-insecure-requests"]),
  ].join("; ");
}

// Both languages share the same URLs. Pages are built under app/[lang], and
// each request is rewritten internally to `/<locale>/...` using the language
// the visitor picked (saved in a cookie by the language switch), falling back
// to English. The locale-prefixed paths are never shown: visiting `/zh/...`
// directly saves that language and redirects to the unprefixed URL.
export function proxy(request: NextRequest) {
  const { pathname } = request.nextUrl;

  const prefixed = locales.find(
    (l) => pathname === `/${l}` || pathname.startsWith(`/${l}/`),
  );
  if (prefixed) {
    const url = request.nextUrl.clone();
    url.pathname = pathname.slice(prefixed.length + 1) || "/";
    const response = NextResponse.redirect(url, 307);
    response.cookies.set(LOCALE_COOKIE, prefixed, {
      path: "/",
      maxAge: LOCALE_COOKIE_MAX_AGE,
      sameSite: "lax",
    });
    return response;
  }

  const cookie = request.cookies.get(LOCALE_COOKIE)?.value;
  const locale = cookie && hasLocale(cookie) ? cookie : defaultLocale;

  const nonce = Buffer.from(crypto.randomUUID()).toString("base64");
  const csp = contentSecurityPolicy(nonce);
  const requestHeaders = new Headers(request.headers);
  requestHeaders.set("x-nonce", nonce);
  requestHeaders.set("Content-Security-Policy", csp);

  const url = request.nextUrl.clone();
  url.pathname = pathname === "/" ? `/${locale}` : `/${locale}${pathname}`;
  const response = NextResponse.rewrite(url, {
    request: { headers: requestHeaders },
  });
  response.headers.set("Content-Security-Policy", csp);
  return response;
}

export const config = {
  matcher: [
    {
      // Skip API routes, Next internals and any file with an extension
      // (profile.jpg, robots.txt, sitemap.xml, manifest.json, the CV PDF…),
      // plus prefetches, which don't render a page that needs a nonce.
      source: "/((?!api|_next|.*\\..*).*)",
      missing: [
        { type: "header", key: "next-router-prefetch" },
        { type: "header", key: "purpose", value: "prefetch" },
      ],
    },
  ],
};
