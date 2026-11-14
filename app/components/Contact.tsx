"use client";

import { useRef, useState } from "react";
import { Turnstile, type TurnstileInstance } from "@marsidev/react-turnstile";
import EmailIcon from "./icons/EmailIcon";
import GitHubIcon from "./icons/GitHubIcon";
import LinkedInIcon from "./icons/LinkedInIcon";
import type { Dictionary } from "../i18n";

interface FormData {
  name: string;
  email: string;
  subject: string;
  message: string;
}

export default function Contact({
  dict,
  language,
}: {
  dict: Dictionary["contact"];
  /** BCP 47 tag for the Turnstile widget, e.g. "en" or "zh-TW". */
  language: string;
}) {
  const [formData, setFormData] = useState<FormData>({
    name: "",
    email: "",
    subject: "",
    message: "",
  });
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitStatus, setSubmitStatus] = useState<
    "idle" | "success" | "error"
  >("idle");
  const [turnstileToken, setTurnstileToken] = useState<string | null>(null);
  const turnstileRef = useRef<TurnstileInstance>(null);

  const contactInfo = [
    {
      icon: EmailIcon,
      label: dict.emailLabel,
      value: "me@stanleyowen.com",
      href: "mailto:me@stanleyowen.com",
    },
    {
      icon: GitHubIcon,
      label: "GitHub",
      value: "@stanleyowen",
      href: "https://github.com/stanleyowen",
    },
    {
      icon: LinkedInIcon,
      label: "LinkedIn",
      value: "Stanley Owen",
      href: "https://linkedin.com/in/stanley-owen",
    },
  ];

  const handleInputChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>,
  ) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    if (!turnstileToken) {
      setSubmitStatus("error");
      return;
    }

    setIsSubmitting(true);
    setSubmitStatus("idle");

    try {
      const response = await fetch("/api/contact", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          ...formData,
          turnstileToken,
        }),
      });

      const data = await response.json();

      if (response.ok) {
        setSubmitStatus("success");
        setFormData({
          name: "",
          email: "",
          subject: "",
          message: "",
        });
      } else {
        throw new Error(data.error || "Failed to send message");
      }
    } catch (error) {
      console.error("Contact form error:", error);
      setSubmitStatus("error");
    } finally {
      // Turnstile tokens are single-use, so get a fresh one for the next attempt.
      setTurnstileToken(null);
      turnstileRef.current?.reset();
      setIsSubmitting(false);
    }
  };

  return (
    <section className="relative z-10 w-full py-20 px-8">
      <div className="max-w-6xl mx-auto">
        <div data-reveal className="text-center mb-16">
          <h2 className="text-3xl font-bold text-black dark:text-white mb-4">
            {dict.title}
          </h2>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
          {/* Contact Form */}
          <div
            data-reveal
            className="bg-white/60 dark:bg-white/5 backdrop-blur-sm border-2 border-zinc-300 dark:border-white/10 rounded-lg p-8"
          >
            <h3 className="text-xl font-bold text-black dark:text-white mb-6">
              {dict.formTitle}
            </h3>

            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label
                    htmlFor="name"
                    className="block text-sm font-medium text-black dark:text-white mb-2"
                  >
                    {dict.name} *
                  </label>
                  <input
                    type="text"
                    id="name"
                    name="name"
                    maxLength={100}
                    value={formData.name}
                    onChange={handleInputChange}
                    required
                    className="w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-zinc-300 dark:border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white text-black dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400"
                    placeholder={dict.namePlaceholder}
                  />
                </div>

                <div>
                  <label
                    htmlFor="email"
                    className="block text-sm font-medium text-black dark:text-white mb-2"
                  >
                    {dict.email} *
                  </label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    maxLength={254}
                    value={formData.email}
                    onChange={handleInputChange}
                    required
                    className="w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-zinc-300 dark:border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white text-black dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400"
                    placeholder={dict.emailPlaceholder}
                  />
                </div>
              </div>

              <div>
                <label
                  htmlFor="subject"
                  className="block text-sm font-medium text-black dark:text-white mb-2"
                >
                  {dict.subject} *
                </label>
                <input
                  type="text"
                  id="subject"
                  name="subject"
                  maxLength={200}
                  value={formData.subject}
                  onChange={handleInputChange}
                  required
                  className="w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-zinc-300 dark:border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white text-black dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400"
                  placeholder={dict.subjectPlaceholder}
                />
              </div>

              <div>
                <label
                  htmlFor="message"
                  className="block text-sm font-medium text-black dark:text-white mb-2"
                >
                  {dict.message} *
                </label>
                <textarea
                  id="message"
                  name="message"
                  maxLength={5000}
                  value={formData.message}
                  onChange={handleInputChange}
                  required
                  rows={6}
                  className="w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-zinc-300 dark:border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white text-black dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 resize-vertical"
                  placeholder={dict.messagePlaceholder}
                />
              </div>

              {/* Cloudflare Turnstile */}
              <div className="flex justify-center">
                <Turnstile
                  ref={turnstileRef}
                  siteKey={
                    process.env.NEXT_PUBLIC_TURNSTILE_SITE_KEY ||
                    "1x00000000000000000000AA"
                  }
                  onSuccess={(token) => setTurnstileToken(token)}
                  onError={() => setTurnstileToken(null)}
                  onExpire={() => setTurnstileToken(null)}
                  options={{ language }}
                />
              </div>

              <button
                type="submit"
                disabled={isSubmitting || !turnstileToken}
                className="w-full px-6 py-3 bg-black dark:bg-white text-white dark:text-black rounded-lg font-medium transition-all hover:scale-105 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
              >
                {isSubmitting ? (
                  <span className="flex items-center justify-center gap-2">
                    <svg className="animate-spin h-4 w-4" viewBox="0 0 24 24">
                      <circle
                        className="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        strokeWidth="4"
                        fill="none"
                      />
                      <path
                        className="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                      />
                    </svg>
                    {dict.sending}
                  </span>
                ) : (
                  dict.send
                )}
              </button>

              {submitStatus === "success" && (
                <div className="text-green-600 dark:text-green-400 text-sm text-center">
                  {dict.success}
                </div>
              )}

              {submitStatus === "error" && (
                <div className="text-red-600 dark:text-red-400 text-sm text-center">
                  {dict.error}
                </div>
              )}
            </form>
          </div>

          {/* Contact Information */}
          <div className="space-y-8">
            <div data-reveal>
              <h3 className="text-xl font-bold text-black dark:text-white mb-6">
                {dict.talkTitle}
              </h3>
              <p className="text-zinc-600 dark:text-zinc-400 mb-8 leading-relaxed">
                {dict.talkBody}
              </p>
            </div>

            {/* Contact Methods */}
            <div data-reveal className="space-y-4">
              {contactInfo.map((contact) => {
                const IconComponent = contact.icon;
                return (
                  <a
                    key={contact.label}
                    href={contact.href}
                    target={!contact.href.startsWith("mailto:") ? "_blank" : undefined}
                    rel={
                      !contact.href.startsWith("mailto:")
                        ? "noopener noreferrer"
                        : undefined
                    }
                    className="flex items-center gap-4 p-4 bg-white/60 dark:bg-white/5 backdrop-blur-sm border border-zinc-300 dark:border-white/10 rounded-lg transition-all hover:scale-105 hover:bg-white/80 dark:hover:bg-white/10"
                  >
                    <div className="flex-shrink-0 w-12 h-12 bg-black dark:bg-white text-white dark:text-black rounded-full flex items-center justify-center">
                      <IconComponent />
                    </div>
                    <div>
                      <div className="font-medium text-black dark:text-white">
                        {contact.label}
                      </div>
                      <div className="text-zinc-600 dark:text-zinc-400 text-sm">
                        {contact.value}
                      </div>
                    </div>
                    <svg
                      className="w-5 h-5 text-zinc-400 dark:text-zinc-500 ml-auto"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                      />
                    </svg>
                  </a>
                );
              })}
            </div>

            {/* Call to Action */}
            <div
              data-reveal
              className="bg-gradient-to-r from-black to-zinc-700 dark:from-white dark:to-zinc-300 text-white dark:text-black rounded-lg p-6"
            >
              <h4 className="font-bold text-lg mb-2">
                {dict.ctaTitle}
              </h4>
              <p className="text-white/80 dark:text-black/80 text-sm mb-4">
                {dict.ctaBody}
              </p>
              <a
                href={`mailto:me@stanleyowen.com?subject=${encodeURIComponent(dict.ctaSubject)}`}
                className="inline-flex items-center gap-2 px-4 py-2 bg-white/20 dark:bg-black/20 rounded-lg text-sm font-medium transition-all hover:scale-105"
              >
                <EmailIcon />
                {dict.ctaButton}
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
