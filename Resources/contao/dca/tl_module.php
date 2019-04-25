<?php


$GLOBALS['TL_DCA']['tl_module']['palettes']['pwa'] = "{title_legend},name,type,pwaConfiguration";

$GLOBALS['TL_DCA']['tl_module']['fields']['pwaConfiguration'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_module']['pwaConfiguration'],
    'default'           => '',
    'inputType'         => 'select',
    'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'getPwaConfigOptions'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true),
    'sql'               => "int(10) unsigned NOT NULL default '0'"
];