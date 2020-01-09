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

$GLOBALS['TL_DCA']['tl_page']['config']['onsubmit_callback'][] = ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'createServiceWorker'];

$paletteManipulator = \Contao\CoreBundle\DataContainer\PaletteManipulator::create();
$paletteManipulator->addLegend('pwa_legend', 'publish_legend');
$paletteManipulator->addField('pwaConfig', 'pwa_legend');
$paletteManipulator->addField('uncachedPages', 'pwa_legend');
$paletteManipulator->applyToPalette('root', 'tl_page');

$GLOBALS['TL_DCA']['tl_page']['fields']['pwaConfig'] = [
        'label'             => $GLOBALS['TL_LANG']['tl_page']['pwaConfig'],
        'default'           => '0',
        'inputType'         => 'select',
        'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'getPwaConfigOptions'],
        'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true),
        'sql'               => "int(10) unsigned NOT NULL default '0'"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['uncachedPages'] = [
    'label'                   => $GLOBALS['TL_LANG']['tl_page']['uncachedPages'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'pageTree',
    'eval'                    => ['fieldType'=>'checkbox', 'multiple' => true, 'filesOnly' => true],
    'sql'                     => "blob NULL"
];