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

use con4gis\PwaBundle\Entity\PwaConfiguration;

$strName = 'tl_c4g_pwa_configuration';

$GLOBALS['TL_LANG'][$strName]['name'] = ['Name', 'Name of the pwa.'];
$GLOBALS['TL_LANG'][$strName]['shortName']  = ['Abbreviation', 'Abbreviation of the name.'];
$GLOBALS['TL_LANG'][$strName]['description'] = ['Description', 'Description of the pwa.'];
$GLOBALS['TL_LANG'][$strName]['startUrl'] = ['Start URL', 'Entry point of the pwa. This URL will be visited when the pwa is started.'];
$GLOBALS['TL_LANG'][$strName]['scope'] = ['Navigation scope', 'Specify an URL. Only this URL and its childs are allowed to be handled by the service worker (when the scope is "www.example.com", "www.example.com/page" is considered a child).'];
$GLOBALS['TL_LANG'][$strName]['themeColor'] = ['Theme color', 'Specify a theme color for the pwa.'];
$GLOBALS['TL_LANG'][$strName]['backgroundColor'] = ['Background color', 'Specify a background color for the pwa.'];
$GLOBALS['TL_LANG'][$strName]['display'] = ['Display mode', 'Choose the display mode of the pwa.'];
$GLOBALS['TL_LANG'][$strName]['orientation'] = ['Orientation', 'Choose the orientation of the pwa.'];
$GLOBALS['TL_LANG'][$strName]['offlinePage'] = ['Offline page', 'Choose a page that should be served as fallback when in offline mode.'];
$GLOBALS['TL_LANG'][$strName]['offlineHandling'] = ['Offline handling', 'Choose the offline handling that the pwa should use.'];
$GLOBALS['TL_LANG'][$strName]['icon192'] = ['Icon (192x192)', 'Choose an icon for the pwa (192x192).'];
$GLOBALS['TL_LANG'][$strName]['icon512'] = ['Icon (512x512)', 'Choose an icon for the pwa (512x512).'];
$GLOBALS['TL_LANG'][$strName]['additionalUrls'] = ['Additional URLs', 'Specify a list of additional URLs that should be cached by the service worker.'];
$GLOBALS['TL_LANG'][$strName]['blockedUrls'] = ['Blocked URLs', 'Specify a list of URLs or URL fragments. When any of these occurs in the requested url, the service worker will do nothing.'];

$GLOBALS['TL_LANG'][$strName]['iosStyle'] = ['iOS - title bar', 'Choose the design of the iOS title bar.'];
$GLOBALS['TL_LANG'][$strName]['appleIcon120'] = ['Touch icon (120x120)', 'Choose an icon for the iOS homescreen (120x120).'];
$GLOBALS['TL_LANG'][$strName]['appleIcon152'] = ['Touch icon (152x152)', 'Choose an icon for the iOS homescreen (152x152).'];
$GLOBALS['TL_LANG'][$strName]['appleIcon180'] = ['Touch icon (180x180)', 'Choose an icon for the iOS homescreen (180x180).'];
$GLOBALS['TL_LANG'][$strName]['appleIcon167'] = ['Touch icon (167x167)', 'Choose an icon for the iOS homescreen (167x167).'];
$GLOBALS['TL_LANG'][$strName]['splashIphoneFirst'] = ['Icon for the splashscreen (1125x2436)', 'Choose an icon that should be used for the splashscreen on iOS.'];
$GLOBALS['TL_LANG'][$strName]['splashIphoneSecond'] = ['Icon for the splashscreen (750x1294)', 'Choose an icon that should be used for the splashscreen on iOS.'];
$GLOBALS['TL_LANG'][$strName]['splashIphoneThird'] = ['Icon for the splashscreen (1242x2148)', 'Choose an icon that should be used for the splashscreen on iOS.'];
$GLOBALS['TL_LANG'][$strName]['splashIphoneFourth'] = ['Icon for the splashscreen (640x1136)', 'Choose an icon that should be used for the splashscreen on iOS.'];
$GLOBALS['TL_LANG'][$strName]['splashIpadFirst'] = ['Icon for the splashscreen (1536x2048)', 'Choose an icon that should be used for the splashscreen on iOS.'];
$GLOBALS['TL_LANG'][$strName]['splashIpadSecond'] = ['Icon for the splashscreen (1668x2224)', 'Choose an icon that should be used for the splashscreen on iOS.'];
$GLOBALS['TL_LANG'][$strName]['splashIpadThird'] = ['Icon for the splashscreen (2048x2732)', 'Choose an icon that should be used for the splashscreen on iOS.'];

$GLOBALS['TL_LANG'][$strName]['infotext'] = "Please be aware of the fact that some changes on this configuration will only take place as soon as the associated page root is saved again.";

// Options
$GLOBALS['TL_LANG'][$strName]['displayOptions'][PwaConfiguration::PWA_DISPLAY_FULLSCREEN] = "Fullscreen";
$GLOBALS['TL_LANG'][$strName]['displayOptions'][PwaConfiguration::PWA_DISPLAY_STANDALONE] = "Standalone";
$GLOBALS['TL_LANG'][$strName]['displayOptions'][PwaConfiguration::PWA_DISPLAY_MINIMAL_UI] = "Minimal UI";
$GLOBALS['TL_LANG'][$strName]['displayOptions'][PwaConfiguration::PWA_DISPLAY_BROWSER] = "Browser view";

$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_ANY] = "Auto";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_NATURAL] = "Natural";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_LANDSCAPE] = "Landscape";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_LANDSCAPE_PRIMARY] = "Landscape (right button)";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_LANDSCAPE_SECONDARY] = "Landscape (left button)";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_PORTRAIT] = "Portrait";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_PORTRAIT_PRIMARY] = "Portrait (right button)";
$GLOBALS['TL_LANG'][$strName]['orientationOptions'][PwaConfiguration::PWA_ORIENTATION_PORTRAIT_SECONDARY] = "Portrait (left button)";

$GLOBALS['TL_LANG'][$strName]['offlineHandling']['options'][PwaConfiguration::PWA_OFFLINE_HANDLING_ALWAYS] = "Always redirect to offline page.";
$GLOBALS['TL_LANG'][$strName]['offlineHandling']['options'][PwaConfiguration::PWA_OFFLINE_HANDLING_FALLBACK] = "Default caching mechanism (network falling back to cache) with offline page as last fallback";

$GLOBALS['TL_LANG'][$strName]['iosStyle'][PwaConfiguration::PWA_IOS_STYLE_BLACK] = "Black";
$GLOBALS['TL_LANG'][$strName]['iosStyle'][PwaConfiguration::PWA_IOS_STYLE_DEFAULT] = "White";

// legends
$GLOBALS['TL_LANG'][$strName]['data_legend'] = 'Settings for manifest file';
$GLOBALS['TL_LANG'][$strName]['expert_legend'] = 'Expert settings';
$GLOBALS['TL_LANG'][$strName]['ios_legend'] = 'iOS specifics';

// operations
$singular = 'PWA configuration';
$GLOBALS['TL_LANG'][$strName]['new'] = array("Add $singular","Add $singular");
$GLOBALS['TL_LANG'][$strName]['edit'] = array("Edit $singular","Show the $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['copy'] = array("Copy $singular","Copy the $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['delete'] = array("Delete $singular","Delete the $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['show'] = array("Show $singular","Show the $singular ID %s");