import type { Metadata } from "next";
import { Geist, Geist_Mono } from "next/font/google";
import "./globals.css";
import { ThemeProvider } from "./components/providers/ThemeProvider";
import StructuredData from "./components/StructuredData";
import BackToTop from "./components/BackToTop";

const geistSans = Geist({
  variable: "--font-geist-sans",
  subsets: ["latin"],
});

const geistMono = Geist_Mono({
  variable: "--font-geist-mono",
  subsets: ["latin"],
});

export const metadata: Metadata = {
  title: {
    default: "Stanley Owen",
    template: "%s | Stanley Owen",
  },
  description:
    "Computer Science student at NTUST in Taipei, building mobile and cross-platform apps, AI systems, and open-source software.",
  keywords: [
    "Stanley Owen",
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
  metadataBase: new URL("https://stanleyowen.com"),
  alternates: {
    canonical: "/",
  },
  openGraph: {
    title: "Stanley Owen",
    description:
      "Computer Science student at NTUST in Taipei, building mobile and cross-platform apps, AI systems, and open-source software.",
    url: "https://stanleyowen.com",
    siteName: "Stanley Owen Portfolio",
    images: [
      {
        url: "/profile.jpg",
        width: 460,
        height: 460,
        alt: "Stanley Owen Profile Picture",
      },
    ],
    locale: "en_US",
    type: "website",
  },
  twitter: {
    card: "summary_large_image",
    title: "Stanley Owen",
    description:
      "Computer Science student at NTUST in Taipei, building mobile and cross-platform apps, AI systems, and open-source software.",
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

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" suppressHydrationWarning>
      <head>
        <StructuredData />
      </head>
      <body
        className={`${geistSans.variable} ${geistMono.variable} antialiased`}
      >
        <ThemeProvider
          attribute="class"
          defaultTheme="system"
          enableSystem
          disableTransitionOnChange
        >
          {children}
          <BackToTop />
        </ThemeProvider>
      </body>
    </html>
  );
}
