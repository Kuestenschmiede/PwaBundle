<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 21.03.19
 * Time: 12:56
 */

use con4gis\PwaBundle\Entity\PwaConfiguration;

$strName = 'tl_c4g_pwa_configuration';

$GLOBALS['TL_LANG'][$strName]['name'] = ['Name', 'Name der PWA'];
$GLOBALS['TL_LANG'][$strName]['shortName']  = ['Kurzform', 'Kurzform des Namens der PWA'];
$GLOBALS['TL_LANG'][$strName]['description'] = ['Beschreibung', 'Beschreibung der PWA'];
$GLOBALS['TL_LANG'][$strName]['themeColor'] = ['Theme-Farbe', 'Geben Sie eine Farbe für das Theme der PWA an.'];
$GLOBALS['TL_LANG'][$strName]['backgroundColor'] = ['Hintergrund-Farbe', 'Geben sie eine Farbe für den Hintergrund der PWA an.'];
$GLOBALS['TL_LANG'][$strName]['display'] = ['Anzeigemodus', 'Wählen Sie den gewünschten Anzeigemodus für die PWA aus.'];
$GLOBALS['TL_LANG'][$strName]['orientation'] = ['Ausrichtung', 'Wählen Sie die gewünschte Ausrichtung für die PWA aus.'];
$GLOBALS['TL_LANG'][$strName]['offlinePage'] = ['Offline-Seite', 'Wählen Sie die Seite aus, die als Fallback im Offline-Modus angezeigt werden soll.'];
$GLOBALS['TL_LANG'][$strName]['icon192'] = ['Icon der Größe 192x192', 'Wählen Sie ein Icon für die PWA aus (Maße 192x192).'];
$GLOBALS['TL_LANG'][$strName]['icon512'] = ['Icon der Größe 512x512', 'Wählen Sie ein Icon für die PWA aus (Maße 512x512).'];
$GLOBALS['TL_LANG'][$strName]['appleIcon120'] = ['(nur iOS) Icon der Größe 120x120', 'Wählen Sie ein Icon für die PWA aus (Maße 120x120).'];
$GLOBALS['TL_LANG'][$strName]['appleIcon152'] = ['(nur iOS) Icon der Größe 152x152', 'Wählen Sie ein Icon für die PWA aus (Maße 152x152).'];
$GLOBALS['TL_LANG'][$strName]['appleIcon180'] = ['(nur iOS) Icon der Größe 180x180', 'Wählen Sie ein Icon für die PWA aus (Maße 180x180).'];
$GLOBALS['TL_LANG'][$strName]['appleIcon167'] = ['(nur iOS) Icon der Größe 167x167', 'Wählen Sie ein Icon für die PWA aus (Maße 167x167).'];
$GLOBALS['TL_LANG'][$strName]['serviceWorkerGen'] = ['Art der Service Worker Generierung', 'Wählen Sie aus, ob ein SW generiert werden soll oder ob ein eigener verwendet werden soll.'];
$GLOBALS['TL_LANG'][$strName]['infotext'] = "Bitte beachten Sie, dass die Änderungen an der Konfiguration erst mit dem erneuten Speichern des Startpunktes der Website, dem die Konfiguration zugeordnet ist, wirksam werden.";

// Options
$GLOBALS['TL_LANG'][$strName]['displayOptions'][PwaConfiguration::PWA_DISPLAY_FULLSCREEN] = "Vollbild";
$GLOBALS['TL_LANG'][$strName]['displayOptions'][PwaConfiguration::PWA_DISPLAY_STANDALONE] = "Standalone";
$GLOBALS['TL_LANG'][$strName]['displayOptions'][PwaConfiguration::PWA_DISPLAY_MINIMAL_UI] = "Minimale UI";
$GLOBALS['TL_LANG'][$strName]['displayOptions'][PwaConfiguration::PWA_DISPLAY_BROWSER] = "Browseransicht";

$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_ANY] = "Automatisch";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_NATURAL] = "Natürlich";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_LANDSCAPE] = "Breitbild";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_LANDSCAPE_PRIMARY] = "Breitbild (Button rechts)";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_LANDSCAPE_SECONDARY] = "Breitbild (Button links)";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_PORTRAIT] = "Hochformat";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_PORTRAIT_PRIMARY] = "Hochformat (Button rechts)";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_PORTRAIT_SECONDARY] = "Hochformat (Button links)";

$GLOBALS['TL_LANG'][$strName]['offlineHandling'][PwaConfiguration::PWA_OFFLINE_HANDLING_ALWAYS] = "Immer auf Offline-Seite weiterleiten";
$GLOBALS['TL_LANG'][$strName]['offlineHandling'][PwaConfiguration::PWA_OFFLINE_HANDLING_FALLBACK] = "Normalen Cache-Mechanismus nutzen (Offline-Seite als Fallback)";

// legends
$GLOBALS['TL_LANG'][$strName]['data_legend'] = 'Angaben für Manifest-Datei';

// operations
$singular = 'PWA-Konfiguration';
$GLOBALS['TL_LANG'][$strName]['new'] = array("$singular hinzufügen","$singular hinzufügen");
$GLOBALS['TL_LANG'][$strName]['edit'] = array("$singular bearbeiten","Bearbeiten der $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['copy'] = array("$singular kopieren","Kopieren der $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['delete'] = array("$singular löschen","Löschen der $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['show'] = array("$singular anzeigen","Anzeigen der $singular ID %s");