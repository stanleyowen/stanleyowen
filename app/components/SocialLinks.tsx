"use client";

import GitHubIcon from "./icons/GitHubIcon";
import LinkedInIcon from "./icons/LinkedInIcon";
import InstagramIcon from "./icons/InstagramIcon";
import EmailIcon from "./icons/EmailIcon";

export default function SocialLinks() {
  const socialLinks = [
    {
      name: "GitHub",
      url: "https://github.com/stanleyowen",
      icon: GitHubIcon,
      color: "hover:bg-gray-200 dark:hover:bg-gray-600",
    },
    {
      name: "LinkedIn",
      url: "https://linkedin.com/in/stanley-owen",
      icon: LinkedInIcon,
      color: "hover:bg-blue-400 dark:hover:bg-blue-500",
    },
    {
      name: "Instagram",
      url: "https://instagram.com/stanleyowennn",
      icon: InstagramIcon,
      color: "hover:bg-pink-400 dark:hover:bg-pink-500",
    },
    {
      name: "Email",
      url: "mailto:me@stanleyowen.com",
      icon: EmailIcon,
      color: "hover:bg-green-500 dark:hover:bg-green-500",
    },
  ];

  return (
    <div className="fixed left-6 top-1/2 -translate-y-1/2 z-50 hidden md:flex flex-col gap-4">
      {socialLinks.map((link) => {
        const IconComponent = link.icon;
        return (
          <a
            key={link.name}
            href={link.url}
            target={link.name !== "Email" ? "_blank" : undefined}
            rel={link.name !== "Email" ? "noopener noreferrer" : undefined}
            aria-label={link.name}
            className={`p-3 bg-white/60 dark:bg-white/10 backdrop-blur-sm border-2 border-zinc-300 dark:border-white/20 rounded-full text-black dark:text-white transition-all hover:scale-110 ${link.color}`}
          >
            <IconComponent />
          </a>
        );
      })}
    </div>
  );
}
