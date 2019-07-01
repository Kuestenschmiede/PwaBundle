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
                if ($activeRecord->pnSendDate <= time()) {
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
        $array = explode('/', $value);
        $month = $array[0];
        $day = $array[1];
        $year = $array[2];
        try {
            $dateTime = new \DateTime();
            $dateTime->setDate($year, $month, $day);
            return $dateTime->getTimestamp();
        } catch(\Throwable $e) {
            return $value;
        }
    }
    
    public function convertTimeStampToDateString($value, $dc) {
        try {
            $dateTime = new \DateTime();
            if ($value == 0) {
                $value = time();
            }
            $dateTime->setTimestamp($value);
            $year = $dateTime->format('Y');
            $month = $dateTime->format('m');
            $day = $dateTime->format('d');
            return "$month/$day/$year";
        } catch(\Throwable $e) {
            return $value;
        }
    }
    
}