<?php


use con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback;

$GLOBALS['TL_DCA']['tl_calendar']['palettes']['__selector__'][] = 'pushOnPublish';

$GLOBALS['TL_DCA']['tl_calendar']['palettes']['default'] .= ',pushOnPublish';

$GLOBALS['TL_DCA']['tl_calendar']['subpalettes']['pushOnPublish'] = 'subscriptionTypes';

$GLOBALS['TL_DCA']['tl_calendar']['fields']['pushOnPublish'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_calendar']['pushOnPublish'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'checkbox',
    'eval'                    => ['submitOnChange' => true],
    'sql'                     => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_calendar']['fields']['subscriptionTypes'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_calendar']['subscriptionTypes'],
    'default'           => [],
    'inputType'         => 'select',
    'options_callback'  => [PushNotificationCallback::class, 'getSubscriptionTypes'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true, 'multiple' => true, 'chosen' => true),
    'sql'               => "blob NULL"
];
