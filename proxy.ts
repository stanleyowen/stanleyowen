import { NextResponse, type NextRequest } from "next/server";
import {
  LOCALE_COOKIE,
  LOCALE_COOKIE_MAX_AGE,
  defaultLocale,
  hasLocale,
  locales,
} from "./app/i18n/config";

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

  const url = request.nextUrl.clone();
  url.pathname = pathname === "/" ? `/${locale}` : `/${locale}${pathname}`;
  return NextResponse.rewrite(url);
}

export const config = {
  // Skip API routes, Next internals and any file with an extension
  // (profile.jpg, robots.txt, sitemap.xml, manifest.json, the CV PDF…).
  matcher: ["/((?!api|_next|.*\\..*).*)"],
};
