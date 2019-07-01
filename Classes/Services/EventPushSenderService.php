<?php
/**
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version        6
 * @author  	    con4gis contributors (see "authors.txt")
 * @license 	    LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link              https://www.con4gis.org
 *
 */

namespace con4gis\PwaBundle\Classes\Services;


use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Database;
use Contao\System;

class EventPushSenderService
{
    /**
     * Gets all events that are not sent and should be sent, checks their date and sends them, if needed.
     */
    public function sendUnsentEvents()
    {
        $db = Database::getInstance();
        $arrEvents = $db->prepare("SELECT * FROM tl_calendar_events WHERE pnSent = 0 AND pushOnPublish = 1")
            ->execute()->fetchAllAssoc();
        foreach ($arrEvents as $event) {
            if ($event['pnSendDate'] <= time()) {
                $sendEvent = new PushNotificationEvent();
                $sendEvent->setTitle($event['title']);
                $sendEvent->setMessage(strip_tags($event['teaser']));
                $sendEvent->setSubscriptionTypes($event['subscriptionTypes'] ? unserialize($event['subscriptionTypes']) : []);
                System::getContainer()->get('event_dispatcher')->dispatch($sendEvent::NAME, $sendEvent);
                $db->prepare("UPDATE tl_calendar_events SET pnSent = 1 WHERE id = ?")
                    ->execute($event['id']);
            }
        }
    }
}