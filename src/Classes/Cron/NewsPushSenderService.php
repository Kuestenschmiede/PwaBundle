<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 10
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2025, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
namespace con4gis\PwaBundle\Classes\Cron;

use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Controller;
use Contao\Database;
use Contao\NewsArchiveModel;
use Contao\System;

class NewsPushSenderService
{
    /**
     * Gets all news that are not sent and should be sent, checks their date and sends them, if needed.
     */
    public function onMinutely()
    {
        $currentTime = time();
        $db = Database::getInstance();
        $arrNews = $db->prepare('SELECT * FROM tl_news AS news WHERE news.pnSent = 0 AND news.published = 1 AND
                    (SELECT archive.pushOnPublish FROM tl_news_archive AS archive WHERE news.pid = archive.id)
                     = 1')
            ->execute()->fetchAllAssoc();
        foreach ($arrNews as $news) {
            $sendDate = intval($news['pnSendDate']);
            $startDate = intval($news['start']);
            $endDate = intval($news['stop']);
            $sendDateIsPastOrUnspecified = (!$sendDate || ($sendDate <= $currentTime));
            $isNewsDisplayed = !$startDate || ($currentTime >= $startDate)
                && (!$endDate || ($currentTime <= $endDate));
            if ($sendDateIsPastOrUnspecified && $isNewsDisplayed) {
                $parser = System::getContainer()->get('contao.insert_tag.parser');
                $url = $parser->replace('{{news::' . $news['id'] . '}}');

                //ToDo ask for url selection
                if (!$url && $news['url']) {
                    $url = $news['url'];
                }

                $sendEvent = new PushNotificationEvent();
                $sendEvent->setTitle($news['headline'] ?: '');
                $sendEvent->setMessage(strip_tags($news['teaser']) ?: '');
                if ($url) {
                    $sendEvent->setClickUrl($url);
                }
                $archive = NewsArchiveModel::findByPk($news['pid']);
                $subscriptionTypes = \Contao\StringUtil::deserialize($archive->subscriptionTypes);
                if ($subscriptionTypes && count($subscriptionTypes) > 0) {
                    $sendEvent->setSubscriptionTypes($subscriptionTypes);
                    System::getContainer()->get('event_dispatcher')->dispatch($sendEvent, $sendEvent::NAME);
                    $db->prepare('UPDATE tl_news SET pnSent = 1 WHERE id = ?')
                        ->execute($news['id']);
                }
            }
        }
    }
}
