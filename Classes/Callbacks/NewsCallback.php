<?php


namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Backend;
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
            && $currentTime >= $activeRecord->start
            && $currentTime <= $activeRecord->stop
            && $activeRecord->pnSent === 0
        ) {
            $pid = $activeRecord->pid;
            $archive = NewsArchiveModel::findById($pid);
            if ($archive->pushOnPublish) {
                $event = new PushNotificationEvent();
                $event->setSubscriptionTypes(unserialize($archive->subscriptionTypes) ?: []);
                $event->setTitle($activeRecord->headline);
                $event->setMessage(strip_tags($activeRecord->teaser));
                System::getContainer()->get('event_dispatcher')->dispatch($event::NAME, $event);
                Database::getInstance()->prepare("UPDATE tl_news SET pnSent = 1 WHERE id = ?")
                    ->execute($activeRecord->id);
            }
        }
    }
    
}