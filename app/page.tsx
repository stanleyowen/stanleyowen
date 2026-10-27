import Image from "next/image";
import ParticleBackground from "./components/ParticleBackground";
import GitHubIcon from "./components/icons/GitHubIcon";
import EmailIcon from "./components/icons/EmailIcon";
import DocumentIcon from "./components/icons/DocumentIcon";
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
      <section id="about" className="relative z-10 flex min-h-screen flex-col items-center justify-center px-8 py-20">
        {/* Profile Photo */}
        <div className="mb-8">
          <Image
            src="/icon.png"
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
            Computer Science Student, NTUST (Class of 2028)
          </p>
        </div>

        {/* About Me */}
        <div className="max-w-2xl text-center mb-10">
          <p className="text-lg text-zinc-700 dark:text-zinc-300 leading-relaxed">
            Computer Science student at NTUST and software engineer. I led the
            development of production desktop software for nearly four years,
            conducted NLP research on mental health, and build cross-platform
            applications with clean interfaces and dependable systems.
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
            href="/%E5%BC%B5%E9%8A%98%E5%85%83%20STANLEY%20OWEN%20-%20CV.pdf"
            target="_blank"
            rel="noopener noreferrer"
            className="flex items-center gap-2 px-6 py-3 bg-zinc-200 dark:bg-zinc-800 text-black dark:text-white rounded-full font-medium transition-all hover:scale-105 hover:shadow-lg"
          >
            <DocumentIcon />
            View CV
          </a>

          <a
            href="#contact"
            className="flex items-center gap-2 px-6 py-3 bg-zinc-200 dark:bg-zinc-800 text-black dark:text-white rounded-full font-medium transition-all hover:scale-105 hover:shadow-lg"
          >
            <EmailIcon />
            Contact
          </a>
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
