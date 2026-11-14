"use client";

import dynamic from "next/dynamic";

// The particle engine is purely decorative, so load it in its own chunk on the
// client only. This keeps it out of the initial bundle and off the hydration
// critical path for the actual page content.
const ParticleCanvas = dynamic(() => import("./ParticleCanvas"), {
  ssr: false,
});

export default function ParticleBackground() {
  return <ParticleCanvas />;
}
