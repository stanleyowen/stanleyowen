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
import MaterialUiIcon from "./icons/MaterialUiIcon";
import CIcon from "./icons/CIcon";
import PhpIcon from "./icons/PhpIcon";
import AssemblyIcon from "./icons/AssemblyIcon";
import SwiftIcon from "./icons/SwiftIcon";
import KotlinIcon from "./icons/KotlinIcon";
import NextIcon from "./icons/NextIcon";
import ExpressIcon from "./icons/ExpressIcon";
import TauriIcon from "./icons/TauriIcon";
import FirebaseIcon from "./icons/FirebaseIcon";
import SqliteIcon from "./icons/SqliteIcon";
import DockerIcon from "./icons/DockerIcon";
import OpenCvIcon from "./icons/OpenCvIcon";
import MediaPipeIcon from "./icons/MediaPipeIcon";
import InsomniaIcon from "./icons/InsomniaIcon";

import SectionHeading from "./SectionHeading";

const groups = [
  {
    title: "Programming",
    items: [
      { name: "Python", Icon: PythonIcon },
      { name: "TypeScript", Icon: TypeScriptIcon },
      { name: "JavaScript", Icon: JavaScriptIcon },
      { name: "C", Icon: CIcon },
      { name: "C++", Icon: CppIcon },
      { name: "Swift", Icon: SwiftIcon },
      { name: "Kotlin", Icon: KotlinIcon },
      { name: "Rust", Icon: RustIcon },
      { name: "PHP", Icon: PhpIcon },
      { name: "Assembly", Icon: AssemblyIcon },
    ],
  },
  {
    title: "Frontend",
    items: [
      { name: "React", Icon: ReactIcon },
      { name: "Next.js", Icon: NextIcon },
      { name: "HTML", Icon: HtmlIcon },
      { name: "CSS", Icon: CssIcon },
      { name: "Sass", Icon: SassIcon },
      { name: "Tailwind CSS", Icon: TailwindIcon },
      { name: "Material UI", Icon: MaterialUiIcon },
    ],
  },
  {
    title: "Backend & Desktop",
    items: [
      { name: "Node.js", Icon: NodeIcon },
      { name: "Express", Icon: ExpressIcon },
      { name: "Electron", Icon: ElectronIcon },
      { name: "Tauri", Icon: TauriIcon },
    ],
  },
  {
    title: "Databases & Cloud",
    items: [
      { name: "MongoDB", Icon: MongoDBIcon },
      { name: "Firebase", Icon: FirebaseIcon },
      { name: "SQLite", Icon: SqliteIcon },
    ],
  },
  {
    title: "Tools & Libraries",
    items: [
      { name: "Git", Icon: GitIcon },
      { name: "Docker", Icon: DockerIcon },
      { name: "Insomnia", Icon: InsomniaIcon },
      { name: "OpenCV", Icon: OpenCvIcon },
      { name: "MediaPipe", Icon: MediaPipeIcon },
    ],
  },
];

export default function Skills() {
  return (
    <section id="skills" className="relative z-10 w-full px-6 py-20 md:px-24">
      <div className="mx-auto max-w-5xl">
        <SectionHeading eyebrow="Toolkit" title="Technical Skills" />

        <div
          data-reveal="fade"
          className="divide-y divide-zinc-200 overflow-hidden rounded-xl border border-zinc-200 bg-white/70 backdrop-blur-sm dark:divide-white/10 dark:border-white/10 dark:bg-zinc-950/60"
        >
          {groups.map((g) => (
            <div
              key={g.title}
              className="grid gap-4 p-6 md:grid-cols-[180px_1fr] md:gap-8"
            >
              <h3
                data-reveal
                className="font-mono text-xs uppercase tracking-[0.15em] text-zinc-500 md:pt-2 dark:text-zinc-400"
              >
                {g.title}
              </h3>
              <ul className="flex flex-wrap gap-2">
                {g.items.map(({ name, Icon }) => (
                  <li
                    key={name}
                    data-reveal="scale"
                    className="flex items-center gap-2 rounded-md border border-zinc-200 bg-zinc-50 px-3 py-1.5 text-sm text-zinc-800 dark:border-white/10 dark:bg-white/5 dark:text-zinc-200"
                  >
                    <Icon size={18} aria-hidden="true" />
                    {name}
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
