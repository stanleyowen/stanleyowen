"use client";

import { useEffect, useState, useRef } from "react";
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
  const [translateX, setTranslateX] = useState(0);
  const [isPaused, setIsPaused] = useState(false);
  const [isDragging, setIsDragging] = useState(false);
  const [startX, setStartX] = useState(0);
  const [dragOffset, setDragOffset] = useState(0);
  const containerRef = useRef<HTMLDivElement>(null);
  const sliderRef = useRef<HTMLDivElement>(null);
  const animationRef = useRef<number | undefined>(undefined);
  const lastTimeRef = useRef<number>(0);

  // Speed: ~1cm per second ≈ 38 pixels per second
  const scrollSpeed = 38;

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

  // Continuous smooth scrolling animation
  useEffect(() => {
    if (repos.length === 0 || isPaused || isDragging) {
      if (animationRef.current) {
        cancelAnimationFrame(animationRef.current);
      }
      return;
    }

    const animate = (currentTime: number) => {
      if (lastTimeRef.current === 0) {
        lastTimeRef.current = currentTime;
      }

      const deltaTime = (currentTime - lastTimeRef.current) / 1000;
      const movement = scrollSpeed * deltaTime;

      setTranslateX((prev) => {
        let newTranslate = prev - movement;

        // Seamless loop: reset when we've moved one full set of original items
        if (containerRef.current && sliderRef.current) {
          // Get the actual width of the first card to account for responsive sizes
          const firstCard = sliderRef.current.children[0] as HTMLElement;
          const itemWidth = firstCard ? firstCard.offsetWidth : 0;
          const oneSetWidth = itemWidth * repos.length;

          // Reset smoothly when we've scrolled past the original set
          if (Math.abs(newTranslate) >= oneSetWidth) {
            newTranslate = 0;
          }
        }

        return newTranslate;
      });

      lastTimeRef.current = currentTime;

      if (!isPaused && !isDragging) {
        animationRef.current = requestAnimationFrame(animate);
      }
    };

    animationRef.current = requestAnimationFrame(animate);

    return () => {
      if (animationRef.current) {
        cancelAnimationFrame(animationRef.current);
      }
    };
  }, [repos.length, isPaused, isDragging, scrollSpeed]);

  // Touch/Mouse handlers for manual sliding
  const handleStart = (clientX: number) => {
    setIsDragging(true);
    setStartX(clientX);
    setDragOffset(0);
    if (animationRef.current) {
      cancelAnimationFrame(animationRef.current);
    }
    lastTimeRef.current = 0;
  };

  const handleMove = (clientX: number) => {
    if (!isDragging) return;
    const diff = clientX - startX;
    setDragOffset(diff);
  };

  const handleEnd = () => {
    if (!isDragging) return;

    setIsDragging(false);

    // Apply the drag offset smoothly
    setTranslateX((prev) => {
      let newPos = prev + dragOffset;

      // Normalize position to prevent infinite scrolling in wrong direction
      if (containerRef.current && sliderRef.current) {
        // Get the actual width of the first card to account for responsive sizes
        const firstCard = sliderRef.current.children[0] as HTMLElement;
        const itemWidth = firstCard ? firstCard.offsetWidth : 0;
        const oneSetWidth = itemWidth * repos.length;

        // Keep within bounds for smooth experience
        while (newPos > itemWidth) {
          newPos -= oneSetWidth;
        }
        while (newPos < -oneSetWidth) {
          newPos += oneSetWidth;
        }
      }

      return newPos;
    });

    setDragOffset(0);
    lastTimeRef.current = 0;
  };

  const handleMouseEnter = () => setIsPaused(true);
  const handleMouseLeave = () => {
    setIsPaused(false);
    lastTimeRef.current = 0; // Reset timer when resuming
  };

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

        {/* Slider Container */}
        <div className="relative">
          {/* Pause/Play Control */}
          <button
            onClick={() => {
              const wasPaused = isPaused;
              setIsPaused(!wasPaused);
              if (wasPaused) {
                lastTimeRef.current = 0;
              }
            }}
            className="absolute top-4 right-4 z-20 p-3 bg-white/80 dark:bg-white/20 backdrop-blur-sm rounded-full shadow-lg hover:bg-white dark:hover:bg-white/30 transition-all"
            aria-label={isPaused ? "Resume scrolling" : "Pause scrolling"}
          >
            {isPaused ? (
              <svg
                className="w-5 h-5 text-black dark:text-white"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path d="M8 5v14l11-7z" />
              </svg>
            ) : (
              <svg
                className="w-5 h-5 text-black dark:text-white"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" />
              </svg>
            )}
          </button>

          {/* Slider Viewport */}
          <div
            ref={containerRef}
            className="overflow-hidden rounded-xl cursor-grab active:cursor-grabbing select-none"
            onMouseEnter={handleMouseEnter}
            onMouseLeave={handleMouseLeave}
            onMouseDown={(e) => {
              e.preventDefault();
              handleStart(e.clientX);
            }}
            onMouseMove={(e) => handleMove(e.clientX)}
            onMouseUp={handleEnd}
            onTouchStart={(e) => handleStart(e.touches[0].clientX)}
            onTouchMove={(e) => handleMove(e.touches[0].clientX)}
            onTouchEnd={handleEnd}
          >
            {/* Slider Track */}
            <div
              ref={sliderRef}
              className="flex will-change-transform"
              style={{
                transform: `translateX(${translateX + (isDragging ? dragOffset : 0)}px)`,
                transition: isDragging ? "none" : undefined,
              }}
            >
              {/* Triple repos for ultra-smooth seamless loop */}
              {[...repos, ...repos, ...repos].map((repo, index) => (
                <div
                  key={`${repo.id}-${Math.floor(index / repos.length)}-${index % repos.length}`}
                  className="w-full sm:w-1/2 lg:w-1/3 shrink-0 px-2"
                >
                  {/* Project Card */}
                  <div
                    className="bg-white/60 dark:bg-white/5 backdrop-blur-sm border-2 border-zinc-300 dark:border-white/10 rounded-lg p-4 hover:bg-white/80 dark:hover:bg-white/10 transition-all h-full flex flex-col"
                    style={{ minHeight: "400px" }}
                  >
                    {/* Repo Name */}
                    <div className="flex items-start justify-between mb-3">
                      <h3 className="text-lg font-bold text-black dark:text-white line-clamp-2">
                        {repo.name}
                      </h3>
                      {repo.private && (
                        <span className="ml-2 px-2 py-1 text-xs rounded-full bg-yellow-200 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300 shrink-0">
                          Private
                        </span>
                      )}
                    </div>

                    {/* Description */}
                    <p className="text-zinc-600 dark:text-zinc-400 text-sm mb-4 leading-relaxed line-clamp-3 grow">
                      {repo.description || "No description available"}
                    </p>

                    {/* Language and Topics */}
                    <div className="mb-4">
                      {repo.language && (
                        <span
                          className={`inline-block px-3 py-1 rounded-full text-xs font-medium mr-2 mb-2 ${getLanguageColor(
                            repo.language,
                          )}`}
                        >
                          {repo.language}
                        </span>
                      )}
                      {repo.topics?.slice(0, 2).map((topic) => (
                        <span
                          key={topic}
                          className="inline-block px-2 py-1 mr-1 mb-1 text-xs rounded-full bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300"
                        >
                          {topic}
                        </span>
                      ))}
                    </div>

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
                    <div className="flex gap-2 mt-auto">
                      <a
                        href={repo.html_url}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-black dark:bg-white text-white dark:text-black rounded-lg font-medium transition-all hover:scale-105 hover:shadow-lg text-sm"
                        onClick={(e) => e.stopPropagation()}
                      >
                        <GitHubIcon />
                        <span>Code</span>
                      </a>
                      {repo.homepage && (
                        <a
                          href={repo.homepage}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="flex items-center justify-center px-3 py-2 bg-zinc-200 dark:bg-zinc-800 text-black dark:text-white rounded-lg font-medium transition-all hover:scale-105 hover:shadow-lg text-sm"
                          onClick={(e) => e.stopPropagation()}
                        >
                          <svg
                            className="w-4 h-4"
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
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* View All on GitHub */}
        <div className="text-center mt-16">
          <a
            href="https://github.com/stanleyowen"
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-3 px-8 py-4 bg-black dark:bg-white text-white dark:text-black rounded-full font-medium transition-all hover:scale-105 hover:shadow-lg"
          >
            <GitHubIcon />
            Explore More Projects on GitHub
          </a>
        </div>
      </div>
    </section>
  );
}
