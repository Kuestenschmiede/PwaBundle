<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    7
 * @author  	con4gis contributors (see "authors.txt")
 * @license 	LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

namespace con4gis\PwaBundle\Classes\Callbacks;

use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\Backend;

class WebpushConfigurationCallback extends Backend
{
    public function getUrgencyOptions()
    {
        $strName = 'tl_c4g_webpush_configuration';

        return [
            WebPushConfiguration::URGENCY_VERY_LOW => $GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_VERY_LOW],
            WebPushConfiguration::URGENCY_LOW => $GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_LOW],
            WebPushConfiguration::URGENCY_NORMAL => $GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_NORMAL],
            WebPushConfiguration::URGENCY_HIGH => $GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_HIGH],
        ];
    }
}
