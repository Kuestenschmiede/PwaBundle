<?php


namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Backend;
use Contao\CalendarModel;
use Contao\Database;
use Contao\DataContainer;
use Contao\NewsArchiveModel;
use Contao\System;

class EventsCallback extends Backend
{
    public function sendPushNotification(DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;
        if ($activeRecord->published) {
            if ($activeRecord->pushOnPublish) {
                $currentTime = time();
                $sendTime = $activeRecord->pnSendDate;
                if (!is_int($sendTime)) {
                    // date string
                    $sendTime = strtotime($sendTime);
                }
                if ($sendTime <= $currentTime) {
                    $event = new PushNotificationEvent();
                    $event->setSubscriptionTypes(unserialize($activeRecord->subscriptionTypes) ?: []);
                    $event->setTitle($activeRecord->title);
                    $event->setMessage(strip_tags($activeRecord->teaser));
                    System::getContainer()->get('event_dispatcher')->dispatch($event::NAME, $event);
                    Database::getInstance()->prepare("UPDATE tl_calendar_events SET pnSent = 1 WHERE id = ?")
                        ->execute($activeRecord->id);
                }
            }
        }
    }
    
    public function convertDateStringToTimeStamp($value, $dc) {
        if (is_int($value)) {
            return $value;
        } else {
            return strtotime($value);
        }
    }
    
    public function convertTimeStampToDateString($value, $dc) {
        return date($GLOBALS['TL_CONFIG']['dateFormat'], $value);
    }
    
}