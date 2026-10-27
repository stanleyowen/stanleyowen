import ElectronIcon from "./icons/ElectronIcon";
import ReactIcon from "./icons/ReactIcon";
import NodeIcon from "./icons/NodeIcon";
import MongoDBIcon from "./icons/MongoDBIcon";
import GitIcon from "./icons/GitIcon";
import TailwindIcon from "./icons/TailwindIcon";
import JavaScriptIcon from "./icons/JavaScriptIcon";
import TypeScriptIcon from "./icons/TypeScriptIcon";
import PythonIcon from "./icons/PythonIcon";
import RustIcon from "./icons/RustIcon";
import CppIcon from "./icons/CppIcon";
import HtmlIcon from "./icons/HtmlIcon";
import CssIcon from "./icons/CssIcon";
import SassIcon from "./icons/SassIcon";
import JavaIcon from "./icons/JavaIcon";
import BootstrapIcon from "./icons/BootstrapIcon";
import MaterialUiIcon from "./icons/MaterialUiIcon";
import PostmanIcon from "./icons/PostmanIcon";
import CIcon from "./icons/CIcon";
import CSharpIcon from "./icons/CSharpIcon";
import PhpIcon from "./icons/PhpIcon";
import AssemblyIcon from "./icons/AssemblyIcon";

import SectionHeading from "./SectionHeading";

const groups = [
  {
    title: "Languages",
    items: [
      { name: "Python", Icon: PythonIcon },
      { name: "TypeScript", Icon: TypeScriptIcon },
      { name: "JavaScript", Icon: JavaScriptIcon },
      { name: "C", Icon: CIcon },
      { name: "C++", Icon: CppIcon },
      { name: "C#", Icon: CSharpIcon },
      { name: "Java", Icon: JavaIcon },
      { name: "Rust", Icon: RustIcon },
      { name: "PHP", Icon: PhpIcon },
      { name: "Assembly", Icon: AssemblyIcon },
    ],
  },
  {
    title: "Frontend",
    items: [
      { name: "React", Icon: ReactIcon },
      { name: "HTML", Icon: HtmlIcon },
      { name: "CSS", Icon: CssIcon },
      { name: "Sass", Icon: SassIcon },
      { name: "Tailwind CSS", Icon: TailwindIcon },
      { name: "Bootstrap", Icon: BootstrapIcon },
      { name: "Material UI", Icon: MaterialUiIcon },
    ],
  },
  {
    title: "Backend & Platforms",
    items: [
      { name: "Node.js", Icon: NodeIcon },
      { name: "Electron", Icon: ElectronIcon },
      { name: "MongoDB", Icon: MongoDBIcon },
    ],
  },
  {
    title: "Tooling",
    items: [
      { name: "Git", Icon: GitIcon },
      { name: "Postman", Icon: PostmanIcon },
    ],
  },
];

export default function Skills() {
  return (
    <section id="skills" className="relative z-10 w-full px-6 py-20 md:px-24">
      <div className="mx-auto max-w-5xl">
        <SectionHeading eyebrow="Toolkit" title="Technical Skills" />

        <div className="divide-y divide-zinc-200 overflow-hidden rounded-xl border border-zinc-200 bg-white/70 backdrop-blur-sm dark:divide-white/10 dark:border-white/10 dark:bg-zinc-950/60">
          {groups.map((g) => (
            <div
              key={g.title}
              className="grid gap-4 p-6 md:grid-cols-[180px_1fr] md:gap-8"
            >
              <h3 className="font-mono text-xs uppercase tracking-[0.15em] text-zinc-500 md:pt-2 dark:text-zinc-400">
                {g.title}
              </h3>
              <ul className="flex flex-wrap gap-2">
                {g.items.map(({ name, Icon }) => (
                  <li
                    key={name}
                    className="flex items-center gap-2 rounded-md border border-zinc-200 bg-zinc-50 px-3 py-1.5 text-sm text-zinc-800 dark:border-white/10 dark:bg-white/5 dark:text-zinc-200"
                  >
                    <Icon size={18} />
                    {name}
                  </li>
                ))}
              </ul>
            </div>
          ))}

          <div className="grid gap-4 p-6 md:grid-cols-[180px_1fr] md:gap-8">
            <h3 className="font-mono text-xs uppercase tracking-[0.15em] text-zinc-500 md:pt-0 dark:text-zinc-400">
              Spoken Languages
            </h3>
            <p className="text-sm text-zinc-700 dark:text-zinc-300">
              Indonesian (native) · English (IELTS 7.0) · Chinese (HSK 5, TOCFL B2)
            </p>
          </div>
        </div>
      </div>
    </section>
  );
}
