const links = [
  { href: "#about", label: "About" },
  { href: "#education", label: "Education" },
  { href: "#experience", label: "Experience" },
  { href: "#open-source", label: "Open Source" },
  { href: "#honors", label: "Honors" },
  { href: "#activities", label: "Activities" },
  { href: "#skills", label: "Skills" },
  { href: "#contact", label: "Contact" },
];

export default function Nav() {
  return (
    <nav
      aria-label="Sections"
      className="sticky top-0 z-40 border-b border-zinc-200 bg-white/70 backdrop-blur-md dark:border-white/10 dark:bg-black/60"
    >
      <ul className="mx-auto flex max-w-5xl gap-6 overflow-x-auto px-6 py-4 pr-20 md:pl-24 text-sm text-zinc-600 dark:text-zinc-400">
        {links.map((l) => (
          <li key={l.href} className="shrink-0">
            <a
              href={l.href}
              className="transition-colors hover:text-zinc-900 dark:hover:text-white"
            >
              {l.label}
            </a>
          </li>
        ))}
      </ul>
    </nav>
  );
}
