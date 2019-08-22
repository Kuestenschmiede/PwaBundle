<?php

use con4gis\PwaBundle\Classes\Callbacks\EventsCallback;
use con4gis\PwaBundle\Classes\Callbacks\NewsCallback;

$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] .= ",pnSendDate";

$GLOBALS['TL_DCA']['tl_news']['config']['onsubmit_callback'][] = [NewsCallback::class, 'sendPushNotification'];

$GLOBALS['TL_DCA']['tl_news']['fields']['pnSent'] = [
    "sql" => "int(10) NOT NULL default 0"
];

$GLOBALS['TL_DCA']['tl_news']['fields']['pnSendDate'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['pnSendDate'],
    'sorting'                 => true,
    'search'                  => true,
    'inputType'               => 'text',
    'default'                 => time(),
    'save_callback'           => array(array(EventsCallback::class, 'convertDateStringToTimeStamp')),
    'load_callback'           => array(array(EventsCallback::class, 'convertTimeStampToDateString')),
    'eval'                    => array('rgxp'=>'datim', 'mandatory' => false, 'datepicker' => true, 'tl_class' => 'clr'),
    "sql" => "int(10) NOT NULL default 0"
];