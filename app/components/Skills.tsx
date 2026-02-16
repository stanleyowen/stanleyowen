"use client";

import ElectronIcon from "./icons/ElectronIcon";
import ReactIcon from "./icons/ReactIcon";
import NodeIcon from "./icons/NodeIcon";
import MongoDBIcon from "./icons/MongoDBIcon";
import GitIcon from "./icons/GitIcon";
import TailwindIcon from "./icons/TailwindIcon";

export default function Skills() {
  const technologies = [
    // Programming Languages
    {
      name: "JavaScript",
      type: "language",
      color: "bg-yellow-200 text-yellow-800 border-yellow-400 dark:bg-yellow-500/20 dark:text-yellow-300 dark:border-yellow-500/30",
    },
    {
      name: "TypeScript", 
      type: "language",
      color: "bg-blue-200 text-blue-800 border-blue-400 dark:bg-blue-500/20 dark:text-blue-300 dark:border-blue-500/30",
    },
    {
      name: "Python",
      type: "language", 
      color: "bg-green-200 text-green-800 border-green-400 dark:bg-green-500/20 dark:text-green-300 dark:border-green-500/30",
    },
    {
      name: "Rust",
      type: "language",
      color: "bg-orange-200 text-orange-800 border-orange-400 dark:bg-orange-500/20 dark:text-orange-300 dark:border-orange-500/30", 
    },
    {
      name: "C++",
      type: "language",
      color: "bg-purple-200 text-purple-800 border-purple-400 dark:bg-purple-500/20 dark:text-purple-300 dark:border-purple-500/30",
    },
    // Frameworks and Tools
    { name: "Electron", type: "tool", Icon: ElectronIcon },
    { name: "React", type: "tool", Icon: ReactIcon },
    { name: "Node.js", type: "tool", Icon: NodeIcon },
    { name: "MongoDB", type: "tool", Icon: MongoDBIcon },
    { name: "Git", type: "tool", Icon: GitIcon },
    { name: "Tailwind CSS", type: "tool", Icon: TailwindIcon },
  ];

  return (
    <section className="relative z-10 w-full py-20 px-8">
      <div className="max-w-6xl mx-auto">
        {/* Technologies & Tools Section */}
        <div>
          <h2 className="text-3xl font-bold text-center mb-8 text-black dark:text-white">
            Technologies & Tools
          </h2>
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {technologies.map((tech) => {
              if (tech.type === "language") {
                return (
                  <div
                    key={tech.name}
                    className={`bg-white/60 dark:bg-white/5 backdrop-blur-sm border-2 rounded-lg p-4 flex items-center justify-center hover:bg-white/80 dark:hover:bg-white/10 transition-all hover:scale-105 ${tech.color}`}
                  >
                    <span className="text-sm font-medium">
                      {tech.name}
                    </span>
                  </div>
                );
              } else {
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
              }
            })}
          </div>
        </div>
      </div>
    </section>
  );
}
