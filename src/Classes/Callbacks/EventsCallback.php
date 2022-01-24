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
use Contao\CalendarEventsModel;
use Contao\CalendarModel;
use Contao\Controller;
use Contao\Database;
use Contao\DataContainer;
use Contao\DC_Table;
use Contao\Message;
use Contao\StringUtil;
use Contao\System;

class EventsCallback extends Backend
{
    public function sendPushNotification(DataContainer $dc)
    {
        $activeRecord = $dc->activeRecord;
        $pid = $activeRecord->pid;
        //$calendar = CalendarModel::findByPk($pid);
        $url = Controller::replaceInsertTags('{{event_url::' . $activeRecord->id . '}}');
        if ($activeRecord->url) {
            $url = $activeRecord->url;
        }

        $currentTime = time();
        if ($activeRecord->published
            && (!$activeRecord->start || ($currentTime >= $activeRecord->start))
            && (!$activeRecord->stop || ($currentTime <= $activeRecord->stop))
        ) {
            if ($activeRecord->pushOnPublish) {
                if (!$activeRecord->pnSent) {
                    $event = new PushNotificationEvent();
                    $event->setSubscriptionTypes(StringUtil::deserialize($activeRecord->subscriptionTypes, true));
                    $event->setTitle($activeRecord->title);
                    $event->setMessage(strip_tags($activeRecord->teaser));
                    if ($url) {
                        $event->setClickUrl($url);
                    }
                    System::getContainer()->get('event_dispatcher')->dispatch($event, $event::NAME);
                    Database::getInstance()->prepare('UPDATE tl_calendar_events SET pnSent = 1 WHERE id = ?')
                        ->execute($activeRecord->id);
                }
            }

            if ($activeRecord->sendDoublePn) {
                $sendTime = $activeRecord->pnSendDate;

                if (!is_int($sendTime)) {
                    // date string
                    $sendTime = strtotime($sendTime);
                }

                if ($sendTime <= $currentTime && !($activeRecord->pnSent > 0)) {
                    // send at date but also now on publish
                    // do not set pnSent flag so the cronjob triggers regularly
                    $event = new PushNotificationEvent();
                    $event->setSubscriptionTypes(\Contao\StringUtil::deserialize($activeRecord->subscriptionTypes) ?: []);
                    $event->setTitle($activeRecord->title);
                    $event->setMessage(strip_tags($activeRecord->teaser));
                    if ($url) {
                        $event->setClickUrl($url);
                    }
                    System::getContainer()->get('event_dispatcher')->dispatch($event, $event::NAME);
                    Database::getInstance()->prepare('UPDATE tl_calendar_events SET pnSent = 2 WHERE id = ?')
                        ->execute($activeRecord->id);
                }
            }
        }
    }

    /**
     * Sends a push notification for the event and ignores the pnSent flag, and does not update it either.
     * @param DC_Table $dc
     */
    public function forceSendPn(DC_Table $dc)
    {
        $calendarEvent = CalendarEventsModel::findByPk($dc->id);
        $currentTime = time();

        if ($calendarEvent->published
            && (!$calendarEvent->start || ($currentTime >= $calendarEvent->start))
            && (!$calendarEvent->stop || ($currentTime <= $calendarEvent->stop))
        ) {
            $pid = $calendarEvent->pid;
            $url = Controller::replaceInsertTags('{{event::' . $calendarEvent->id . '}}');
            if ($calendarEvent->url) {
                $url = $calendarEvent->url;
            }
            $event = new PushNotificationEvent();
            $subscriptionTypes = \Contao\StringUtil::deserialize($calendarEvent->subscriptionTypes) ?: [];
            $event->setSubscriptionTypes($subscriptionTypes);
            $event->setTitle($calendarEvent->title);
            $event->setMessage(strip_tags($calendarEvent->teaser));

            //ToDo ask for url selection
            if ($url) {
                $event->setClickUrl($url);
            }
            if (count($subscriptionTypes) > 0) {
                System::getContainer()->get('event_dispatcher')->dispatch($event, $event::NAME);
                Message::addInfo('Es wurde eine Pushnachricht für das Event "' . $calendarEvent->title . '" versendet.');
            } else {
                Message::addInfo('Es wurde keine Pushnachricht für das Event "' . $calendarEvent->title . '" versendet, da keine Abonnement-Typen ausgewählt sind, an die die Nachricht gesendet werden könnte.');
            }

            Controller::redirect('contao?do=calendar&table=tl_calendar_events&id=' . $calendarEvent->pid);
        }
    }

    /**
     * Resets the pnSent flag.
     * @param DC_Table $dc
     */
    public function resetPnSentFlag(DC_Table $dc)
    {
        Database::getInstance()
            ->prepare('UPDATE tl_calendar_events SET pnSent = 0 WHERE id = ?')
            ->execute($dc->id);
        $row = Database::getInstance()
            ->prepare('SELECT * FROM tl_calendar_events WHERE id = ?')
            ->execute($dc->id)->fetchAssoc();
        Controller::redirect('contao?do=calendar&table=tl_calendar_events&id=' . $row['pid']);
    }

    public function convertDateStringToTimeStamp($value, $dc)
    {
        if (is_int($value)) {
            return $value;
        }

        return strtotime($value);
    }

    public function convertTimeStampToDateString($value, $dc)
    {
        return date($GLOBALS['TL_CONFIG']['datimFormat'], $value);
    }
}
