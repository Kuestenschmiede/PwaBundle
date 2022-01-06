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
    "sql" => "int(10) NOT NULL default 0",
    'exclude' => true
];