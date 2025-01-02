<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 10
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2025, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
namespace con4gis\PwaBundle\Classes\Callbacks;

use con4gis\PwaBundle\Entity\PwaConfiguration;
use Contao\Backend;
use Contao\StringUtil;

class PwaConfigurationCallback extends Backend
{
    public function showHint()
    {
        \Contao\Message::addInfo($GLOBALS['TL_LANG']['tl_c4g_pwa_configuration']['infotext']);
    }

    public function getUpdateViaCacheOptions()
    {
        $strName = 'tl_c4g_pwa_configuration';
        $optionsLang = $GLOBALS['TL_LANG'][$strName]['updateViaCacheOptions'];

        return [
            PwaConfiguration::PWA_UPDATEVIACACHE_IMPORTS => $optionsLang[PwaConfiguration::PWA_UPDATEVIACACHE_IMPORTS],
            PwaConfiguration::PWA_UPDATEVIACACHE_ALL => $optionsLang[PwaConfiguration::PWA_UPDATEVIACACHE_ALL],
            PwaConfiguration::PWA_UPDATEVIACACHE_NONE => $optionsLang[PwaConfiguration::PWA_UPDATEVIACACHE_NONE],
        ];
    }

    public function getDisplayOptions()
    {
        $strName = 'tl_c4g_pwa_configuration';
        $optionsLang = $GLOBALS['TL_LANG'][$strName]['displayOptions'];

        return [
            PwaConfiguration::PWA_DISPLAY_FULLSCREEN => $optionsLang[PwaConfiguration::PWA_DISPLAY_FULLSCREEN],
            PwaConfiguration::PWA_DISPLAY_STANDALONE => $optionsLang[PwaConfiguration::PWA_DISPLAY_STANDALONE],
            PwaConfiguration::PWA_DISPLAY_MINIMAL_UI => $optionsLang[PwaConfiguration::PWA_DISPLAY_MINIMAL_UI],
            PwaConfiguration::PWA_DISPLAY_BROWSER => $optionsLang[PwaConfiguration::PWA_DISPLAY_BROWSER],
        ];
    }

    public function getOrientationOptions()
    {
        $strName = 'tl_c4g_pwa_configuration';
        $optionsLang = $GLOBALS['TL_LANG'][$strName]['orientationOptions'];

        return [
            PwaConfiguration::PWA_ORIENTATION_ANY => $optionsLang[PwaConfiguration::PWA_ORIENTATION_ANY],
            PwaConfiguration::PWA_ORIENTATION_NATURAL => $optionsLang[PwaConfiguration::PWA_ORIENTATION_NATURAL],
            PwaConfiguration::PWA_ORIENTATION_LANDSCAPE => $optionsLang[PwaConfiguration::PWA_ORIENTATION_LANDSCAPE],
            PwaConfiguration::PWA_ORIENTATION_LANDSCAPE_PRIMARY => $optionsLang[PwaConfiguration::PWA_ORIENTATION_LANDSCAPE_PRIMARY],
            PwaConfiguration::PWA_ORIENTATION_LANDSCAPE_SECONDARY => $optionsLang[PwaConfiguration::PWA_ORIENTATION_LANDSCAPE_SECONDARY],
            PwaConfiguration::PWA_ORIENTATION_PORTRAIT => $optionsLang[PwaConfiguration::PWA_ORIENTATION_PORTRAIT],
            PwaConfiguration::PWA_ORIENTATION_PORTRAIT_PRIMARY => $optionsLang[PwaConfiguration::PWA_ORIENTATION_PORTRAIT_PRIMARY],
            PwaConfiguration::PWA_ORIENTATION_PORTRAIT_SECONDARY => $optionsLang[PwaConfiguration::PWA_ORIENTATION_PORTRAIT_SECONDARY],
        ];
    }

    public function getOfflineHandlingOptions()
    {
        $strName = 'tl_c4g_pwa_configuration';
        $optionsLang = $GLOBALS['TL_LANG'][$strName]['offlineHandling']['options'];

        return [
            PwaConfiguration::PWA_OFFLINE_HANDLING_ALWAYS => $optionsLang[PwaConfiguration::PWA_OFFLINE_HANDLING_ALWAYS],
            PwaConfiguration::PWA_OFFLINE_HANDLING_FALLBACK => $optionsLang[PwaConfiguration::PWA_OFFLINE_HANDLING_FALLBACK],
        ];
    }

    public function getIosStyleOptions()
    {
        $strName = 'tl_c4g_pwa_configuration';
        $optionsLang = $GLOBALS['TL_LANG'][$strName]['iosStyle'];

        return [
            PwaConfiguration::PWA_IOS_STYLE_BLACK => $optionsLang[PwaConfiguration::PWA_IOS_STYLE_BLACK],
            PwaConfiguration::PWA_IOS_STYLE_DEFAULT => $optionsLang[PwaConfiguration::PWA_IOS_STYLE_DEFAULT],
        ];
    }

    public function convertBinToUuid($varValue)
    {
        if ($varValue) {
            $varValue = StringUtil::binToUuid($varValue);
        }
        
        return $varValue;
    }

    public static function getAllowedImageExtensions()
    {
        return 'png,jpeg,gif,jpg';
    }
}
