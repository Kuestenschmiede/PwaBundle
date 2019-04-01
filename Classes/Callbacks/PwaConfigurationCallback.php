<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 21.03.19
 * Time: 13:04
 */

namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Entity\PwaConfiguration;
use Contao\Backend;
use Contao\StringUtil;

class PwaConfigurationCallback extends Backend
{
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
    
    public function getServiceWorkerOptions()
    {
        return [
            PwaConfiguration::PWA_SERVICE_WORKER_GENERATE => 'Automatisch erzeugen',
            PwaConfiguration::PWA_SERVICE_WORKER_CUSTOM => 'Aus eigener Datei laden (noch nicht implementiert)'
        ];
    }
    
    public function convertBinToUuid($varValue)
    {
        $uuid = StringUtil::binToUuid($varValue);
        return $uuid;
    }
}