import type { Locale } from "./config";
import en, { type Dictionary } from "./dictionaries/en";
import zh from "./dictionaries/zh";

const dictionaries: Record<Locale, Dictionary> = { en, zh };

export const getDictionary = (locale: Locale) => dictionaries[locale];
export type { Dictionary };
