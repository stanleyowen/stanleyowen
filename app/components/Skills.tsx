"use client";

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

export default function Skills() {
  const technologies = [
    // Markup and Styling
    { name: "HTML", Icon: HtmlIcon },
    { name: "CSS", Icon: CssIcon },
    { name: "SASS", Icon: SassIcon },

    // Programming Languages
    { name: "JavaScript", Icon: JavaScriptIcon },
    { name: "TypeScript", Icon: TypeScriptIcon },
    { name: "Python", Icon: PythonIcon },
    { name: "C", Icon: CIcon },
    { name: "C++", Icon: CppIcon },
    { name: "C#", Icon: CSharpIcon },
    { name: "PHP", Icon: PhpIcon },
    { name: "Java", Icon: JavaIcon },
    { name: "Assembly", Icon: AssemblyIcon },
    { name: "Rust", Icon: RustIcon },

    // Frameworks and Tools
    { name: "Electron", Icon: ElectronIcon },
    { name: "React", Icon: ReactIcon },
    { name: "Node.js", Icon: NodeIcon },
    { name: "MongoDB", Icon: MongoDBIcon },
    { name: "Git", Icon: GitIcon },
    { name: "Tailwind CSS", Icon: TailwindIcon },
    { name: "Bootstrap", Icon: BootstrapIcon },
    { name: "Material UI", Icon: MaterialUiIcon },
    { name: "Postman", Icon: PostmanIcon },
  ];

  return (
    <section className="relative z-10 w-full py-20 px-8">
      <div className="w-full">
        {/* Technologies & Tools Section */}
        <div>
          <h2 className="text-3xl font-bold text-center mb-8 text-black dark:text-white">
            Technologies & Tools
          </h2>
          <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 px-4">
            {technologies.map((tech) => {
              const IconComponent = tech.Icon;
              return (
                <div
                  key={tech.name}
                  className="bg-white/60 dark:bg-white/5 backdrop-blur-sm border-2 border-zinc-300 dark:border-white/10 rounded-lg p-4 flex flex-col items-center justify-center hover:bg-white/80 dark:hover:bg-white/10 transition-all hover:scale-105"
                >
                  <div className="text-black dark:text-white mb-2">
                    <IconComponent size={40} />
                  </div>
                  <span className="text-sm font-medium text-black dark:text-white">
                    {tech.name}
                  </span>
                </div>
              );
            })}
          </div>
        </div>
      </div>
    </section>
  );
}
