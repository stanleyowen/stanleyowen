import { openSource } from "../data/profile";
import SectionHeading from "./SectionHeading";

export default function OpenSource() {
  return (
    <section id="open-source" className="relative z-10 w-full px-6 py-20 md:px-24">
      <div className="mx-auto max-w-5xl">
        <SectionHeading eyebrow="Community" title="Open Source" />

        <div className="space-y-6">
          {openSource.map((p) => (
            <article
              key={p.name}
              className="rounded-xl border border-zinc-200 bg-white/70 p-6 backdrop-blur-sm dark:border-white/10 dark:bg-zinc-950/60"
            >
              <div className="flex flex-col gap-1 sm:flex-row sm:items-baseline sm:justify-between">
                <h3 className="text-xl font-semibold text-zinc-900 dark:text-white">
                  {p.name}
                  <span className="text-base font-normal text-zinc-600 dark:text-zinc-400">
                    {" "}
                    — {p.role}
                  </span>
                </h3>
                <span className="font-mono text-xs text-zinc-500 dark:text-zinc-400">
                  {p.period}
                </span>
              </div>
              <p className="mt-4 text-zinc-700 dark:text-zinc-300">
                {p.summary}
              </p>
              <div className="mt-5 flex flex-wrap items-center gap-2">
                {p.stack.map((t) => (
                  <span
                    key={t}
                    className="rounded-md border border-zinc-200 bg-zinc-100 px-2 py-1 font-mono text-xs text-zinc-700 dark:border-white/10 dark:bg-white/5 dark:text-zinc-300"
                  >
                    {t}
                  </span>
                ))}
              </div>
              <div className="mt-5 flex gap-4 text-sm">
                {p.links.map((l) => (
                  <a
                    key={l.href}
                    href={l.href}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="font-medium text-zinc-900 underline underline-offset-4 hover:opacity-70 dark:text-white"
                  >
                    {l.label} ↗
                  </a>
                ))}
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
