<?php


$GLOBALS['TL_DCA']['tl_module']['palettes']['pwa'] = "{title_legend},name,type,pwaConfiguration";
$GLOBALS['TL_DCA']['tl_module']['palettes']['push-subscription'] = "{title_legend},name,type,subscribeText,unsubscribeText";

$GLOBALS['TL_DCA']['tl_module']['fields']['pwaConfiguration'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_module']['pwaConfiguration'],
    'default'           => '',
    'inputType'         => 'select',
    'options_callback'  => ['con4gis\PwaBundle\Classes\Callbacks\PageCallback', 'getPwaConfigOptions'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true),
    'sql'               => "int(10) unsigned NOT NULL default '0'"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['subscribeText'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_module']['subscribeText'],
    'default'           => 'Pushnachrichten abonnieren',
    'inputType'         => 'text',
    'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
    'sql'               => "varchar(100) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['unsubscribeText'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_module']['unsubscribeText'],
    'default'           => 'Pushnachrichten deabonnieren',
    'inputType'         => 'text',
    'eval'              => array('mandatory' => true, 'tl_class' => 'long'),
    'sql'               => "varchar(100) NOT NULL default ''"
];