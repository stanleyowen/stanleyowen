"use client";

import { useEffect, useState } from "react";
import GitHubIcon from "./icons/GitHubIcon";

interface GitHubRepo {
  id: number;
  name: string;
  full_name: string;
  description: string | null;
  html_url: string;
  homepage: string | null;
  stargazers_count: number;
  forks_count: number;
  language: string | null;
  topics: string[];
  updated_at: string;
  private: boolean;
}

export default function Projects() {
  const [repos, setRepos] = useState<GitHubRepo[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    fetch("/api/github-repos")
      .then((res) => {
        if (!res.ok) throw new Error("Failed to fetch repositories");
        return res.json();
      })
      .then((data) => {
        setRepos(data);
        setLoading(false);
      })
      .catch((err) => {
        setError(err.message);
        setLoading(false);
      });
  }, []);

  const getLanguageColor = (language: string | null) => {
    const colors: { [key: string]: string } = {
      JavaScript:
        "bg-yellow-200 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300",
      TypeScript:
        "bg-blue-200 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300",
      Python:
        "bg-green-200 text-green-800 dark:bg-green-500/20 dark:text-green-300",
      Rust: "bg-orange-200 text-orange-800 dark:bg-orange-500/20 dark:text-orange-300",
      "C++":
        "bg-purple-200 text-purple-800 dark:bg-purple-500/20 dark:text-purple-300",
      CSS: "bg-pink-200 text-pink-800 dark:bg-pink-500/20 dark:text-pink-300",
      HTML: "bg-red-200 text-red-800 dark:bg-red-500/20 dark:text-red-300",
    };
    return (
      colors[language || ""] ||
      "bg-zinc-200 text-zinc-800 dark:bg-zinc-500/20 dark:text-zinc-300"
    );
  };

  if (loading) {
    return (
      <section className="relative z-10 w-full py-20 px-8">
        <div className="max-w-6xl mx-auto">
          <h2 className="text-3xl font-bold text-center mb-8 text-black dark:text-white">
            Projects
          </h2>
          <div className="text-center text-zinc-600 dark:text-zinc-400">
            Loading projects...
          </div>
        </div>
      </section>
    );
  }

  if (error) {
    return (
      <section className="relative z-10 w-full py-20 px-8">
        <div className="max-w-6xl mx-auto">
          <h2 className="text-3xl font-bold text-center mb-8 text-black dark:text-white">
            Projects
          </h2>
          <div className="text-center text-red-600 dark:text-red-400">
            {error}
          </div>
        </div>
      </section>
    );
  }

  return (
    <section className="relative z-10 w-full py-20 px-8">
      <div className="max-w-6xl mx-auto">
        <h2 className="text-3xl font-bold text-center mb-12 text-black dark:text-white">
          Featured Projects
        </h2>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {repos.map((repo) => (
            <div
              key={repo.id}
              className="bg-white/60 dark:bg-white/5 backdrop-blur-sm border-2 border-zinc-300 dark:border-white/10 rounded-lg p-6 hover:bg-white/80 dark:hover:bg-white/10 transition-all hover:scale-105"
            >
              {/* Repo Name */}
              <div className="flex items-start justify-between mb-3">
                <h3 className="text-xl font-bold text-black dark:text-white line-clamp-1">
                  {repo.name}
                </h3>
                {repo.private && (
                  <span className="ml-2 px-2 py-1 text-xs rounded-full bg-yellow-200 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300">
                    Private
                  </span>
                )}
              </div>

              {/* Description */}
              <p className="text-zinc-600 dark:text-zinc-400 text-sm mb-4 line-clamp-3 min-h-[60px]">
                {repo.description || "No description available"}
              </p>

              {/* Language Badge */}
              {repo.language && (
                <div className="mb-4">
                  <span
                    className={`inline-block px-3 py-1 rounded-full text-xs font-medium ${getLanguageColor(
                      repo.language,
                    )}`}
                  >
                    {repo.language}
                  </span>
                </div>
              )}

              {/* Stats */}
              <div className="flex items-center gap-4 text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                <div className="flex items-center gap-1">
                  <svg
                    className="w-4 h-4"
                    fill="currentColor"
                    viewBox="0 0 16 16"
                  >
                    <path d="M8 .25a.75.75 0 01.673.418l1.882 3.815 4.21.612a.75.75 0 01.416 1.279l-3.046 2.97.719 4.192a.75.75 0 01-1.088.791L8 12.347l-3.766 1.98a.75.75 0 01-1.088-.79l.72-4.194L.818 6.374a.75.75 0 01.416-1.28l4.21-.611L7.327.668A.75.75 0 018 .25z" />
                  </svg>
                  <span>{repo.stargazers_count}</span>
                </div>
                <div className="flex items-center gap-1">
                  <svg
                    className="w-4 h-4"
                    fill="currentColor"
                    viewBox="0 0 16 16"
                  >
                    <path d="M5 5.372v.878c0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75v-.878a2.25 2.25 0 111.5 0v.878a2.25 2.25 0 01-2.25 2.25h-1.5v2.128a2.251 2.251 0 11-1.5 0V8.5h-1.5A2.25 2.25 0 013.5 6.25v-.878a2.25 2.25 0 111.5 0zM5 3.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm6.75.75a.75.75 0 100-1.5.75.75 0 000 1.5zm-3 8.75a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                  </svg>
                  <span>{repo.forks_count}</span>
                </div>
              </div>

              {/* Links */}
              <div className="flex gap-2">
                <a
                  href={repo.html_url}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-black dark:bg-white text-white dark:text-black rounded-lg font-medium transition-all hover:scale-105 hover:shadow-lg"
                >
                  <GitHubIcon />
                  <span className="text-sm">View Code</span>
                </a>
                {repo.homepage && (
                  <a
                    href={repo.homepage}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="flex items-center justify-center px-4 py-2 bg-zinc-200 dark:bg-zinc-800 text-black dark:text-white rounded-lg font-medium transition-all hover:scale-105 hover:shadow-lg"
                    aria-label="View Live Demo"
                  >
                    <svg
                      className="w-5 h-5"
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
                )}
              </div>
            </div>
          ))}
        </div>

        {/* View All on GitHub */}
        <div className="text-center mt-12">
          <a
            href="https://github.com/stanleyowen"
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-2 px-6 py-3 bg-black dark:bg-white text-white dark:text-black rounded-full font-medium transition-all hover:scale-105 hover:shadow-lg"
          >
            <GitHubIcon />
            View More on GitHub
          </a>
        </div>
      </div>
    </section>
  );
}
