import Image from "next/image";
import ParticleBackground from "./components/ParticleBackground";
import GitHubIcon from "./components/icons/GitHubIcon";
import EmailIcon from "./components/icons/EmailIcon";
import Skills from "./components/Skills";
import Experience from "./components/Experience";
import Education from "./components/Education";
import OpenSource from "./components/OpenSource";
import Honors from "./components/Honors";
import Nav from "./components/Nav";
import Leadership from "./components/Leadership";
import Contact from "./components/Contact";
import Footer from "./components/Footer";
import { ThemeToggle } from "./components/ThemeToggle";
import SocialLinks from "./components/SocialLinks";

export default function Home() {
  return (
    <div className="relative min-h-screen bg-zinc-50 font-sans dark:bg-black">
      <ParticleBackground />

      {/* Theme Toggle - Fixed bottom left on mobile (clear of the nav and back-to-top), top right on desktop */}
      <div className="fixed bottom-4 left-4 z-50 md:bottom-auto md:left-auto md:right-6 md:top-6">
        <ThemeToggle />
      </div>

      {/* Social Links - Fixed on left side */}
      <SocialLinks />

      {/* Hero Section */}
      <section
        id="about"
        className="relative z-10 flex min-h-screen items-center px-6 py-24 md:px-24"
      >
        <div className="mx-auto w-full max-w-5xl">
          <div className="flex flex-col-reverse gap-8 md:flex-row md:items-center md:justify-between md:gap-12">
            {/* Name & Title */}
            <div className="max-w-2xl">
              <p className="mb-4 font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">
                Taipei, Taiwan · CSIE @ NTUST &apos;28
              </p>
              <h1 className="text-5xl font-bold tracking-tight text-black md:text-7xl dark:text-white">
                Stanley Owen
              </h1>
              <p className="mt-5 text-xl font-light text-zinc-600 md:text-2xl dark:text-zinc-400">
                Building mobile and cross-platform apps, AI systems, and
                open-source software.
              </p>
            </div>

            {/* Profile Photo */}
            <Image
              src="/profile.jpg"
              alt="Stanley Owen"
              width={176}
              height={176}
              className="h-28 w-28 shrink-0 rounded-full border-4 border-white/20 shadow-2xl md:h-44 md:w-44 dark:border-white/10"
              priority
            />
          </div>

          {/* About Me */}
          <p className="mt-8 max-w-2xl text-lg leading-relaxed text-zinc-700 dark:text-zinc-300">
            I developed and maintained a company&apos;s sales and invoicing
            system for nearly four years, and built the research tools for an
            NSTC-funded NLP project, running on Windows, macOS and Linux. These
            days I&apos;m focused on AI systems, and I also enjoy self-hosting
            and infrastructure work, from running my own servers to connecting
            them through the cloud.
          </p>

          {/* Social Links */}
          <div className="mt-10 flex flex-wrap gap-4">
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
              href="#contact"
              className="flex items-center gap-2 px-6 py-3 bg-zinc-200 dark:bg-zinc-800 text-black dark:text-white rounded-full font-medium transition-all hover:scale-105 hover:shadow-lg"
            >
              <EmailIcon />
              Contact
            </a>
          </div>
        </div>
      </section>

      <Nav />

      <Education />
      <Experience />
      <OpenSource />
      <Honors />
      <Leadership />
      <Skills />

      {/* Contact Section */}
      <div id="contact">
        <Contact />
      </div>

      {/* Footer */}
      <Footer />
    </div>
  );
}
