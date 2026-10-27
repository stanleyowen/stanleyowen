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

export interface LeadershipItem {
  role: string;
  organization: string;
  period: string;
  summary: string;
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
      "Native campus assistant for NTUST students, developed by a student team to consolidate scattered resources into a single application. It synchronizes Moodle assignments and course timetables with push reminders, classifies and deduplicates announcements with a backend LLM, and provides grade and library access. Published on the App Store, Google Play and F-Droid, and localized into more than 67 languages.",
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
    organization: "NTUST × IGS (鈊象電子)",
    location: "Taipei, Taiwan · Hybrid",
    period: "Sep 2026 – Present",
    summary:
      "Contributing to a joint project between National Taiwan University of Science and Technology and IGS, bridging academic research and industry practice.",
    highlights: [],
    stack: [],
  },
  {
    role: "Network Administrator",
    organization: "School of Management, NTUST",
    location: "Taipei, Taiwan · Hybrid",
    period: "Sep 2026 – Present",
    summary:
      "Administer and maintain the official web platforms of the School of Management, covering the EMBA, MBA and Graduate Institute of Management websites.",
    highlights: [
      "Manage back-end content through the university’s content management system.",
      "Update site structure and navigation, and publish documents and links.",
    ],
    stack: ["Network Administration", "Server Administration", "CMS"],
  },
  {
    role: "Researcher, LIWC-Style Psycholinguistic NLP Model",
    organization: "NTUST · NSTC-supported research project",
    location: "Taipei, Taiwan · Hybrid",
    period: "Oct 2025 – Jun 2026",
    summary:
      "Researched an AI-assisted system that combines NLP and emotion recognition to analyze text related to mental health and psychological distress.",
    highlights: [
      "Built annotated linguistic datasets and emotion-aware classification models for mental health risk assessment.",
      "Developed a desktop application that runs the research pipeline and visualizes linguistic patterns for researchers and clinicians.",
    ],
    stack: ["Python", "NLP", "Deep Learning", "Electron", "React"],
  },
  {
    role: "Lead Software Developer",
    organization: "PT Sumber Windu Makmur Semesta",
    location: "Medan, Indonesia · Hybrid",
    period: "Jan 2022 – Sep 2025",
    summary:
      "Initiated and led development of “SD Desktop”, a sales and invoice management system used daily by the company.",
    highlights: [
      "Improved invoice processing efficiency by 30% and reduced the operational error rate following launch.",
      "Updated the system’s VAT rate to 12% in compliance with Indonesian government regulations.",
      "Redesigned the process architecture to streamline user workflows.",
    ],
    stack: ["Electron", "React", "TypeScript", "Team Leadership"],
  },
  {
    role: "Web Developer (Freelance)",
    organization: "Beasiswa Indonesia Maju – Taman Sains",
    location: "Indonesia · Hybrid",
    period: "Oct 2023 – Nov 2023",
    summary:
      "Led a small team in delivering a scholarship management platform under a tight timeline.",
    highlights: [
      "Delivered a full-stack MERN application within the project deadline.",
      "Designed the platform with scalability and performance in mind.",
    ],
    stack: ["MongoDB", "Express.js", "React", "Node.js"],
  },
];

export const education: EducationItem[] = [
  {
    school: "National Taiwan University of Science and Technology",
    degree: "B.S. Computer Science",
    period: "Aug 2024 – Jun 2028",
    note: "GPA 4.22",
    highlights: [
      "Dean’s List in Academic Year 2024/25 (both semesters) and Semester 2 of 2025/26",
      "Officer of the Overseas Chinese Students Association: Secretary (2024–25), President (2025–26), Secretary (2026–27)",
    ],
  },
  {
    school: "SMA Sutomo 1",
    degree: "Natural Sciences",
    period: "Aug 2020 – Apr 2024",
    note: "Grade 96.16 / 100",
    highlights: [
      "Student Council: Chairman I (2022–23), Advisor (2023–24)",
      "President of the Southeast Asian Service Leadership Network (SEALNet), 2023–24",
    ],
  },
];

