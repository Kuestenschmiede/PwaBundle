<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 20.03.19
 * Time: 16:57
 */

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
    )
));