<?php

use con4gis\PwaBundle\Classes\Callbacks\EventsCallback;
use con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback;

$GLOBALS['TL_DCA']['tl_calendar_events']['config']['onsubmit_callback'][] = [EventsCallback::class, 'sendPushNotification'];

$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] .= ",pushOnPublish,pnSendDate,subscriptionTypes";

$GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations']['resetSentFlag'] = [
    'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events']['resetSentFlag'],
    'href'                => 'key=resetSentFlag',
    'icon'                => 'undo.svg'
];

$GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations']['sendPn'] = [
    'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events']['sendPn'],
    'href'                => 'key=sendPn',
    'icon'                => 'mover.svg'
];

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['pushOnPublish'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['pushOnPublish'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'checkbox',
    'eval'                    => ['submitOnChange' => true, 'tl_class' => "clr"],
    'sql'                     => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['pnSendDate'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['pnSendDate'],
    'sorting'                 => true,
    'search'                  => true,
    'inputType'               => 'text',
    'default'                 => 0,
    'save_callback'           => array(array(EventsCallback::class, 'convertDateStringToTimeStamp')),
    'load_callback'           => array(array(EventsCallback::class, 'convertTimeStampToDateString')),
    'eval'                    => array('rgxp'=>'date', 'mandatory' => false, 'datepicker' => true, 'tl_class' => 'clr'),
    "sql" => "int(10) NOT NULL default 0"
];

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['subscriptionTypes'] = [
    'label'             => $GLOBALS['TL_LANG']['tl_calendar_events']['subscriptionTypes'],
    'default'           => [],
    'inputType'         => 'select',
    'options_callback'  => [PushNotificationCallback::class, 'getSubscriptionTypes'],
    'eval'              => array('mandatory' => false, 'tl_class' => 'clr', 'includeBlankOption' => true, 'multiple' => true, 'chosen' => true),
    'sql'               => "blob NULL"
];

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['pnSent'] = [
    "sql" => "int(10) NOT NULL default 0"
];