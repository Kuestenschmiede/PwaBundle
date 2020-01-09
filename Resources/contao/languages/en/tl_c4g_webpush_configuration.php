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

use con4gis\PwaBundle\Entity\WebPushConfiguration;

$strName = 'tl_c4g_webpush_configuration';

$GLOBALS['TL_LANG'][$strName]['vapidSubject'] = ['Contact', 'You can provide either an URL or a mailto: link. This will be written into the notification.'];
$GLOBALS['TL_LANG'][$strName]['vapidPublickey'] = ['Public key', 'Public key for encryption. Generate <a href=https://tools.reactpwa.com/vapid>here</a> or leave empty to generate a keypair on saving.'];
$GLOBALS['TL_LANG'][$strName]['vapidPrivatekey'] = ['Private key', 'Private key for encryption. Generate <a href=https://tools.reactpwa.com/vapid>here</a> or leave empty to generate a keypair on saving.'];
$GLOBALS['TL_LANG'][$strName]['ttl'] = ['Time to live', 'Duration (in seconds) how long the notification will be held by the push service, when it is not possible to deliver it to the user (because e.g. missing connectivity).'];
$GLOBALS['TL_LANG'][$strName]['urgency'] = ['Urgency', 'Urgency of push notifications. When implemented by the browser vendor, it can save battery life of the device.'];
$GLOBALS['TL_LANG'][$strName]['topic'] = ['Topic', 'Topic of the notifications. When two notifications have the same topic, only the latest will be displayed (if the user has not read it already).'];
$GLOBALS['TL_LANG'][$strName]['timeout'] = ['Timeout', 'Timeout (in seconds) for each request.'];
$GLOBALS['TL_LANG'][$strName]['icon'] = ['Notification icon', 'Specify an icon that will be displayed in the notification banner.'];

$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_VERY_LOW] = 'Very low';
$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_LOW] = 'Low';
$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_NORMAL] = 'Normal';
$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_HIGH] = 'High';

// legends
$GLOBALS['TL_LANG'][$strName]['data_legend'] = 'Configuration for web push';
// infotext
$GLOBALS['TL_LANG'][$strName]['infotext'] = "Please note that the cache has to be cleared (for example via the Contao-Manager) after changes to this configuration, so Symfony can read the new configuration.";
