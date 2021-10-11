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
use con4gis\PwaBundle\Classes\Callbacks\PushNotificationCallback;

if (class_exists('Contao\CalendarBundle\ContaoCalendarBundle')) {
    $GLOBALS['TL_DCA']['tl_calendar_events']['config']['onsubmit_callback'][] = [EventsCallback::class, 'sendPushNotification'];
    
    $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['__selector__'][] = 'sendDoublePn';
    $GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['sendDoublePn'] = 'pnSendDate';
    
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('pwa_legend', 'expert_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
        ->addField(array('subscriptionTypes','pushOnPublish','sendDoublePn'), 'pwa_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('default', 'tl_calendar_events');
    
    $GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations']['resetSentFlag'] = [
        'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events']['resetSentFlag'],
        'href'                => 'key=resetSentFlag',
        'icon'                => 'undo.svg',
        'exclude'             => true
    ];
    
    $GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations']['sendPn'] = [
        'label'               => &$GLOBALS['TL_LANG']['tl_calendar_events']['sendPn'],
        'href'                => 'key=sendPn',
        'icon'                => 'bundles/con4gispwa/img/resend.svg',
        'exclude'             => true
    ];
    
    $GLOBALS['TL_DCA']['tl_calendar_events']['fields']['pushOnPublish'] = [
        'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['pushOnPublish'],
        'exclude'                 => true,
        'default'                 => '',
        'inputType'               => 'checkbox',
        'eval'                    => ['submitOnChange' => false, 'tl_class' => "clr"],
        'sql'                     => "char(1) NOT NULL default ''"
    ];
    
    $GLOBALS['TL_DCA']['tl_calendar_events']['fields']['pnSendDate'] = [
        'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['pnSendDate'],
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
    
    $GLOBALS['TL_DCA']['tl_calendar_events']['fields']['subscriptionTypes'] = [
        'label'             => $GLOBALS['TL_LANG']['tl_calendar_events']['subscriptionTypes'],
        'default'           => [],
        'inputType'         => 'select',
        'options_callback'  => [PushNotificationCallback::class, 'getSubscriptionTypes'],
        'eval'              => array('mandatory' => false, 'tl_class' => 'clr', 'includeBlankOption' => true, 'multiple' => true, 'chosen' => true),
        'sql'               => "blob NULL",
        'exclude'           => true
    ];
    
    $GLOBALS['TL_DCA']['tl_calendar_events']['fields']['sendDoublePn'] = [
        'label'                   => &$GLOBALS['TL_LANG']['tl_calendar_events']['sendDoublePn'],
        'exclude'                 => true,
        'default'                 => '',
        'inputType'               => 'checkbox',
        'eval'                    => ['submitOnChange' => true, 'tl_class' => "clr"],
        'sql'                     => "char(1) NOT NULL default ''"
    ];
    
    $GLOBALS['TL_DCA']['tl_calendar_events']['fields']['pnSent'] = [
        "sql" => "int(10) NOT NULL default 0"
    ];
}

