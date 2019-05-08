<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    6
 * @author  	con4gis contributors (see "authors.txt")
 * @license 	LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

use con4gis\PwaBundle\Entity\WebPushConfiguration;

$strName = 'tl_c4g_webpush_configuration';

$GLOBALS['TL_LANG'][$strName]['vapidSubject'] = ['Betreff', 'Betreff der Push-Nachrichten.'];
$GLOBALS['TL_LANG'][$strName]['vapidPublickey'] = ['Öffentlicher Schlüssel', 'Öffentlicher Schlüssel für die Verschlüsselung. Kann <a href=https://tools.reactpwa.com/vapid>hier</a> generiert werden. Falls Sie keinen Schlüssel angeben, wird ein Schlüsselpaar erzeugt.'];
$GLOBALS['TL_LANG'][$strName]['vapidPrivatekey'] = ['Privater Schlüssel', 'Privater Schlüssel für die Verschlüsselung. Kann <a href=https://tools.reactpwa.com/vapid>hier</a> generiert werden. Falls Sie keinen Schlüssel angeben, wird ein Schlüsselpaar erzeugt.'];
$GLOBALS['TL_LANG'][$strName]['ttl'] = ['Time to live', 'Lebensdauer der Push-Nachrichten.'];
$GLOBALS['TL_LANG'][$strName]['urgency'] = ['Dringlichkeit', 'Dringlichkeit der Push-Nachrichten.'];
$GLOBALS['TL_LANG'][$strName]['topic'] = ['Betreff', 'Betreff der Push-Nachrichten.'];
$GLOBALS['TL_LANG'][$strName]['timeout'] = ['Timeout', 'Timeout für jeden Request.'];
$GLOBALS['TL_LANG'][$strName]['icon'] = ['Benachrichtigungs-Icon', 'Hier können Sie ein Icon hinterlegen, was im Benachrichtigungsbanner angezeigt wird.'];

$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_VERY_LOW] = 'Sehr niedrig';
$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_LOW] = 'Niedrig';
$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_NORMAL] = 'Normal';
$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_HIGH] = 'Hoch';

// legends
$GLOBALS['TL_LANG'][$strName]['data_legend'] = 'Konfiguration für Web-Push';
// infotext
$GLOBALS['TL_LANG'][$strName]['infotext'] = "Bitte beachten Sie, dass nach dem Ändern der WebPush-Konfiguration der Cache geleert werden muss, damit Symfony die neue Konfiguration einlesen kann.";
