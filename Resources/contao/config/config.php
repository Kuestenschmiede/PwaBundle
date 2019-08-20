<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    6
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
$GLOBALS['BE_MOD']['con4gis_core'] = array_merge($GLOBALS['BE_MOD']['con4gis_core'], array
(
    'pwaConfiguration' => array
    (
        'tables'    => array('tl_c4g_pwa_configuration')
    ),
    'webpushConfiguration' => array
    (
        'tables'    => array('tl_c4g_webpush_configuration')
    ),
    'sendPush' => array(
        'tables' => array('tl_c4g_push_notification'),
        'stylesheet' => "bundles/con4gispwa/css/backend-push.css"
    ),
    'pushSubscriptionType' => [
        'tables' => ['tl_c4g_push_subscription_type']
    ]
));

$GLOBALS['BE_MOD']['content']['calendar']['resetSentFlag'] = [EventsCallback::class, 'resetPnSentFlag'];
$GLOBALS['BE_MOD']['content']['calendar']['sendPn'] = [EventsCallback::class, 'forceSendPn'];

if (!$GLOBALS['TL_CRON']['daily']) {
    $GLOBALS['TL_CRON']['daily'] = [];
}

//$GLOBALS['TL_CRON']['daily'] = [['con4gis\PwaBundle\Classes\Services\EventPushSenderService', 'sendUnsentEvents']];
$GLOBALS['TL_CRON']['hourly'][] = ['con4gis\PwaBundle\Classes\Services\EventPushSenderService', 'sendUnsentEvents'];
$GLOBALS['TL_CRON']['hourly'][] = ['con4gis\PwaBundle\Classes\Services\NewsPushSenderService', 'sendUnsentNews'];
