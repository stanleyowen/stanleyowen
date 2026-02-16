import Image from "next/image";
import ParticleBackground from "./components/ParticleBackground";
import GitHubIcon from "./components/icons/GitHubIcon";
import EmailIcon from "./components/icons/EmailIcon";
import Skills from "./components/Skills";
import { ThemeToggle } from "./components/ThemeToggle";

export default function Home() {
  return (
    <div className="relative min-h-screen bg-zinc-50 font-sans dark:bg-black">
      <ParticleBackground />

      {/* Theme Toggle - Fixed in top right corner */}
      <div className="fixed top-6 right-6 z-50">
        <ThemeToggle />
      </div>

      {/* Hero Section */}
      <section className="relative z-10 flex min-h-screen flex-col items-center justify-center px-8 py-20">
        {/* Profile Photo */}
        <div className="mb-8">
          <Image
            src="https://github.com/stanleyowen.png"
            alt="Stanley Owen"
            width={160}
            height={160}
            className="rounded-full border-4 border-white/20 dark:border-white/10 shadow-2xl"
            priority
          />
        </div>

        {/* Name & Title */}
        <div className="text-center mb-6">
          <h1 className="text-4xl md:text-5xl font-bold text-black dark:text-white mb-3">
            Stanley Owen
          </h1>
          <p className="text-xl md:text-2xl text-zinc-600 dark:text-zinc-400 font-light">
            Full Stack & Cross-Platform Software Engineer
          </p>
        </div>

        {/* About Me */}
        <div className="max-w-2xl text-center mb-10">
          <p className="text-lg text-zinc-700 dark:text-zinc-300 leading-relaxed">
            Passionate about building elegant solutions and creating meaningful
            digital experiences. I enjoy developing cross-platform applications,
            combining modern UI design with high-performance systems
            programming.
          </p>
        </div>

        {/* Social Links */}
        <div className="flex gap-4 flex-wrap justify-center">
          <a
            href="https://github.com/stanleyowen"
            target="_blank"
            rel="noopener noreferrer"
            className="flex items-center gap-2 px-6 py-3 bg-black dark:bg-white text-white dark:text-black rounded-full font-medium transition-all hover:scale-105 hover:shadow-lg"
          >
            <GitHubIcon />
            GitHub
          </a>

          <a
            href="mailto:contact@stanleyowen.com"
            className="flex items-center gap-2 px-6 py-3 bg-zinc-200 dark:bg-zinc-800 text-black dark:text-white rounded-full font-medium transition-all hover:scale-105 hover:shadow-lg"
          >
            <EmailIcon />
            Contact
          </a>
        </div>
      </section>

      {/* Skills Section */}
      <Skills />
    </div>
  );
}
