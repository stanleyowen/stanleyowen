import type { NextConfig } from "next";

// Hardening headers for every response. The Content-Security-Policy is set in
// proxy.ts instead, because it needs a fresh nonce for each page request.
const securityHeaders = [
  // Browsers that have visited once keep using HTTPS for a year. Subdomains
  // are left out on purpose so any non-HTTPS subdomain keeps working.
  { key: "Strict-Transport-Security", value: "max-age=31536000" },
  { key: "X-Content-Type-Options", value: "nosniff" },
  { key: "X-Frame-Options", value: "SAMEORIGIN" },
  { key: "Referrer-Policy", value: "strict-origin-when-cross-origin" },
  {
    key: "Permissions-Policy",
    value: "camera=(), microphone=(), geolocation=(), browsing-topics=()",
  },
];

const nextConfig: NextConfig = {
  poweredByHeader: false,
  compress: true,
  trailingSlash: false,
  images: {
    // Only local images are used; the optimizer is disabled entirely.
    unoptimized: true,
  },
  async headers() {
    return [{ source: "/:path*", headers: securityHeaders }];
  },
};

export default nextConfig;
