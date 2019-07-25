<?php


namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Backend;
use Contao\CalendarModel;
use Contao\Controller;
use Contao\Database;
use Contao\DataContainer;
use Contao\DC_Table;
use Contao\Input;
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
                if ($sendTime <= $currentTime && !$activeRecord->pnSent) {
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
    
    /**
     * Sends a push notification for the event and ignores the pnSent flag, and does not update it either.
     * @param DataContainer $dc
     */
    public function forceSendPn(DataContainer $dc)
    {
    
    }
    
    /**
     * Resets the pnSent flag.
     * @param DataContainer $dc
     */
    public function resetPnSentFlag(DC_Table $dc)
    {
        Database::getInstance()
            ->prepare("UPDATE tl_calendar_events SET pnSent = 0 WHERE id = ?")
            ->execute($dc->id);
        $row = Database::getInstance()
            ->prepare("SELECT * FROM tl_calendar_events WHERE id = ?")
            ->execute($dc->id)->fetchAssoc();
        Controller::redirect('contao?do=calendar&table=tl_calendar_events&id=' . $row['pid']);
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