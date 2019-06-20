<?php


namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Backend;
use Contao\DataContainer;
use Contao\NewsArchiveModel;
use Contao\System;

class NewsCallback extends Backend
{
    public function sendPushNotification(DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;
        if ($activeRecord->published) {
            $pid = $activeRecord->pid;
            $archive = NewsArchiveModel::findById($pid);
            if ($archive->pushOnPublish) {
                $event = new PushNotificationEvent();
                $event->setSubscriptionTypes(unserialize($archive->subscriptionTypes));
                $event->setTitle($activeRecord->headline);
                $event->setMessage(strip_tags($activeRecord->teaser));
                System::getContainer()->get('event_dispatcher')->dispatch($event::NAME, $event);
            }
        }
    }
    
}