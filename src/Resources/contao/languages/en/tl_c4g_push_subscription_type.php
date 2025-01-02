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

$GLOBALS['TL_LANG'][$strName]['name'] = ['Name of the subscription type', 'Insert the name for this subscription type.'];
$GLOBALS['TL_LANG'][$strName]['pushConfig'] = ['Push configuration', 'Select the push configuration to be used. These can be created in the backend module of the same name.'];

$GLOBALS['TL_LANG'][$strName]['data_legend'] = 'General data';

$GLOBALS['TL_LANG'][$strName]['editPushConfigurations'] = ['Edit push configuration.'];

$GLOBALS['TL_LANG']['tl_c4g_push_subscription_type']['infotext'] = 'The subscription types can be linked at different places in the Contao backend. For example, in the event settings or in the news archive. '.
    'To subscribe to the types, they have to be linked in the frontend module "Subscribe to push messages". '.
    'More at <a href="https://docs.con4gis.org/push-abonnement-typen" title="con4gis Docs PWA Push subscription types" target="_blank" rel="noopener"><b>docs.con4gis.org</b></a>';

// operations
$singular = 'push subscription type';
$GLOBALS['TL_LANG'][$strName]['new'] = array("Add $singular","Add $singular");
$GLOBALS['TL_LANG'][$strName]['edit'] = array("Edit $singular","Edit $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['copy'] = array("Copy $singular","Copy $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['delete'] = array("Delete $singular","Delete $singular ID %s");
$GLOBALS['TL_LANG'][$strName]['show'] = array("Show $singular","Show $singular ID %s");