"use client";

import { useEffect } from "react";

// Total time a cascade may take when several elements enter together, and the
// widest gap between neighbours in that cascade.
const CASCADE_BUDGET_MS = 640;
const MAX_STEP_MS = 80;

/**
 * Plays the entrance animation on every `[data-reveal]` element the first time
 * it scrolls into view. Only elements that start below the fold are hidden, so
 * anything already on screen, or rendered without JavaScript, is never blanked
 * out. The motion itself lives in globals.css.
 */
export default function ScrollReveal() {
  useEffect(() => {
    if (
      !("IntersectionObserver" in window) ||
      window.matchMedia("(prefers-reduced-motion: reduce)").matches
    ) {
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        // Elements that enter in the same frame cascade top-to-bottom,
        // left-to-right, compressed so a big batch still finishes quickly.
        const entering = entries
          .filter((e) => e.isIntersecting)
          .sort(
            (a, b) =>
              a.boundingClientRect.top - b.boundingClientRect.top ||
              a.boundingClientRect.left - b.boundingClientRect.left,
          );
        const step = Math.min(
          MAX_STEP_MS,
          CASCADE_BUDGET_MS / Math.max(entering.length - 1, 1),
        );

        entering.forEach((entry, i) => {
          const el = entry.target as HTMLElement;
          observer.unobserve(el);
          el.style.setProperty("--reveal-delay", `${Math.round(i * step)}ms`);
          el.removeAttribute("data-reveal-pending");
          el.setAttribute("data-reveal-in", "");
        });
      },
      { rootMargin: "0px 0px -8% 0px" },
    );

    // Measure everything before touching attributes to avoid layout thrash.
    const fold = window.innerHeight;
    const targets = Array.from(
      document.querySelectorAll<HTMLElement>("[data-reveal]"),
    ).filter(
      (el) =>
        !el.hasAttribute("data-reveal-in") &&
        (el.hasAttribute("data-reveal-pending") ||
          el.getBoundingClientRect().top >= fold),
    );

    for (const el of targets) {
      el.setAttribute("data-reveal-pending", "");
      observer.observe(el);
    }

    return () => observer.disconnect();
  }, []);

  return null;
}
