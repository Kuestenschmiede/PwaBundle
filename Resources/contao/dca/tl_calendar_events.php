<?php

use con4gis\PwaBundle\Classes\Callbacks\EventsCallback;

$GLOBALS['TL_DCA']['tl_calendar_events']['config']['onsubmit_callback'][] = [EventsCallback::class, 'sendPushNotification'];