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

$strName = 'tl_c4g_push_subscription_type';

$GLOBALS['TL_LANG'][$strName]['name'] = ['Name des Abonnement-Typs', 'Geben Sie einen Namen für den Abonnement-Typ ein.'];
$GLOBALS['TL_LANG'][$strName]['pushConfig'] = ['Push-Konfiguration', 'Wählen Sie die zu verwendende Push-Konfiguration aus. Diese können im gleichnamigen Backend-Modul angelegt werden.'];
$GLOBALS['TL_LANG'][$strName]['postals'] = ['PLZ-Einschränkung', 'Hier können Sie eine kommagetrennte Liste von Postleitzahlen angeben. Nachrichten für diesen Abonnement-Typ werden dann nur an abonnierte Mitglieder versendet, die in einem dieser Postleitzahlengebiete sind.'];

$GLOBALS['TL_LANG'][$strName]['data_legend'] = 'Allgemeine Daten';

$GLOBALS['TL_LANG'][$strName]['editPushConfigurations'] = ['Push-Konfiguration bearbeiten.'];

$GLOBALS['TL_LANG']['tl_c4g_push_subscription_type']['infotext'] = 'Die Abonnement Typen können an verschiedenen Stellen im Contao Backend verknüpft werden. Bspw. bei den Termineinstellungen oder im Nachrichtenarchiv. '.
    'Damit die Typen abonniert werden können, müssen diese im Frontend Modul "Pushnachrichten abonnieren" verknüpft sein. '.
    'Mehr auf <a href="https://docs.con4gis.org/push-abonnement-typen" title="con4gis Docs PWA Push Abonnement Typen" target="_blank" rel="noopener"><b>docs.con4gis.org</b></a>';


// operations
$singular = 'Push-Abonnement-Typen';
$GLOBALS['TL_LANG'][$strName]['new'] = array("$singular hinzufügen","$singular hinzufügen");
$GLOBALS['TL_LANG'][$strName]['edit'] = array("$singular bearbeiten","Bearbeiten der $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['copy'] = array("$singular kopieren","Kopieren der $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['delete'] = array("$singular löschen","Löschen der $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['show'] = array("$singular anzeigen","Anzeigen der $singular ID %s");