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
namespace con4gis\PwaBundle\Classes\Services;

use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Controller;
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
        $currentTime = time();
        $arrEvents = $db->prepare('SELECT * FROM tl_calendar_events WHERE published = 1 AND pnSent != 1 AND (pushOnPublish = 1 OR sendDoublePn = 1)')
            ->execute()->fetchAllAssoc();

        foreach ($arrEvents as $event) {

            //send on senddate if published || send if published
            if (($event['sendDoublePn'] && ($event['pnSendDate'] <= $currentTime) && (
                  (!$event['start'] || ($currentTime >= $event['start'])) &&
                  (!$event['stop'] || ($currentTime >= $event['stop']))
                )) || ($event['sendOnPublished'] && (
                        (!$event['start'] || ($currentTime >= $event['start'])) &&
                        (!$event['stop'] || ($currentTime >= $event['stop']))
                    ))) {
                //$pid = $event['pid'];

                $url = Controller::replaceInsertTags('{{event_url::' . $event['id'] . '}}');

                //ToDo ask for url selection
                if ($event['url']) {
                    $url = $event['url'];
                }
                $sendEvent = new PushNotificationEvent();
                $sendEvent->setTitle($event['title']);
                $sendEvent->setMessage(strip_tags($event['teaser']));
                if ($url) {
                    $sendEvent->setClickUrl($url);
                }
                $sendEvent->setSubscriptionTypes($event['subscriptionTypes'] ? unserialize($event['subscriptionTypes']) : []);
                System::getContainer()->get('event_dispatcher')->dispatch($sendEvent, $sendEvent::NAME);
                $db->prepare('UPDATE tl_calendar_events SET pnSent = 1 WHERE id = ?')
                    ->execute($event['id']);
            }
        }
    }
}
