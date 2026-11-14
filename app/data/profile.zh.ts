import type {
  AwardItem,
  EducationItem,
  ExperienceItem,
  LeadershipItem,
  OpenSourceItem,
} from "./profile";

// Traditional Chinese (Taiwan) version of profile.ts. Keep the entries in the
// same order as the English file so the two stay easy to compare.

export const openSource: OpenSourceItem[] = [
  {
    name: "TigerDuck",
    role: "貢獻者",
    period: "2026 年 3 月 – 至今",
    summary:
      "由臺科大學生為臺科大學生打造的校園 App，把原本分散在各個學校網站的資源整合在一起。它會同步 Moodle 作業與課表並推播提醒，後端用 LLM 分類學校公告並去除重複，也能查看成績與圖書館借閱紀錄。App 已上架 App Store、Google Play 和 F-Droid，支援超過 67 種語言。",
    stack: ["Swift", "Kotlin", "Python", "FastAPI", "TypeScript", "React"],
    links: [
      { label: "GitHub", href: "https://github.com/tigerduck-app" },
      { label: "網站", href: "https://tigerduck.app" },
    ],
  },
];

export const experience: ExperienceItem[] = [
  {
    role: "產學合作參與者",
    organization: "臺科大 · 鈊象電子股份有限公司",
    location: "臺灣臺北 · 混合辦公",
    period: "2026 年 9 月 – 至今",
    summary: "",
    highlights: [],
    stack: [],
  },
  {
    role: "產學合作參與者:LIWC 式心理語言學 NLP 模型",
    organization: "臺科大 · 國家科學及技術委員會",
    location: "臺灣臺北 · 混合辦公",
    period: "2025 年 10 月 – 2026 年 6 月",
    summary:
      "參與一套結合 NLP 與情緒辨識的系統，分析文字中可能透露的心理困擾徵兆。",
    highlights: [
      "開發 Analyzer，一款跨平台桌面應用程式，用來執行研究流程，並把語言模式畫成圖表給研究人員查看。",
      "把只能在 Windows 上執行的斷詞引擎改寫成命令列工具，可在 Windows、Linux 和 macOS 上執行。",
      "加入結果快取，讓整個應用程式快上許多，重複分析所需的時間減少約 80%。",
    ],
    stack: ["Python", "NLP", "Deep Learning", "Electron", "React"],
  },
  {
    role: "首席軟體開發工程師",
    organization: "PT Sumber Windu Makmur Semesta",
    location: "印尼棉蘭 · 混合辦公",
    period: "2022 年 1 月 – 2025 年 9 月",
    summary: "發起並主導開發 SD Desktop，也就是公司日常使用的銷售與發票系統。",
    highlights: [
      "系統上線後，發票處理效率提升 30%，作業錯誤也隨之減少。",
      "重新設計系統的作業流程，讓日常工作所需的步驟更少。",
    ],
    stack: ["Electron", "React", "TypeScript"],
  },
  {
    role: "網頁開發工程師",
    organization:
      "Nusantara Youth Foundation · Beasiswa Indonesia Maju（印尼教育文化研究科技部）",
    location: "印尼 · 混合辦公",
    period: "2023 年 10 月 – 2023 年 11 月",
    summary:
      "為 Nusantara Youth Foundation 建置網站。這是 Beasiswa Indonesia Maju 旗下的青年培育組織，而 Beasiswa Indonesia Maju 是印尼教育、文化、研究與科技部的計畫。",
    highlights: [
      "讓基金會能在同一個地方管理課程、組織簡介與學習教材。",
      "帶領小型團隊，在緊迫的時程內完成全端 MERN 應用程式。",
    ],
    stack: ["MongoDB", "Express.js", "React", "Node.js"],
  },
];

export const education: EducationItem[] = [
  {
    school: "國立臺灣科技大學",
    degree: "資訊工程系 學士",
    period: "2024 年 8 月 – 2028 年 6 月",
    note: "GPA 4.21 / 4.30",
    highlights: [
      "系排名第 2（前 2.38%）",
      "113 學年度上、下學期及 114 學年度第 2 學期書卷獎",
      "臺灣大學系統境外學位生校長獎（2026 年 1 月）",
      "於周詩梵教授實驗室研究機器人與自主移動機器人（AMR），目前專注於以 ROS 2 在 Gazebo 中模擬機器人",
    ],
  },
];

export const awards: AwardItem[] = [
  {
    title: "書卷獎（114 學年度第 2 學期）",
    issuer: "臺科大",
    date: "2026 年 9 月",
  },
  {
    title: "臺灣大學系統境外學位生校長獎",
    issuer: "臺灣大學系統",
    date: "2026 年 1 月",
  },
  {
    title: "書卷獎（113 學年度第 2 學期）",
    issuer: "臺科大",
    date: "2025 年 10 月",
  },
  {
    title: "書卷獎（113 學年度第 1 學期）",
    issuer: "臺科大",
    date: "2025 年 3 月",
  },
];

export const leadership: LeadershipItem[] = [
  {
    organization: "臺科大僑生聯誼會",
    period: "2024 年 9 月 – 至今",
    roles: [
      { title: "秘書", period: "2026 年 9 月 – 至今" },
      { title: "會長", period: "2025 年 9 月 – 2026 年 8 月" },
      { title: "秘書", period: "2024 年 9 月 – 2025 年 8 月" },
    ],
  },
  {
    organization: "駐台北印尼經濟貿易代表處",
    period: "2026 年 6 月 – 2026 年 9 月",
    roles: [
      {
        title: "口譯員，2026 Wonderful Indonesia 訪台推廣團",
        period: "2026 年 9 月",
      },
      {
        title: "工作人員暨口譯員，2026 台北國際食品展",
        period: "2026 年 6 月",
      },
    ],
  },
  {
    role: "管理學院",
    organization: "臺科大",
    period: "2026 年 3 月 – 至今",
    roles: [
      { title: "網路管理員", period: "2026 年 9 月 – 至今" },
      { title: "協調人，Post-EMBA 課程", period: "2026 年 4 月 – 至今" },
      {
        title: "副協調人，台電 2026 高階人才管理課程",
        period: "2026 年 4 月 – 至今",
      },
      {
        title: "協調人，臺科大 × 名古屋商科大學（NUCB）交換計畫",
        period: "2026 年 5 月 – 2026 年 9 月",
      },
      {
        title:
          "財務長，International Conference on Production Research – Asia Pacific Region",
        period: "2026 年 3 月 – 2026 年 6 月",
      },
    ],
  },
  {
    role: "教學助理",
    organization: "臺科大",
    period: "2024 年 9 月 – 至今",
    roles: [
      { title: "軟體專利（MG6910701）", period: "2026 年 9 月 – 至今" },
      {
        title: "商用華語（二）（FE1063701）",
        period: "2025 年 2 月 – 2025 年 6 月",
      },
      {
        title: "歐盟、全球化:跨領域與在地的永續發展目標（TCG130301）",
        period: "2025 年 2 月 – 2025 年 6 月",
      },
      {
        title: "實用華語（第 5 級）（FE1045701）",
        period: "2024 年 9 月 – 2025 年 1 月",
      },
    ],
  },
];
