export default function SectionHeading({
  eyebrow,
  title,
}: {
  eyebrow: string;
  title: string;
}) {
  return (
    <div className="mb-12">
      <p data-reveal className="mb-2 font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">
        {eyebrow}
      </p>
      <h2 data-reveal className="text-3xl font-semibold tracking-tight text-zinc-900 dark:text-white">
        {title}
      </h2>
    </div>
  );
}
