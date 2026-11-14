import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { headers } from "next/headers";
import { Geist, Geist_Mono } from "next/font/google";
import "../globals.css";
import { ThemeProvider } from "../components/providers/ThemeProvider";
import StructuredData from "../components/StructuredData";
import BackToTop from "../components/BackToTop";
import {
  hasLocale,
  languageTag,
  locales,
  openGraphLocale,
} from "../i18n/config";
import { getDictionary } from "../i18n";

const SITE_URL = "https://stanleyowen.com";

const geistSans = Geist({
  variable: "--font-geist-sans",
  subsets: ["latin"],
});

const geistMono = Geist_Mono({
  variable: "--font-geist-mono",
  subsets: ["latin"],
});

type Params = Promise<{ lang: string }>;

export function generateStaticParams() {
  return locales.map((lang) => ({ lang }));
}

// Only the locales above exist; anything else under /<segment> is a 404.
export const dynamicParams = false;

export async function generateMetadata({
  params,
}: {
  params: Params;
}): Promise<Metadata> {
  const { lang } = await params;
  if (!hasLocale(lang)) return {};
  const { meta } = getDictionary(lang);

  return {
    title: {
      default: meta.title,
      template: `%s | ${meta.title}`,
    },
    description: meta.description,
    keywords: [
      "Stanley Owen",
      "張銘元",
      "Software Engineer",
      "Full Stack Developer",
      "Computer Science",
      "NTUST",
      "Electron",
      "React",
      "TypeScript",
      "Python",
      "Natural Language Processing",
      "Software Development",
    ],
    authors: [{ name: "Stanley Owen" }],
    creator: "Stanley Owen",
    publisher: "Stanley Owen",
    formatDetection: {
      email: false,
      address: false,
      telephone: false,
    },
    metadataBase: new URL(SITE_URL),
    // Both languages are served from the same URL (chosen by cookie).
    alternates: {
      canonical: "/",
    },
    openGraph: {
      title: meta.title,
      description: meta.description,
      url: SITE_URL,
      siteName: meta.siteName,
      images: [
        {
          url: "/profile.jpg",
          width: 460,
          height: 460,
          alt: meta.imageAlt,
        },
      ],
      locale: openGraphLocale[lang],
      alternateLocale: locales
        .filter((l) => l !== lang)
        .map((l) => openGraphLocale[l]),
      type: "website",
    },
    twitter: {
      card: "summary_large_image",
      title: meta.title,
      description: meta.description,
      images: ["/profile.jpg"],
      creator: "@stanleyowen",
    },
    robots: {
      index: true,
      follow: true,
      googleBot: {
        index: true,
        follow: true,
        "max-video-preview": -1,
        "max-image-preview": "large",
        "max-snippet": -1,
      },
    },
    icons: {
      icon: "/profile.jpg",
      shortcut: "/profile.jpg",
      apple: "/profile.jpg",
    },
    manifest: "/manifest.json",
  };
}

export default async function RootLayout({
  children,
  params,
}: Readonly<{
  children: React.ReactNode;
  params: Params;
}>) {
  const { lang } = await params;
  if (!hasLocale(lang)) notFound();
  const dict = getDictionary(lang);
  // Set by proxy.ts. Reading request headers also makes the page render per
  // request, which a per-request nonce requires.
  const nonce = (await headers()).get("x-nonce") ?? undefined;

  return (
    <html lang={languageTag[lang]} suppressHydrationWarning>
      <head>
        <StructuredData
          description={dict.meta.description}
          url={SITE_URL}
        />
      </head>
      <body
        className={`${geistSans.variable} ${geistMono.variable} antialiased`}
      >
        <ThemeProvider
          attribute="class"
          defaultTheme="system"
          enableSystem
          disableTransitionOnChange
          nonce={nonce}
        >
          {children}
          <BackToTop label={dict.backToTop} />
        </ThemeProvider>
      </body>
    </html>
  );
}
