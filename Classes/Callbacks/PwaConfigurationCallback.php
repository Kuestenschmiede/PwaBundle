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
    
    public function convertBinToUuid($varValue)
    {
        return StringUtil::binToUuid($varValue);
    }
}