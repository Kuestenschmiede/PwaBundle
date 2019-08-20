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

class NewsPushSenderService
{
    /**
     * Gets all news that are not sent and should be sent, checks their date and sends them, if needed.
     */
    public function sendUnsentNews()
    {
        $currentTime = time();
        $db = Database::getInstance();
        $arrNews = $db->prepare("SELECT * FROM tl_news AS news WHERE pnSent = 0 AND
                    (SELECT archive.pushOnPublish FROM tl_news_archive AS archive WHERE news.pid = archive.id)
                     = 1")
            ->execute()->fetchAllAssoc();
        foreach ($arrNews as $news) {
            if ($news['pnSendDate'] <= $currentTime && $currentTime >= $news['start'] && $currentTime <= $news['stop']) {
                $sendEvent = new PushNotificationEvent();
                $sendEvent->setTitle($news['title'] ?: "");
                $sendEvent->setMessage(strip_tags($news['teaser']) ?: "");
                $sendEvent->setSubscriptionTypes($news['subscriptionTypes'] ? unserialize($news['subscriptionTypes']) : []);
                System::getContainer()->get('event_dispatcher')->dispatch($sendEvent::NAME, $sendEvent);
                $db->prepare("UPDATE tl_news SET pnSent = 1 WHERE id = ?")
                    ->execute($news['id']);
            }
        }
    }
}