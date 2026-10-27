import { education } from "../data/profile";
import SectionHeading from "./SectionHeading";

export default function Education() {
  return (
    <section id="education" className="relative z-10 w-full px-6 py-20 md:px-24">
      <div className="mx-auto max-w-5xl">
        <SectionHeading eyebrow="Academics" title="Education" />

        <div className="grid gap-6 md:grid-cols-2">
          {education.map((e) => (
            <article
              key={e.school}
              className="flex flex-col rounded-xl border border-zinc-200 bg-white/70 p-6 backdrop-blur-sm dark:border-white/10 dark:bg-zinc-950/60"
            >
              <span className="font-mono text-xs text-zinc-500 dark:text-zinc-400">
                {e.period}
              </span>
              <h3 className="mt-2 text-lg font-semibold text-zinc-900 dark:text-white">
                {e.school}
              </h3>
              <p className="mt-1 text-sm text-zinc-700 dark:text-zinc-300">
                {e.degree} ·{" "}
                <span className="font-medium text-zinc-900 dark:text-white">
                  {e.note}
                </span>
              </p>
              <ul className="mt-4 space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                {e.highlights.map((h) => (
                  <li key={h} className="flex gap-3">
                    <span className="mt-2 h-1 w-1 shrink-0 rounded-full bg-zinc-400" />
                    <span>{h}</span>
                  </li>
                ))}
              </ul>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}
