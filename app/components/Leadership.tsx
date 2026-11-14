import type { LeadershipItem } from "../data/profile";
import type { Dictionary } from "../i18n";
import SectionHeading from "./SectionHeading";

export default function Leadership({
  dict,
  leadership,
}: {
  dict: Dictionary;
  leadership: LeadershipItem[];
}) {
  return (
    <section id="activities" className="relative z-10 w-full px-6 py-20 md:px-24">
      <div className="mx-auto max-w-5xl">
        <SectionHeading {...dict.sections.leadership} />

        <ul
          data-reveal="fade"
          className="divide-y divide-zinc-200 overflow-hidden rounded-xl border border-zinc-200 bg-white/70 backdrop-blur-sm dark:divide-white/10 dark:border-white/10 dark:bg-zinc-950/60"
        >
          {leadership.map((l) => (
            <li
              key={`${l.role ?? ""}-${l.organization}-${l.period}`}
              data-reveal
              className="grid gap-2 p-5 md:grid-cols-[180px_1fr] md:gap-8"
            >
              <span className="font-mono text-xs text-zinc-500 md:pt-1 dark:text-zinc-400">
                {l.period}
              </span>
              <div>
                {l.roles ? (
                  <>
                    <h3 className="font-semibold text-zinc-900 dark:text-white">
                      {l.role ?? l.organization}
                      {l.role && (
                        <span className="font-normal text-zinc-600 dark:text-zinc-400">
                          {" "}
                          · {l.organization}
                        </span>
                      )}
                    </h3>
                    <ul className="mt-2 space-y-1.5 text-sm">
                      {l.roles.map((r) => (
                        <li
                          key={`${r.title}-${r.period}`}
                          className="flex flex-col gap-0.5 sm:flex-row sm:items-baseline sm:justify-between sm:gap-4"
                        >
                          <span className="text-zinc-700 dark:text-zinc-300">
                            {r.title}
                          </span>
                          <span className="shrink-0 font-mono text-xs text-zinc-500 dark:text-zinc-400">
                            {r.period}
                          </span>
                        </li>
                      ))}
                    </ul>
                  </>
                ) : (
                  <h3 className="font-semibold text-zinc-900 dark:text-white">
                    {l.role}
                    <span className="font-normal text-zinc-600 dark:text-zinc-400">
                      {" "}
                      · {l.organization}
                    </span>
                  </h3>
                )}
                {l.summary && (
                  <p className="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    {l.summary}
                  </p>
                )}
              </div>
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
