import type { NextConfig } from "next";

// Low-risk hardening headers. A Content-Security-Policy is intentionally not
// set here (a previous attempt was reverted); add one separately with care
// for Turnstile and next-themes' inline script.
const securityHeaders = [
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
