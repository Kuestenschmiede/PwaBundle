<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2021, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
namespace con4gis\PwaBundle\Classes\Callbacks;

use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\Backend;
use Contao\DataContainer;
use Contao\Message;
use Minishlink\WebPush\VAPID;

class WebpushConfigurationCallback extends Backend
{
    public function showInfoMessage(DataContainer $dc)
    {
        Message::addInfo($GLOBALS['TL_LANG']['tl_c4g_webpush_configuration']['infotext']);
    }

    public function writeDataToConfig(DataContainer $dc)
    {
        if ($dc && !($dc->activeRecord->vapidPublickey && $dc->activeRecord->vapidPrivatekey)) {
            // both keys are required, so create a new pair
            $keys = VAPID::createVapidKeys();
            $publicKey = $keys['publicKey'];
            $privateKey = $keys['privateKey'];
            $this->Database->prepare('UPDATE tl_c4g_webpush_configuration SET vapidPublickey=?, vapidPrivatekey=? WHERE id=? ')
                ->execute($publicKey, $privateKey, $dc->activeRecord->id);
        }
    }

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
