import { awards } from "../data/profile";
import SectionHeading from "./SectionHeading";

export default function Honors() {
  return (
    <section id="honors" className="relative z-10 w-full px-6 py-20 md:px-24">
      <div className="mx-auto max-w-5xl">
        <SectionHeading eyebrow="Recognition" title="Honors & Awards" />

        <ul className="divide-y divide-zinc-200 overflow-hidden rounded-xl border border-zinc-200 bg-white/70 backdrop-blur-sm dark:divide-white/10 dark:border-white/10 dark:bg-zinc-950/60">
          {awards.map((a) => (
            <li
              key={`${a.title}-${a.date}`}
              className="grid gap-1 p-4 text-sm md:grid-cols-[110px_1fr_auto] md:gap-6"
            >
              <span className="font-mono text-xs text-zinc-500 md:pt-0.5 dark:text-zinc-400">
                {a.date}
              </span>
              <span className="font-medium text-zinc-900 dark:text-white">
                {a.title}
              </span>
              <span className="text-zinc-600 dark:text-zinc-400">
                {a.issuer}
              </span>
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
