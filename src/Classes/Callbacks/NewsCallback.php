<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2022, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
namespace con4gis\PwaBundle\Classes\Callbacks;

use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Backend;
use Contao\Controller;
use Contao\Database;
use Contao\DataContainer;
use Contao\NewsArchiveModel;
use Contao\System;

class NewsCallback extends Backend
{
    public function sendPushNotification(DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;
        $currentTime = time();
        if ($activeRecord->published
            && (!$activeRecord->start || ($currentTime >= $activeRecord->start))
            && (!$activeRecord->stop || ($currentTime <= $activeRecord->stop))
            && ($activeRecord->pnSent == 0)
        ) {
            $pid = $activeRecord->pid;
            $archive = NewsArchiveModel::findById($pid);
            if ($archive->pushOnPublish) {
                $parser = System::getContainer()->get('contao.insert_tag.parser');
                $url = $parser->replace('{{news::' . $activeRecord->id . '}}');

                //ToDo ask for url selection
                if ($activeRecord->url) {
                    $url = $activeRecord->url;
                }
                $sendTime = $activeRecord->pnSendDate;
                if (!is_int($sendTime)) {
                    // date string
                    $sendTime = strtotime($sendTime);
                }
                if (!$sendTime || ($sendTime <= $currentTime)) {
                    $event = new PushNotificationEvent();
                    $event->setSubscriptionTypes(\Contao\StringUtil::deserialize($archive->subscriptionTypes) ?: []);
                    $event->setTitle($activeRecord->headline);
                    $event->setMessage(strip_tags($activeRecord->teaser));
                    if ($url) {
                        $event->setClickUrl($url);
                    }
                    System::getContainer()->get('event_dispatcher')->dispatch($event, $event::NAME);
                    Database::getInstance()->prepare('UPDATE tl_news SET pnSent = 1 WHERE id = ?')
                        ->execute($activeRecord->id);
                }
            }
        }
    }
}
