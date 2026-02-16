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
      tooltip: "stanleyowen",
    },
    {
      name: "LinkedIn",
      url: "https://linkedin.com/in/stanley-owen",
      icon: LinkedInIcon,
      color: "hover:bg-blue-400 dark:hover:bg-blue-500",
      tooltip: "in/stanley-owen",
    },
    {
      name: "Instagram",
      url: "https://instagram.com/stanleyowennn",
      icon: InstagramIcon,
      color: "hover:bg-pink-400 dark:hover:bg-pink-500",
      tooltip: "stanleyowennn",
    },
    {
      name: "Email",
      url: "mailto:me@stanleyowen.com",
      icon: EmailIcon,
      color: "hover:bg-green-500 dark:hover:bg-green-500",
      tooltip: "me@stanleyowen.com",
    },
  ];

  return (
    <div className="fixed left-6 top-1/2 -translate-y-1/2 z-50 hidden md:flex flex-col gap-4">
      {socialLinks.map((link) => {
        const IconComponent = link.icon;
        return (
          <div key={link.name} className="relative group">
            <a
              href={link.url}
              target={link.name !== "Email" ? "_blank" : undefined}
              rel={link.name !== "Email" ? "noopener noreferrer" : undefined}
              aria-label={link.name}
              className={`p-3 bg-white/60 dark:bg-white/10 backdrop-blur-sm border-2 border-zinc-300 dark:border-white/20 rounded-full text-black dark:text-white transition-all hover:scale-110 ${link.color} block`}
            >
              <IconComponent />
            </a>
            <div className="absolute left-full ml-3 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-black/90 dark:bg-white/90 text-white dark:text-black text-sm rounded-lg whitespace-nowrap opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-none">
              {link.tooltip}
              <div className="absolute right-full top-1/2 -translate-y-1/2 w-0 h-0 border-t-[6px] border-t-transparent border-b-[6px] border-b-transparent border-r-[6px] border-r-black/90 dark:border-r-white/90"></div>
            </div>
          </div>
        );
      })}
    </div>
  );
}
