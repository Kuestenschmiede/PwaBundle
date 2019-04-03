<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 21.03.19
 * Time: 14:19
 */

$GLOBALS['TL_DCA']['tl_page']['config']['onsubmit_callback'][] = ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'createServiceWorker'];

$paletteManipulator = \Contao\CoreBundle\DataContainer\PaletteManipulator::create();
$paletteManipulator->addLegend('pwa_legend', 'publish_legend');
$paletteManipulator->addField('pwaConfig', 'pwa_legend');
$paletteManipulator->addField('uncachedPages', 'pwa_legend');
$paletteManipulator->applyToPalette('root', 'tl_page');

$GLOBALS['TL_DCA']['tl_page']['fields']['pwaConfig'] = [
        'label'             => $GLOBALS['TL_LANG']['tl_page']['pwaConfig'],
        'default'           => '',
        'inputType'         => 'select',
        'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'getPwaConfigOptions'],
        'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true),
        'sql'               => "int(10) unsigned NOT NULL default '0'"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['uncachedPages'] = [
    'label'                   => $GLOBALS['TL_LANG']['tl_page']['uncachedPages'],
    'exclude'                 => true,
    'inputType'               => 'pageTree',
    'eval'                    => ['fieldType'=>'checkbox', 'multiple' => true, 'filesOnly' => true],
    'sql'                     => "blob NULL"
];