/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2021, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */

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