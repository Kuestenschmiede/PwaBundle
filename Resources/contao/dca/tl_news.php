<?php

use con4gis\PwaBundle\Classes\Callbacks\NewsCallback;

$GLOBALS['TL_DCA']['tl_news']['config']['onsubmit_callback'][] = [NewsCallback::class, 'sendPushNotification'];

$GLOBALS['TL_DCA']['tl_news']['fields']['pnSent'] = [
    "sql" => "int(10) NOT NULL default 0"
];