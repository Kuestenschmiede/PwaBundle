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

use con4gis\PwaBundle\Entity\WebPushConfiguration;

$strName = 'tl_c4g_webpush_configuration';

$GLOBALS['TL_LANG'][$strName]['name'] = ['Bezeichnung der Konfiguration', 'Geben Sie eine Bezeichnung, damit Sie die Konfiguration am Abonnement-Typ auswählen können.'];
$GLOBALS['TL_LANG'][$strName]['vapidSubject'] = ['Kontaktmöglichkeit', 'Geben Sie entweder eine URL zu Ihrer Website oder einen mailto:-Link an. Dies wird dann mit in die Pushnachricht geschrieben.'];
$GLOBALS['TL_LANG'][$strName]['vapidPublickey'] = ['Öffentlicher Schlüssel', 'Öffentlicher Schlüssel für die Verschlüsselung. Kann <a href=https://tools.reactpwa.com/vapid>hier</a> generiert werden. Falls Sie keinen Schlüssel angeben, wird ein Schlüsselpaar erzeugt.'];
$GLOBALS['TL_LANG'][$strName]['vapidPrivatekey'] = ['Privater Schlüssel', 'Privater Schlüssel für die Verschlüsselung. Kann <a href=https://tools.reactpwa.com/vapid>hier</a> generiert werden. Falls Sie keinen Schlüssel angeben, wird ein Schlüsselpaar erzeugt.'];
$GLOBALS['TL_LANG'][$strName]['ttl'] = ['Time to live', 'Dauer (in Sekunden) für die die Pushnachricht vom Push-Dienst vorgehalten wird, wenn sie dem Nutzer nicht zugestellt werden kann (z.B. wegen fehlender Internetverbindung).'];
$GLOBALS['TL_LANG'][$strName]['urgency'] = ['Dringlichkeit', 'Dringlichkeit der Push-Nachrichten. Wenn der Browser-Hersteller die Funktionalität unterstützt, kann diese Einstellung u.U. Nachrichten später zustellen und die Gerätelaufzeit schonen.'];
$GLOBALS['TL_LANG'][$strName]['topic'] = ['Betreff', 'Betreff der Push-Nachrichten. Wenn zwei Pushnachrichten den gleichen Betreff haben, wird nur die aktuellste auf dem Gerät angezeigt (wenn der Nutzer die erste nicht bereits gelesen hat).'];
$GLOBALS['TL_LANG'][$strName]['batchSize'] = ['Paketgröße', 'Um Speicherkonflikte zu vermeiden werden die Nachrichten standardmäßig in tausender Paketen verschickt. Dieser Wert kann hier verändert werden.'];
$GLOBALS['TL_LANG'][$strName]['timeout'] = ['Timeout', 'Timeout (in Sekunden) für jeden Request.'];
$GLOBALS['TL_LANG'][$strName]['icon'] = ['Benachrichtigungs-Icon', 'Hier können Sie ein Icon hinterlegen, was im Benachrichtigungsbanner angezeigt wird.'];

$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_VERY_LOW] = 'Sehr niedrig';
$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_LOW] = 'Niedrig';
$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_NORMAL] = 'Normal';
$GLOBALS['TL_LANG'][$strName][WebPushConfiguration::URGENCY_HIGH] = 'Hoch';

// legends
$GLOBALS['TL_LANG'][$strName]['data_legend'] = 'Konfiguration für Web-Push';
// infotext
$GLOBALS['TL_LANG'][$strName]['infotext'] = 'Hier konfigurieren Sie die Pushnachrichten. Lediglich bei einer Multidomain-Anwendung sollten Sie mehrere Konfigurationen anlegen. '.
    'Die Konfiguration muss am Abonnement-Typ verknüpft sein und am Frontend-Modul. Verschiedene Konfiguration können nicht innerhalb eines "Startpunkt der Website" verwendet werden. '.
    'Mehr auf <a href="https://docs.con4gis.org/webpush-nachrichten" title="con4gis Docs PWA Webpush Konfiguration" target="_blank" rel="noopener"><b>docs.con4gis.org</b></a>';