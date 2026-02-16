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
    "Passionate about building elegant solutions and creating meaningful digital experiences. I enjoy developing cross-platform applications, combining modern UI design with high-performance systems programming.",
  keywords: [
    "Stanley Owen",
    "Full Stack Developer",
    "Software Engineer",
    "React Developer",
    "Next.js Developer",
    "TypeScript",
    "JavaScript",
    "Frontend Developer",
    "Backend Developer",
    "Web Development",
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
      "Passionate about building elegant solutions and creating meaningful digital experiences. I enjoy developing cross-platform applications, combining modern UI design with high-performance systems programming.",
    url: "https://stanleyowen.com",
    siteName: "Stanley Owen Portfolio",
    images: [
      {
        url: "/icon.png",
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
      "Passionate about building elegant solutions and creating meaningful digital experiences.",
    images: ["/icon.png"],
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
    icon: "/icon.png",
    shortcut: "/icon.png",
    apple: "/icon.png",
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
