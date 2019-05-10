<?php


namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use Contao\Controller;
use Contao\Database;
use Contao\DataContainer;
use Contao\System;

class PushNotificationCallback
{
    public function sendNotification(DataContainer $dc)
    {
        $title = $dc->activeRecord->messageTitle;
        $content = $dc->activeRecord->messageContent;
        $eventDispatcher = System::getContainer()->get('event_dispatcher');
        $event = new PushNotificationEvent();
        $event->setSendToAll(true);
        $event->setTitle($title);
        $event->setMessage($content);
        $eventDispatcher->dispatch($event::NAME, $event);
        Controller::redirect("/contao?do=sendPush");
    }
    
    public function truncateTable(DataContainer $dc)
    {
        Database::getInstance()->prepare("DELETE FROM tl_c4g_push_notification WHERE 1=1")->execute();
    }
}