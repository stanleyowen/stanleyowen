export interface ExperienceItem {
  role: string;
  organization: string;
  location: string;
  period: string;
  summary: string;
  highlights: string[];
  stack: string[];
}

export interface EducationItem {
  school: string;
  degree: string;
  period: string;
  note: string;
  highlights: string[];
}

export interface LeadershipRole {
  title: string;
  period: string;
}

/**
 * Either a single role (`role` + `summary`), or several items at the same
 * organization (`roles`), which render as one entry with a list underneath.
 * With `roles`, setting `role` too makes it the heading ("Teaching Assistant ·
 * NTUST") and the list items name what it covered, e.g. the courses.
 */
export interface LeadershipItem {
  organization: string;
  period: string;
  role?: string;
  summary?: string;
  roles?: LeadershipRole[];
}

export interface OpenSourceItem {
  name: string;
  role: string;
  period: string;
  summary: string;
  stack: string[];
  links: { label: string; href: string }[];
}

export interface AwardItem {
  title: string;
  issuer: string;
  date: string;
}

export const openSource: OpenSourceItem[] = [
  {
    name: "TigerDuck",
    role: "Contributor",
    period: "Mar 2026 – Present",
    summary:
      "A campus app built by NTUST students for NTUST students, bringing together resources that used to be scattered across different school websites. It syncs Moodle assignments and class timetables with push reminders, uses an LLM on the backend to sort and deduplicate school announcements, and shows grades and library records. It’s available on the App Store, Google Play and F-Droid in more than 67 languages.",
    stack: ["Swift", "Kotlin", "Python", "FastAPI", "TypeScript", "React"],
    links: [
      { label: "GitHub", href: "https://github.com/tigerduck-app" },
      { label: "Website", href: "https://tigerduck.app" },
    ],
  },
];

export const experience: ExperienceItem[] = [
  {
    role: "Industry–Academia Collaboration Participant",
    organization: "NTUST · International Games System Co., Ltd",
    location: "Taipei, Taiwan · Hybrid",
    period: "Sep 2026 – Present",
    summary: "",
    highlights: [],
    stack: [],
  },
  {
    role: "Industry–Academia Collaboration Participant, LIWC-Style Psycholinguistic NLP Model",
    organization: "NTUST · National Science and Technology Council",
    location: "Taipei, Taiwan · Hybrid",
    period: "Oct 2025 – Jun 2026",
    summary:
      "Worked on a system that combines NLP and emotion recognition to analyze writing for signs of psychological distress.",
    highlights: [
      "Developed Analyzer, a cross-platform desktop app that runs the research pipeline and charts linguistic patterns for researchers.",
      "Rewrote the Windows-only word-segmentation engine as a command-line tool that runs on Windows, Linux and macOS.",
      "Added result caching, which made the whole app much faster and cut the time for repeat analyses by about 80%.",
    ],
    stack: ["Python", "NLP", "Deep Learning", "Electron", "React"],
  },
  {
    role: "Lead Software Developer",
    organization: "PT Sumber Windu Makmur Semesta",
    location: "Medan, Indonesia · Hybrid",
    period: "Jan 2022 – Sep 2025",
    summary:
      "Started and led development of SD Desktop, the company’s day-to-day sales and invoicing system.",
    highlights: [
      "Raised invoice processing efficiency by 30% and reduced operational errors after launch.",
      "Reworked the system’s process flow so everyday tasks take fewer steps.",
    ],
    stack: ["Electron", "React", "TypeScript"],
  },
  {
    role: "Web Developer",
    organization:
      "Nusantara Youth Foundation · Beasiswa Indonesia Maju (MoECRT Indonesia)",
    location: "Indonesia · Hybrid",
    period: "Oct 2023 – Nov 2023",
    summary:
      "Built the website for Nusantara Youth Foundation, a youth development organization under Beasiswa Indonesia Maju, a program of Indonesia’s Ministry of Education, Culture, Research, and Technology.",
    highlights: [
      "Gave the foundation one place to manage its curriculum, organization profile and learning materials.",
      "Led a small team that shipped the full-stack MERN application on a tight deadline.",
    ],
    stack: ["MongoDB", "Express.js", "React", "Node.js"],
  },
];

export const education: EducationItem[] = [
  {
    school: "National Taiwan University of Science and Technology",
    degree: "B.S. Computer Science and Information Engineering",
    period: "Aug 2024 – Jun 2028",
    note: "CGPA 4.21 / 4.30",
    highlights: [
      "Ranked 2nd in the department (top 2.38%)",
      "Presidential Award for both semesters of 2024/25 and the second semester of 2025/26",
      "NTU System President’s Award for International Degree Students (Jan 2026)",
      "Research in Prof. Shih-Fan Chou’s lab on robotics and autonomous mobile robots (AMR), currently focused on simulating robots in Gazebo with ROS 2",
    ],
  },
];

export const awards: AwardItem[] = [
  {
    title: "Presidential Award, AY25/26 Semester 2",
    issuer: "NTUST",
    date: "Sep 2026",
  },
  {
    title: "NTU System President’s Award for International Degree Students",
    issuer: "NTU System",
    date: "Jan 2026",
  },
  {
    title: "Presidential Award, AY24/25 Semester 2",
    issuer: "NTUST",
    date: "Oct 2025",
  },
  {
    title: "Presidential Award, AY24/25 Semester 1",
    issuer: "NTUST",
    date: "Mar 2025",
  },
];

export const leadership: LeadershipItem[] = [
  {
    organization: "Overseas Chinese Students Association, NTUST",
    period: "Sep 2024 – Present",
    roles: [
      { title: "Secretary", period: "Sep 2026 – Present" },
      { title: "President", period: "Sep 2025 – Aug 2026" },
      { title: "Secretary", period: "Sep 2024 – Aug 2025" },
    ],
  },
  {
    organization: "Indonesian Economic and Trade Office to Taipei",
    period: "Jun 2026 – Sep 2026",
    roles: [
      {
        title: "Interpreter, Wonderful Indonesia Sales Mission 2026 to Taiwan",
        period: "Sep 2026",
      },
      {
        title: "Staff and Interpreter, Food Taipei Mega Shows 2026",
        period: "Jun 2026",
      },
    ],
  },
  {
    role: "School of Management",
    organization: "NTUST",
    period: "Mar 2026 – Present",
    roles: [
      { title: "Network Administrator", period: "Sep 2026 – Present" },
      { title: "Coordinator, Post-EMBA Program", period: "Apr 2026 – Present" },
      {
        title:
          "Vice-Coordinator, Taipower 2026 Senior Talent Management Course",
        period: "Apr 2026 – Present",
      },
      {
        title: "Coordinator, NTUST x NUCB Exchange Program",
        period: "May 2026 – Sep 2026",
      },
      {
        title:
          "Financial Director, International Conference on Production Research – Asia Pacific Region",
        period: "Mar 2026 – Jun 2026",
      },
    ],
  },
  {
    role: "Teaching Assistant",
    organization: "NTUST",
    period: "Sep 2024 – Present",
    roles: [
      {
        title: "Software Patent (MG6910701)",
        period: "Sep 2026 – Present",
      },
      {
        title: "Business Chinese II (FE1063701)",
        period: "Feb 2025 – Jun 2025",
      },
      {
        title:
          "EU, Globalization – SDGs Across Domains and Localities (TCG130301)",
        period: "Feb 2025 – Jun 2025",
      },
      {
        title: "Mandarin Chinese Practical (Level 5) (FE1045701)",
        period: "Sep 2024 – Jan 2025",
      },
    ],
  },
];
