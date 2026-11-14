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
    organization: "NTUST × IGS (鈊象電子)",
    location: "Taipei, Taiwan · Hybrid",
    period: "Sep 2026 – Present",
    summary:
      "Working on a joint project between NTUST and IGS (International Games System) that puts academic research to work on real industry problems.",
    highlights: [],
    stack: [],
  },
  {
    role: "Network Administrator",
    organization: "School of Management, NTUST",
    location: "Taipei, Taiwan · Hybrid",
    period: "Sep 2026 – Present",
    summary:
      "Look after the School of Management’s official websites, including the EMBA, MBA and Graduate Institute of Management sites.",
    highlights: [
      "Manage site content through the university’s content management system.",
      "Rework page structure and navigation, and publish documents and links as the school needs them.",
    ],
    stack: ["Network Administration", "Server Administration", "CMS"],
  },
  {
    role: "Researcher, LIWC-Style Psycholinguistic NLP Model",
    organization: "NTUST · NSTC-supported research project",
    location: "Taipei, Taiwan · Hybrid",
    period: "Oct 2025 – Jun 2026",
    summary:
      "Worked on a system that combines NLP and emotion recognition to analyze writing for signs of psychological distress.",
    highlights: [
      "Built annotated linguistic datasets and trained emotion-aware classifiers to assess mental health risk.",
      "Developed Analyzer, a cross-platform desktop app that runs the research pipeline and charts linguistic patterns for researchers and clinicians.",
      "Rewrote the Windows-only word-segmentation engine as a command-line tool that runs on Windows, Linux and macOS.",
      "Added result caching, which cut the time for repeat analyses by about 70%.",
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
      "Moved VAT calculations to the new 12% rate required by Indonesian regulations.",
      "Reworked the system’s process flow so everyday tasks take fewer steps.",
    ],
    stack: ["Electron", "React", "TypeScript", "Team Leadership"],
  },
  {
    role: "Web Developer",
    organization: "Nusantara Youth Foundation · Beasiswa Indonesia Maju (MoECRT Indonesia)",
    location: "Indonesia · Hybrid",
    period: "Oct 2023 – Nov 2023",
    summary:
      "Built the website for Nusantara Youth Foundation, a youth development organization under Beasiswa Indonesia Maju, a program of Indonesia’s Ministry of Education, Culture, Research, and Technology.",
    highlights: [
      "Gave the foundation one place to manage its curriculum, organization profile and learning materials.",
      "Led a small team that shipped the full-stack MERN application on a tight deadline.",
      "Built it to stay fast as content and traffic grow.",
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
      "Ranked 2nd in the department (top 2.38%), with a perfect 4.30 GPA in Spring 2026",
      "Dean’s List for both semesters of 2024/25 and the second semester of 2025/26",
      "Overseas Chinese Students Association: Secretary (2024–25), President (2025–26), Advisor and Secretary (2026–27)",
    ],
  },
  {
    school: "SMA Sutomo 1",
    degree: "Natural Sciences",
    period: "Aug 2020 – Apr 2024",
    note: "Grade 96.16 / 100",
    highlights: [
      "Chairman I of the Student Council (2022–23), then Advisor (2023–24); led the Sutomo World Education Expo, which drew over 1,000 attendees",
      "President of the Southeast Asian Service Leadership Network (SEALNet), 2023–24",
    ],
  },
];

export const awards: AwardItem[] = [
  {
    title: "PERPITA Scholarship",
    issuer: "CPC Corporation, Taiwan & Sino-Indonesia Cultural and Economic Association",
    date: "Oct 2026",
  },
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
    title: "NTU System President’s Award for International Degree Students",
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
    title: "Zhang Fei-Wu Renewable Full-Tuition Scholarship",
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
    role: "Advisor and Secretary",
    organization: "Overseas Chinese Students Association, NTUST",
    period: "Sep 2026 – Present",
    summary:
      "Back as Secretary for a second term after a year as President, and advising the new leadership team.",
  },
  {
    role: "On-site Interpreter, Wonderful Indonesia Sales Mission 2026 to Taiwan",
    organization: "Indonesian Economic and Trade Office to Taipei (IETO Taipei)",
    period: "Sep 2026",
    summary:
      "Interpreted during business-matching meetings between Indonesian tourism operators and Taiwanese travel agencies.",
  },
  {
    role: "Staff and Interpreter, Food Taipei Mega Shows 2026",
    organization: "Indonesian Economic and Trade Office to Taipei (IETO Taipei)",
    period: "Jun 2026",
    summary:
      "Helped Indonesian small businesses present their products to international buyers, interpreting between Chinese, English and Indonesian.",
  },
  {
    role: "Coordinator, NTUST–NUCB EMBA Exchange Program",
    organization: "NTUST",
    period: "May 2026 – Sep 2026",
    summary:
      "Coordinated the exchange between NTUST and Nagoya University of Commerce & Business (NUCB), including a five-day program in Taiwan (Aug 3–7, 2026) with company visits to ASUS and Trend Micro and trips to well-known places around the island.",
  },
  {
    role: "Teaching Assistant",
    organization: "NTUST School of Management",
    period: "Apr 2026 – Present",
    summary:
      "Teaching assistant for the Post-EMBA Program, the Software Patent course (MG6910701), and Taipower’s 2026 senior talent management course.",
  },
  {
    role: "Financial Director and Committee Member",
    organization: "2026 International Conference on Production Research – Asia Pacific Region (ICPR-APR)",
    period: "Mar 2026 – Jun 2026",
    summary:
      "Tracked every expense for the conference in Taipei, then worked on site during the event, helping participants who came from many countries.",
  },
  {
    role: "Dormitory Floor Leader",
    organization: "First Student Dormitory, NTUST",
    period: "Jan 2026 – Present",
    summary:
      "Look after residents on the floor and sit on the First Student Dormitory Committee.",
  },
  {
    role: "President",
    organization: "Overseas Chinese Students Association, NTUST",
    period: "Sep 2025 – Sep 2026",
    summary:
      "Led the association and worked with the university on cultural and academic events, including the Spring Festival Gala 2026, a graduation gala for over 100 students from more than 10 countries.",
  },
  {
    role: "Secretary",
    organization: "Overseas Chinese Students Association, NTUST",
    period: "Sep 2024 – Aug 2025",
    summary:
      "Handled the association’s paperwork, led the Spring Festival Gala 2025, and was chief coordinator for the Christmas, Mid-Autumn and Freshman Welcome events.",
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
      "Ran weekly leadership sessions and community service work, including visits to orphanages and nursing homes.",
  },
  {
    role: "Chairman I, Student Council",
    organization: "SMA Sutomo 1",
    period: "Oct 2022 – Sep 2023",
    summary:
      "Organized school competitions and leadership training, and led the Sutomo World Education Expo (1,000+ attendees). Stayed on as an advisor to the council the following year.",
  },
];
