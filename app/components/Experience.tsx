import { experience } from "../data/profile";
import SectionHeading from "./SectionHeading";

export default function Experience() {
  return (
    <section id="experience" className="relative z-10 w-full px-6 py-20 md:px-24">
      <div className="mx-auto max-w-5xl">
        <SectionHeading eyebrow="Career" title="Professional Experience" />

        <ol className="relative space-y-12 border-l border-zinc-300 pl-8 dark:border-white/15">
          {experience.map((job) => (
            <li key={`${job.role}-${job.period}`} className="relative">
              <span className="absolute -left-[37px] top-2 h-2.5 w-2.5 rounded-full bg-zinc-900 ring-4 ring-zinc-50 dark:bg-white dark:ring-black" />

              <div className="rounded-xl border border-zinc-200 bg-white/70 p-6 backdrop-blur-sm dark:border-white/10 dark:bg-zinc-950/60">
                <div className="flex flex-col gap-1 sm:flex-row sm:items-baseline sm:justify-between">
                  <h3 className="text-xl font-semibold text-zinc-900 dark:text-white">
                    {job.role}
                  </h3>
                  <span className="font-mono text-xs text-zinc-500 dark:text-zinc-400">
                    {job.period}
                  </span>
                </div>
                <p className="mt-1 text-sm text-zinc-700 dark:text-zinc-300">
                  {job.organization}
                  <span className="text-zinc-400 dark:text-zinc-500">
                    {" "}
                    · {job.location}
                  </span>
                </p>

                <p className="mt-4 text-zinc-700 dark:text-zinc-300">
                  {job.summary}
                </p>

                {job.highlights.length > 0 && (
                  <ul className="mt-4 space-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                    {job.highlights.map((h) => (
                      <li key={h} className="flex gap-3">
                        <span className="mt-2 h-1 w-1 shrink-0 rounded-full bg-zinc-400" />
                        <span>{h}</span>
                      </li>
                    ))}
                  </ul>
                )}

                {job.stack.length > 0 && (
                  <div className="mt-5 flex flex-wrap gap-2">
                    {job.stack.map((t) => (
                      <span
                        key={t}
                        className="rounded-md border border-zinc-200 bg-zinc-100 px-2 py-1 font-mono text-xs text-zinc-700 dark:border-white/10 dark:bg-white/5 dark:text-zinc-300"
                      >
                        {t}
                      </span>
                    ))}
                  </div>
                )}
              </div>
            </li>
          ))}
        </ol>
      </div>
    </section>
  );
}
