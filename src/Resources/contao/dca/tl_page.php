<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2021, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */

use Contao\CoreBundle\Util\PackageUtil;

$GLOBALS['TL_DCA']['tl_page']['config']['onsubmit_callback'][] = ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'createServiceWorker'];

//do not apply to rootfallback palette before 4.9
$version = explode('.', PackageUtil::getContaoVersion());
$rootfallback = true;
if ($version) {
    $major   = intval($version[0]);
    $minor   = intval($version[1]);
    if ($major && $minor && (intval($major) <= 4) && (intval($minor) <= 8)) {
        $rootfallback = false;
    }
}

if ($rootfallback) {
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('pwa_legend', 'layout_legend')
        ->addField(array('pwaConfig','uncachedPages'), 'pwa_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('root', 'tl_page')
        ->applyToPalette('rootfallback', 'tl_page');
} else {
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('pwa_legend', 'layout_legend')
        ->addField(array('pwaConfig','uncachedPages'), 'pwa_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('root', 'tl_page');
}

$GLOBALS['TL_DCA']['tl_page']['fields']['pwaConfig'] = [
        'label'             => &$GLOBALS['TL_LANG']['tl_page']['pwaConfig'],
        'default'           => '0',
        'inputType'         => 'select',
        'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'getPwaConfigOptions'],
        'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true),
        'sql'               => "int(10) unsigned NOT NULL default '0'",
        'exclude'           => true
];

$GLOBALS['TL_DCA']['tl_page']['fields']['uncachedPages'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['uncachedPages'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'pageTree',
    'eval'                    => ['fieldType'=>'checkbox', 'multiple' => true, 'filesOnly' => true],
    'sql'                     => "blob NULL"
];
