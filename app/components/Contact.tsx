"use client";

import { useState } from "react";
import EmailIcon from "./icons/EmailIcon";
import GitHubIcon from "./icons/GitHubIcon";
import LinkedInIcon from "./icons/LinkedInIcon";
import InstagramIcon from "./icons/InstagramIcon";

interface FormData {
  name: string;
  email: string;
  subject: string;
  message: string;
}

export default function Contact() {
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

  const contactInfo = [
    {
      icon: EmailIcon,
      label: "Email",
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
    {
      icon: InstagramIcon,
      label: "Instagram",
      value: "@stanleyowennn",
      href: "https://instagram.com/stanleyowennn",
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
    setIsSubmitting(true);
    setSubmitStatus("idle");

    try {
      const response = await fetch("/api/contact", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
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
      setIsSubmitting(false);
    }
  };

  return (
    <section className="relative z-10 w-full py-20 px-8">
      <div className="max-w-6xl mx-auto">
        <div className="text-center mb-16">
          <h2 className="text-3xl font-bold text-black dark:text-white mb-4">
            Get in Touch
          </h2>
          <p className="text-lg text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto">
            Have a project in mind or just want to chat? I'd love to hear from
            you. Let's connect and create something amazing together.
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
          {/* Contact Form */}
          <div className="bg-white/60 dark:bg-white/5 backdrop-blur-sm border-2 border-zinc-300 dark:border-white/10 rounded-lg p-8">
            <h3 className="text-xl font-bold text-black dark:text-white mb-6">
              Send me a message
            </h3>

            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label
                    htmlFor="name"
                    className="block text-sm font-medium text-black dark:text-white mb-2"
                  >
                    Name *
                  </label>
                  <input
                    type="text"
                    id="name"
                    name="name"
                    value={formData.name}
                    onChange={handleInputChange}
                    required
                    className="w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-zinc-300 dark:border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white text-black dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400"
                    placeholder="Your name"
                  />
                </div>

                <div>
                  <label
                    htmlFor="email"
                    className="block text-sm font-medium text-black dark:text-white mb-2"
                  >
                    Email *
                  </label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    value={formData.email}
                    onChange={handleInputChange}
                    required
                    className="w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-zinc-300 dark:border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white text-black dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400"
                    placeholder="your@email.com"
                  />
                </div>
              </div>

              <div>
                <label
                  htmlFor="subject"
                  className="block text-sm font-medium text-black dark:text-white mb-2"
                >
                  Subject *
                </label>
                <input
                  type="text"
                  id="subject"
                  name="subject"
                  value={formData.subject}
                  onChange={handleInputChange}
                  required
                  className="w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-zinc-300 dark:border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white text-black dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400"
                  placeholder="Project collaboration, job opportunity, etc."
                />
              </div>

              <div>
                <label
                  htmlFor="message"
                  className="block text-sm font-medium text-black dark:text-white mb-2"
                >
                  Message *
                </label>
                <textarea
                  id="message"
                  name="message"
                  value={formData.message}
                  onChange={handleInputChange}
                  required
                  rows={6}
                  className="w-full px-4 py-3 bg-white/50 dark:bg-white/5 border border-zinc-300 dark:border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white text-black dark:text-white placeholder-zinc-500 dark:placeholder-zinc-400 resize-vertical"
                  placeholder="Tell me about your project or what you'd like to discuss..."
                />
              </div>

              <button
                type="submit"
                disabled={isSubmitting}
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
                    Sending...
                  </span>
                ) : (
                  "Send Message"
                )}
              </button>

              {submitStatus === "success" && (
                <div className="text-green-600 dark:text-green-400 text-sm text-center">
                  Message sent successfully! I'll get back to you soon.
                </div>
              )}

              {submitStatus === "error" && (
                <div className="text-red-600 dark:text-red-400 text-sm text-center">
                  Something went wrong. Please try again or contact me directly.
                </div>
              )}
            </form>
          </div>

          {/* Contact Information */}
          <div className="space-y-8">
            <div>
              <h3 className="text-xl font-bold text-black dark:text-white mb-6">
                Let's connect
              </h3>
              <p className="text-zinc-600 dark:text-zinc-400 mb-8 leading-relaxed">
                I'm always interested in new opportunities, collaborations, and
                interesting projects. Whether you have a question, want to work
                together, or just want to say hello, feel free to reach out!
              </p>
            </div>

            {/* Contact Methods */}
            <div className="space-y-4">
              {contactInfo.map((contact) => {
                const IconComponent = contact.icon;
                return (
                  <a
                    key={contact.label}
                    href={contact.href}
                    target={contact.label !== "Email" ? "_blank" : undefined}
                    rel={
                      contact.label !== "Email"
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
            <div className="bg-gradient-to-r from-black to-zinc-700 dark:from-white dark:to-zinc-300 text-white dark:text-black rounded-lg p-6">
              <h4 className="font-bold text-lg mb-2">
                Ready to start a project?
              </h4>
              <p className="text-white/80 dark:text-black/80 text-sm mb-4">
                Let's discuss your ideas and bring them to life!
              </p>
              <a
                href="mailto:me@stanleyowen.com?subject=Project%20Collaboration"
                className="inline-flex items-center gap-2 px-4 py-2 bg-white/20 dark:bg-black/20 rounded-lg text-sm font-medium transition-all hover:scale-105"
              >
                <EmailIcon />
                Start a conversation
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
