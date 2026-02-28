import type { NextConfig } from "next";

const securityHeaders = [
  {
    key: "Content-Security-Policy",
    value: [
      "default-src 'self'",
      "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://challenges.cloudflare.com",
      "style-src 'self' 'unsafe-inline' https://challenges.cloudflare.com",
      "frame-src 'self' https://challenges.cloudflare.com",
      "child-src 'self' https://challenges.cloudflare.com",
      "connect-src 'self' https://challenges.cloudflare.com",
      "img-src 'self' data: https:",
      "font-src 'self' data:",
    ].join("; "),
  },
  {
    key: "X-Frame-Options",
    value: "SAMEORIGIN",
  },
];

const nextConfig: NextConfig = {
  poweredByHeader: false,
  compress: true,
  trailingSlash: false,
  async headers() {
    return [
      {
        source: "/(.*)",
        headers: securityHeaders,
      },
    ];
  },
  images: {
    remotePatterns: [
      {
        protocol: "https",
        hostname: "github.com",
      },
    ],
    unoptimized: true,
  },
};

export default nextConfig;
