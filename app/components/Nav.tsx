"use client";

import { useCallback, useEffect, useLayoutEffect, useRef, useState } from "react";
import type { Dictionary } from "../i18n";

type Pill = { left: number; top: number; width: number; height: number };

export default function Nav({ dict }: { dict: Dictionary["nav"] }) {
  const links = [
    { id: "about", label: dict.about },
    { id: "education", label: dict.education },
    { id: "experience", label: dict.experience },
    { id: "open-source", label: dict.openSource },
    { id: "honors", label: dict.honors },
    { id: "activities", label: dict.activities },
    { id: "skills", label: dict.skills },
    { id: "contact", label: dict.contact },
  ];
  const ids = links.map((l) => l.id);
  const idsKey = ids.join(",");

  const navRef = useRef<HTMLElement>(null);
  const listRef = useRef<HTMLUListElement>(null);
  const linkRefs = useRef<Record<string, HTMLAnchorElement | null>>({});
  // While a click-triggered smooth scroll is running, hold the pill on the
  // target instead of sliding it through every section on the way.
  const lockedUntil = useRef(0);

  const [active, setActive] = useState(ids[0]);
  const [pill, setPill] = useState<Pill | null>(null);

  // Work out which section is under the reading line (a little below the
  // sticky nav). At the very bottom, the last section wins even if it's short.
  useEffect(() => {
    const sectionIds = idsKey.split(",");
    let frame = 0;

    const update = () => {
      frame = 0;
      if (Date.now() < lockedUntil.current) return;

      // Measure from where the nav sits once stuck (the top), not from where
      // it happens to be while still below the hero.
      const navHeight = navRef.current?.offsetHeight ?? 0;
      const line = navHeight + window.innerHeight * 0.25;
      const atBottom =
        window.innerHeight + window.scrollY >=
        document.documentElement.scrollHeight - 2;

      let current = sectionIds[0];
      if (atBottom) {
        current = sectionIds[sectionIds.length - 1];
      } else {
        for (const id of sectionIds) {
          const el = document.getElementById(id);
          if (el && el.getBoundingClientRect().top <= line) current = id;
        }
      }
      setActive(current);
    };

    const onScroll = () => {
      if (!frame) frame = requestAnimationFrame(update);
    };
    const unlock = () => {
      lockedUntil.current = 0;
      onScroll();
    };

    update();
    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", onScroll);
    window.addEventListener("scrollend", unlock);
    return () => {
      cancelAnimationFrame(frame);
      window.removeEventListener("scroll", onScroll);
      window.removeEventListener("resize", onScroll);
      window.removeEventListener("scrollend", unlock);
    };
  }, [idsKey]);

  // Move the glass pill under the active link, and on narrow screens scroll
  // the link row so the active link stays in view.
  const measure = useCallback(() => {
    const link = linkRefs.current[active];
    const list = listRef.current;
    if (!link || !list) return;

    setPill({
      left: link.offsetLeft,
      top: link.offsetTop,
      width: link.offsetWidth,
      height: link.offsetHeight,
    });

    const overflowLeft = link.offsetLeft - 16 < list.scrollLeft;
    const overflowRight =
      link.offsetLeft + link.offsetWidth + 16 >
      list.scrollLeft + list.clientWidth;
    if (overflowLeft || overflowRight) {
      list.scrollTo({
        left: link.offsetLeft - (list.clientWidth - link.offsetWidth) / 2,
        behavior: "smooth",
      });
    }
  }, [active]);

  useLayoutEffect(measure, [measure]);

  useEffect(() => {
    const list = listRef.current;
    if (!list) return;
    // Re-measure when fonts load or the layout changes width.
    const observer = new ResizeObserver(measure);
    observer.observe(list);
    return () => observer.disconnect();
  }, [measure]);

  return (
    // From md up the language/theme controls float over the right end of this
    // bar, so the link row ends before them (md:mr-60) and scrolls instead.
    // Its left margin matches what mx-auto would give, keeping it aligned with
    // the sections below.
    <nav
      ref={navRef}
      aria-label={dict.label}
      className="sticky top-0 z-40 border-b border-zinc-200 bg-white/70 backdrop-blur-md dark:border-white/10 dark:bg-black/60"
    >
      <ul
        ref={listRef}
        className="relative mx-auto flex max-w-5xl gap-1 overflow-x-auto px-3 py-2.5 text-sm text-zinc-600 [scrollbar-width:none] md:mr-60 md:ml-[max(0px,calc((100%-64rem)/2))] md:pl-21 dark:text-zinc-400 [&::-webkit-scrollbar]:hidden"
      >
        {/* Glass indicator behind the active link */}
        <span
          aria-hidden="true"
          className="pointer-events-none absolute left-0 top-0 rounded-full border border-zinc-200/80 bg-white/80 shadow-[0_1px_3px_rgb(0_0_0/0.08),inset_0_1px_0_rgb(255_255_255/0.9)] backdrop-blur-md transition-[transform,width,opacity] duration-300 ease-[cubic-bezier(0.2,0.8,0.2,1)] motion-reduce:transition-none dark:border-white/15 dark:bg-white/10 dark:shadow-[0_1px_3px_rgb(0_0_0/0.4),inset_0_1px_0_rgb(255_255_255/0.12)]"
          style={{
            opacity: pill ? 1 : 0,
            width: pill?.width ?? 0,
            height: pill?.height ?? 0,
            transform: pill
              ? `translate(${pill.left}px, ${pill.top}px)`
              : undefined,
          }}
        />

        {links.map((l) => {
          const isActive = l.id === active;
          return (
            <li key={l.id} className="shrink-0">
              <a
                ref={(el) => {
                  linkRefs.current[l.id] = el;
                }}
                href={`#${l.id}`}
                aria-current={isActive ? "location" : undefined}
                onClick={() => {
                  setActive(l.id);
                  // Fallback for browsers without the scrollend event.
                  lockedUntil.current = Date.now() + 1200;
                }}
                className={`relative block rounded-full px-3 py-1.5 transition-colors duration-300 ${
                  isActive
                    ? "text-zinc-900 dark:text-white"
                    : "hover:text-zinc-900 dark:hover:text-white"
                }`}
              >
                {l.label}
              </a>
            </li>
          );
        })}
      </ul>
    </nav>
  );
}
