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

use con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback;

$GLOBALS['TL_DCA']['tl_module']['palettes']['pwa'] = "{title_legend},name,type,pwaConfiguration,cronActivation";
$GLOBALS['TL_DCA']['tl_module']['palettes']['push-subscription'] = "{title_legend},name,type,subscribeText,unsubscribeText,subscriptionTypes,disableSelection";

$GLOBALS['TL_DCA']['tl_module']['fields']['pwaConfiguration'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_module']['pwaConfiguration'],
    'default'           => 0,
    'inputType'         => 'select',
    'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'getPwaConfigOptions'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'clr', 'includeBlankOption' => true),
    'sql'               => "int(10) unsigned NOT NULL default 0",
    'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_module']['fields']['subscribeText'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_module']['subscribeText'],
    'default'           => 'Pushnachrichten abonnieren',
    'inputType'         => 'text',
    'eval'              => array('mandatory' => true, 'tl_class' => 'clr'),
    'sql'               => "varchar(100) NOT NULL default ''",
    'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_module']['fields']['unsubscribeText'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_module']['unsubscribeText'],
    'default'           => 'Abonnement bearbeiten',
    'inputType'         => 'text',
    'eval'              => array('mandatory' => true, 'tl_class' => 'clr'),
    'sql'               => "varchar(100) NOT NULL default ''",
    'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_module']['fields']['subscriptionTypes'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_module']['subscriptionTypes'],
    'default'           => [],
    'inputType'         => 'select',
    'options_callback'  => [PushNotificationCallback::class, 'getSubscriptionTypes'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true, 'multiple' => true, 'chosen' => true),
    'sql'               => "blob NULL",
    'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_module']['fields']['disableSelection'] = [
    'label'                   => $GLOBALS['TL_LANG']['tl_module']['disableSelection'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['cronActivation'] = [
    'label'                   => $GLOBALS['TL_LANG']['tl_module']['cronActivation'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
];