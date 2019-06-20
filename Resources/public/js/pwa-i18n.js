import {langConstants as langDE} from "./pwa-i18n-de";
import {langConstants as langEN} from "./pwa-i18n-en";

export function getLanguage(lang) {
  if (lang === 'de') {
    return langDE;
  } else if (lang === 'en') {
    return langEN;
  } else {
    // fallback
    return langEN;
  }
}