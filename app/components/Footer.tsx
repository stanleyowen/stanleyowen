"use client";

export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="relative z-10 w-full border-t border-zinc-200 dark:border-white/10 bg-white/40 dark:bg-black/40 backdrop-blur-sm">
      <div className="max-w-6xl mx-auto px-8 py-8">
        <div className="flex flex-col items-center justify-center gap-4">
          <div className="text-sm text-zinc-600 dark:text-zinc-400 text-center">
            <p>&copy; {currentYear} Stanley Owen. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
  );
}
