<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    7
 * @author  	con4gis contributors (see "authors.txt")
 * @license 	LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

use con4gis\PwaBundle\Classes\Callbacks\EventsCallback;

$GLOBALS['FE_MOD']['con4gis']['pwa'] = 'con4gis\PwaBundle\Resources\contao\modules\AddManifestModule';
$GLOBALS['FE_MOD']['con4gis']['push-subscription'] = 'con4gis\PwaBundle\Resources\contao\modules\PushSubscriptionModule';

/**
 * Backend Modules
 */

$GLOBALS['BE_MOD']['con4gis'] = array_merge($GLOBALS['BE_MOD']['con4gis'], [
    'c4g_pwa_configuration' => array
    (
        'tables'    => array('tl_c4g_pwa_configuration')
    ),
    'c4g_webpush_configuration' => array
    (
        'tables'    => array('tl_c4g_webpush_configuration')
    ),
    'c4g_push_notification' => array(
        'tables' => array('tl_c4g_push_notification'),
        'stylesheet' => "bundles/con4gispwa/css/backend-push.css"
    ),
    'c4g_push_subscription_type' => [
        'tables' => ['tl_c4g_push_subscription_type']
    ]
]);

if (TL_MODE == "BE") {
    $GLOBALS['TL_CSS'][] = '/bundles/con4gispwa/css/con4gis.css';
}

$GLOBALS['BE_MOD']['content']['calendar']['resetSentFlag'] = [EventsCallback::class, 'resetPnSentFlag'];
$GLOBALS['BE_MOD']['content']['calendar']['sendPn'] = [EventsCallback::class, 'forceSendPn'];

$GLOBALS['TL_CRON']['minutely'][] = ['con4gis\PwaBundle\Classes\Services\EventPushSenderService', 'sendUnsentEvents'];
$GLOBALS['TL_CRON']['minutely'][] = ['con4gis\PwaBundle\Classes\Services\NewsPushSenderService', 'sendUnsentNews'];
