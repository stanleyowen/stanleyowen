import Image from "next/image";
import { notFound } from "next/navigation";
import ParticleBackground from "../components/ParticleBackground";
import GitHubIcon from "../components/icons/GitHubIcon";
import EmailIcon from "../components/icons/EmailIcon";
import Skills from "../components/Skills";
import Experience from "../components/Experience";
import Education from "../components/Education";
import OpenSource from "../components/OpenSource";
import Honors from "../components/Honors";
import Nav from "../components/Nav";
import Leadership from "../components/Leadership";
import Contact from "../components/Contact";
import Footer from "../components/Footer";
import { ThemeToggle } from "../components/ThemeToggle";
import LanguageSwitch from "../components/LanguageSwitch";
import SocialLinks from "../components/SocialLinks";
import ScrollReveal from "../components/ScrollReveal";
import { hasLocale, languageTag } from "../i18n/config";
import { getDictionary } from "../i18n";
import { getProfile } from "../data";

export default async function Home({
  params,
}: {
  params: Promise<{ lang: string }>;
}) {
  const { lang } = await params;
  if (!hasLocale(lang)) notFound();
  const dict = getDictionary(lang);
  const profile = getProfile(lang);
  const otherLang = lang === "en" ? "zh" : "en";

  return (
    <div className="relative min-h-screen bg-zinc-50 font-sans dark:bg-black">
      <ParticleBackground />
      <ScrollReveal />

      {/* Language + theme controls - fixed bottom left on mobile (clear of the nav and back-to-top), top right on desktop */}
      <div className="fixed bottom-4 left-4 z-50 flex items-stretch gap-2 md:bottom-auto md:left-auto md:right-6 md:top-6">
        <LanguageSwitch
          locale={otherLang}
          hrefLang={languageTag[otherLang]}
          label={dict.language.switchTo}
          ariaLabel={dict.language.switchLabel}
        />
        <ThemeToggle labels={dict.theme} />
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
              <p className="intro mb-4 font-mono text-xs uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400">
                {dict.hero.eyebrow}
              </p>
              <h1 className="intro text-5xl font-bold tracking-tight text-black md:text-7xl dark:text-white [--delay:80ms]">
                Stanley Owen
                {dict.hero.nativeName && (
                  <span className="mt-2 block text-3xl font-medium tracking-normal text-zinc-500 md:text-4xl dark:text-zinc-400">
                    {dict.hero.nativeName}
                  </span>
                )}
              </h1>
              <p className="intro mt-5 text-xl font-light text-zinc-600 md:text-2xl dark:text-zinc-400 [--delay:160ms]">
                {dict.hero.tagline}
              </p>
            </div>

            {/* Profile Photo */}
            <Image
              src="/profile.jpg"
              alt={dict.hero.photoAlt}
              width={176}
              height={176}
              className="intro-pop h-28 w-28 shrink-0 rounded-full border-4 border-white/20 shadow-2xl md:h-44 md:w-44 dark:border-white/10 [--delay:120ms]"
              priority
            />
          </div>

          {/* About Me */}
          <p className="intro mt-8 max-w-2xl text-lg leading-relaxed text-zinc-700 dark:text-zinc-300 [--delay:240ms]">
            {dict.hero.about}
          </p>

          {/* Social Links */}
          <div className="intro mt-10 flex flex-wrap gap-4 [--delay:320ms]">
            <a
              href="https://github.com/stanleyowen"
              target="_blank"
              rel="noopener noreferrer"
              className="flex items-center gap-2 px-6 py-3 bg-black dark:bg-white text-white dark:text-black rounded-full font-medium transition-all hover:scale-105 hover:shadow-lg"
            >
              <GitHubIcon />
              {dict.hero.github}
            </a>

            <a
              href="#contact"
              className="flex items-center gap-2 px-6 py-3 bg-zinc-200 dark:bg-zinc-800 text-black dark:text-white rounded-full font-medium transition-all hover:scale-105 hover:shadow-lg"
            >
              <EmailIcon />
              {dict.hero.contact}
            </a>
          </div>
        </div>

        {/* Scroll cue */}
        <a
          href="#education"
          aria-label={dict.hero.scrollDown}
          className="intro absolute bottom-8 left-1/2 -translate-x-1/2 rounded-full p-2 text-zinc-400 transition-colors hover:text-zinc-900 dark:text-zinc-500 dark:hover:text-white [--delay:600ms]"
        >
          <svg
            className="scroll-cue h-7 w-7"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth={1.5}
              d="M6 9l6 6 6-6"
            />
          </svg>
        </a>
      </section>

      <Nav dict={dict.nav} />

      <Education dict={dict} education={profile.education} />
      <Experience dict={dict} experience={profile.experience} />
      <OpenSource dict={dict} openSource={profile.openSource} />
      <Honors dict={dict} awards={profile.awards} />
      <Leadership dict={dict} leadership={profile.leadership} />
      <Skills dict={dict} />

      {/* Contact Section */}
      <div id="contact">
        <Contact dict={dict.contact} language={languageTag[lang]} />
      </div>

      {/* Footer */}
      <Footer copyright={dict.footer.copyright} />
    </div>
  );
}