export const awards: AwardItem[] = [
  {
    title: "Dean’s List, AY25/26 Semester 2",
    issuer: "NTUST",
    date: "Sep 2026",
  },
  {
    title: "Overseas Community Affairs Council Scholarship",
    issuer: "OCAC, Taiwan (R.O.C.)",
    date: "Jun 2026",
  },
  {
    title: "Indonesian Overseas Chinese Association Scholarship",
    issuer: "中華民國印尼歸僑協會",
    date: "Mar 2026",
  },
  {
    title: "National Taiwan University System President’s Award",
    issuer: "NTU System",
    date: "Jan 2026",
  },
  {
    title: "Bing-Hua Huang and Ping-Hsuan Chiang Couple Scholarship",
    issuer: "財團法人僑聯文教基金會",
    date: "Dec 2025",
  },
  {
    title: "Shen Chang-huan Memorial Scholarship",
    issuer: "Overseas Chinese Association HQ",
    date: "Nov 2025",
  },
  {
    title: "Zhang Fei-Wu Full Ride Scholarship",
    issuer: "Y.M. Chen Foundation",
    date: "Nov 2025",
  },
  {
    title: "Dean’s List, AY24/25 Semester 2",
    issuer: "NTUST",
    date: "Oct 2025",
  },
  {
    title: "Dean’s List, AY24/25 Semester 1",
    issuer: "NTUST",
    date: "Mar 2025",
  },
];

export const leadership: LeadershipItem[] = [
  {
    role: "Secretary",
    organization: "Overseas Chinese Students Association, NTUST",
    period: "Sep 2026 – Present",
    summary:
      "Serving a second term as Secretary, following a term as President of the association.",
  },
  {
    role: "Staff and Interpreter, Food Taipei Mega Shows 2026",
    organization: "Indonesian Economic and Trade Office to Taipei (KDEI Taipei)",
    period: "Jun 2026",
    summary:
      "Assisted Indonesian small and medium enterprises in presenting their products to international buyers, and interpreted between Chinese, English and Indonesian.",
  },
  {
    role: "Coordinator, NTUST–NUCB EMBA Exchange Program",
    organization: "NTUST",
    period: "May 2026 – Sep 2026",
    summary:
      "Coordinated the exchange program between NTUST and Nagoya University of Commerce & Business (NUCB).",
  },
  {
    role: "Teaching Assistant",
    organization: "NTUST School of Management",
    period: "Apr 2026 – Present",
    summary:
      "Teaching assistant for the Post-EMBA Program, the Software Patent course (MG6910701) and the Taipower 2026 senior talent management course.",
  },
  {
    role: "Financial Director and Committee Member",
    organization: "2026 International Conference on Production Research (ICPR)",
    period: "Mar 2026 – Jun 2026",
    summary:
      "Responsible for the financial management of the international conference held in Taipei.",
  },
  {
    role: "Dormitory Floor Leader",
    organization: "First Student Dormitory, NTUST",
    period: "Jan 2026 – Present",
    summary:
      "Serve as floor leader for residents and as a member of the First Student Dormitory Committee.",
  },
  {
    role: "President",
    organization: "Overseas Chinese Students Association, NTUST",
    period: "Sep 2025 – Sep 2026",
    summary:
      "Led the association and coordinated cultural and academic events with university administration, including the Spring Festival Gala 2026.",
  },
  {
    role: "Secretary",
    organization: "Overseas Chinese Students Association, NTUST",
    period: "Sep 2024 – Aug 2025",
    summary:
      "Managed administration and documentation, and served as chief coordinator of the Christmas, Mid-Autumn and Freshman Welcome events.",
  },
  {
    role: "Teaching Assistant",
    organization: "NTUST",
    period: "Sep 2024 – Jun 2025",
    summary:
      "Teaching assistant for Business Chinese II; EU, Globalization – SDGs Across Domains and Localities; and Mandarin Chinese Practical (Level 5).",
  },
  {
    role: "President, SEALNet",
    organization: "SMA Sutomo 1",
    period: "Oct 2023 – Mar 2024",
    summary:
      "Organized weekly leadership activities and social welfare initiatives, including visits to orphanages and nursing homes.",
  },
  {
    role: "Chairman I, Student Council",
    organization: "SMA Sutomo 1",
    period: "Oct 2022 – Sep 2023",
    summary:
      "Planned competitions, leadership training and an education expo; subsequently served as an advisor to the council.",
  },
];
