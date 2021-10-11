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

$GLOBALS['FE_MOD']['con4gis']['pwa'] = 'con4gis\PwaBundle\Resources\contao\modules\AddManifestModule';
$GLOBALS['FE_MOD']['con4gis']['push-subscription'] = 'con4gis\PwaBundle\Resources\contao\modules\PushSubscriptionModule';
asort($GLOBALS['FE_MOD']['con4gis']);

/**
 * Backend Modules
 */

$GLOBALS['BE_MOD']['con4gis'] = array_merge($GLOBALS['BE_MOD']['con4gis'], [
    'c4g_pwa_configuration' => array
    (
        'brick' => 'pwa',
        'tables'    => array('tl_c4g_pwa_configuration'),
        'icon' => 'bundles/con4giscore/images/be-icons/edit.svg'
    ),
    'c4g_webpush_configuration' => array
    (
        'brick' => 'pwa',
        'tables'    => array('tl_c4g_webpush_configuration'),
        'icon' => 'bundles/con4gispwa/images/be-icons/webpush_config.svg'
    ),
    'c4g_push_notification' => array(
        'brick' => 'pwa',
        'tables' => array('tl_c4g_push_notification'),
        'stylesheet' => "bundles/con4gispwa/dist/css/backend-push.min.css",
        'icon' => 'bundles/con4gispwa/images/be-icons/push_example.svg'
    ),
    'c4g_push_subscription_type' => [
        'brick' => 'pwa',
        'tables' => ['tl_c4g_push_subscription_type'],
        'icon' => 'bundles/con4gispwa/images/be-icons/push_types.svg'
    ]
]);
if (class_exists('Contao\CalendarBundle\ContaoCalendarBundle')) {
    $GLOBALS['BE_MOD']['content']['calendar']['resetSentFlag'] = [EventsCallback::class, 'resetPnSentFlag'];
    $GLOBALS['BE_MOD']['content']['calendar']['sendPn'] = [EventsCallback::class, 'forceSendPn'];
    $GLOBALS['TL_CRON']['minutely'][] = ['con4gis\PwaBundle\Classes\Services\EventPushSenderService', 'sendUnsentEvents'];
}
if (class_exists('Contao\NewsBundle\ContaoNewsBundle')) {
    $GLOBALS['TL_CRON']['minutely'][] = ['con4gis\PwaBundle\Classes\Services\NewsPushSenderService', 'sendUnsentNews'];
}
