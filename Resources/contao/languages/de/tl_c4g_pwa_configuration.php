<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 21.03.19
 * Time: 12:56
 */

$strName = 'tl_c4g_pwa_configuration';

$GLOBALS['TL_LANG'][$strName]['name'] = ['Name', 'Name der PWA'];
$GLOBALS['TL_LANG'][$strName]['shortName']  = ['Kurzform', 'Kurzform des Namens der PWA'];
$GLOBALS['TL_LANG'][$strName]['description'] = ['Beschreibung', 'Beschreibung der PWA'];
$GLOBALS['TL_LANG'][$strName]['themeColor'] = ['Theme-Farbe', 'Geben Sie eine Farbe für das Theme der PWA an.'];
$GLOBALS['TL_LANG'][$strName]['backgroundColor'] = ['Hintergrund-Farbe', 'Geben sie eine Farbe für den Hintergrund der PWA an.'];
$GLOBALS['TL_LANG'][$strName]['display'] = ['Anzeigemodus', 'Wählen Sie den gewünschten Anzeigemodus für die PWA aus.'];
$GLOBALS['TL_LANG'][$strName]['icon192'] = ['Icon der Größe 192x192', 'Wählen Sie ein Icon für die PWA aus (Maße 192x192).'];
$GLOBALS['TL_LANG'][$strName]['icon512'] = ['Icon der Größe 512x512', 'Wählen Sie ein Icon für die PWA aus (Maße 512x512).'];

// Options
$GLOBALS['TL_LANG'][$strName]['displayOptions'][\con4gis\PwaBundle\Entity\PwaConfiguration::PWA_DISPLAY_FULLSCREEN] = "Vollbild";
$GLOBALS['TL_LANG'][$strName]['displayOptions'][\con4gis\PwaBundle\Entity\PwaConfiguration::PWA_DISPLAY_STANDALONE] = "Standalone";
$GLOBALS['TL_LANG'][$strName]['displayOptions'][\con4gis\PwaBundle\Entity\PwaConfiguration::PWA_DISPLAY_MINIMAL_UI] = "Minimale UI";
$GLOBALS['TL_LANG'][$strName]['displayOptions'][\con4gis\PwaBundle\Entity\PwaConfiguration::PWA_DISPLAY_BROWSER] = "Browseransicht";

// legends
$GLOBALS['TL_LANG'][$strName]['data_legend'] = 'Angaben für Manifest-Datei';

// operations
$singular = 'PWA-Konfiguration';
$GLOBALS['TL_LANG'][$strName]['new'] = array("$singular hinzufügen","$singular hinzufügen");
$GLOBALS['TL_LANG'][$strName]['edit'] = array("$singular bearbeiten","Bearbeiten der $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['copy'] = array("$singular kopieren","Kopieren der $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['delete'] = array("$singular löschen","Löschen der $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['show'] = array("$singular anzeigen","Anzeigen der $singular ID %s");