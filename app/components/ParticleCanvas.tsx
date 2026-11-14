"use client";

import { Particles, ParticlesProvider } from "@tsparticles/react";
import { loadSlim } from "@tsparticles/slim";
import type { Engine, ISourceOptions } from "@tsparticles/engine";

// Module-level so both stay referentially stable: ParticlesProvider requires a
// stable init, and Particles reloads the whole container when options change.
const init = async (engine: Engine) => {
  await loadSlim(engine);
};

const options: ISourceOptions = {
  background: {
    color: {
      value: "transparent",
    },
  },
  fpsLimit: 60,
  interactivity: {
    events: {
      onClick: {
        enable: true,
        mode: "push",
      },
      onHover: {
        enable: true,
        mode: "grab",
      },
    },
    modes: {
      push: {
        quantity: 4,
      },
      grab: {
        distance: 140,
        links: {
          opacity: 0.5,
        },
      },
    },
  },
  particles: {
    paint: {
      fill: {
        enable: true,
        color: { value: "#808080" },
      },
    },
    links: {
      color: "#808080",
      distance: 150,
      enable: true,
      opacity: 0.5,
      width: 1,
    },
    move: {
      direction: "none",
      enable: true,
      outModes: {
        default: "bounce",
      },
      random: false,
      speed: 1,
      straight: false,
    },
    number: {
      density: {
        enable: true,
      },
      value: 100,
      limit: { value: 200 },
    },
    opacity: {
      value: 0.3,
    },
    shape: {
      type: "circle",
    },
    size: {
      value: { min: 1, max: 3 },
    },
  },
  detectRetina: true,
};

export default function ParticleCanvas() {
  return (
    <ParticlesProvider init={init}>
      <Particles
        id="tsparticles"
        className="absolute inset-0 z-0 [&_canvas]:mix-blend-difference"
        options={options}
      />
    </ParticlesProvider>
  );
}
