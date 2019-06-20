<?php


namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Backend;
use Contao\CalendarModel;
use Contao\DataContainer;
use Contao\NewsArchiveModel;
use Contao\System;

class EventsCallback extends Backend
{
    public function sendPushNotification(DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;
        if ($activeRecord->published) {
            $pid = $activeRecord->pid;
            $calendar = CalendarModel::findById($pid);
            if ($calendar->pushOnPublish) {
                $event = new PushNotificationEvent();
                $event->setSubscriptionTypes(unserialize($calendar->subscriptionTypes));
                $event->setTitle($activeRecord->title);
                $event->setMessage(strip_tags($activeRecord->teaser));
                System::getContainer()->get('event_dispatcher')->dispatch($event::NAME, $event);
            }
        }
    }
}