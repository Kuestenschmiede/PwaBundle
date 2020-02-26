<?php


use con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback;

$GLOBALS['TL_DCA']['tl_news_archive']['palettes']['__selector__'][] = 'pushOnPublish';

$GLOBALS['TL_DCA']['tl_news_archive']['palettes']['default'] .= ',pushOnPublish';

$GLOBALS['TL_DCA']['tl_news_archive']['subpalettes']['pushOnPublish'] = 'subscriptionTypes';

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['pushOnPublish'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_news_archive']['pushOnPublish'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'checkbox',
    'eval'                    => ['submitOnChange' => true],
    'sql'                     => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['subscriptionTypes'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_news_archive']['subscriptionTypes'],
    'default'           => [],
    'inputType'         => 'select',
    'options_callback'  => [PushNotificationCallback::class, 'getSubscriptionTypes'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'long', 'includeBlankOption' => true, 'multiple' => true, 'chosen' => true),
    'sql'               => "blob NULL",
    'exclude'           => true
];
