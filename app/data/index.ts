import type { Locale } from "../i18n/config";
import * as en from "./profile";
import * as zh from "./profile.zh";

export interface Profile {
  openSource: en.OpenSourceItem[];
  experience: en.ExperienceItem[];
  education: en.EducationItem[];
  awards: en.AwardItem[];
  leadership: en.LeadershipItem[];
}

const profiles: Record<Locale, Profile> = { en, zh };

export const getProfile = (locale: Locale) => profiles[locale];
