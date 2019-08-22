<?php


namespace con4gis\PwaBundle\Classes\Callbacks;

use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use con4gis\PwaBundle\Entity\PushSubscriptionType;
use Contao\Backend;
use Contao\Controller;
use Contao\Database;
use Contao\DataContainer;
use Contao\System;

class PushNotificationCallback extends Backend
{
    public function sendNotification(DataContainer $dc)
    {
        $title = $dc->activeRecord->messageTitle;
        $content = $dc->activeRecord->messageContent;
        $eventDispatcher = System::getContainer()->get('event_dispatcher');
        $event = new PushNotificationEvent();
        $event->setSubscriptionTypes(unserialize($dc->activeRecord->subscriptionTypes) ?: []);
        $event->setTitle($title);
        $event->setMessage($content);
        $eventDispatcher->dispatch($event::NAME, $event);
        Controller::redirect("/contao?do=sendPush");
    }
    
    public function truncateTable(DataContainer $dc)
    {
        Database::getInstance()->prepare("DELETE FROM tl_c4g_push_notification WHERE 1=1")->execute();
    }
    
    public function loadDataset()
    {
        $objConfig = \Database::getInstance()->prepare("SELECT id FROM tl_c4g_push_notification")->execute();
        
        if (\Input::get('key')) return;
        
        if(!$objConfig->numRows && !\Input::get('act'))
        {
            $this->redirect($this->addToUrl('act=create'));
        }
        
        if(!\Input::get('id') && !\Input::get('act'))
        {
            $GLOBALS['TL_DCA']['tl_c4g_push_notification']['config']['notCreatable'] = true;
            $this->redirect($this->addToUrl('act=edit&id='.$objConfig->id));
        }
        
        \Message::addInfo($GLOBALS['TL_LANG']['tl_c4g_push_notification']['infoText']);
    }
    
    public function getSubscriptionTypes()
    {
        $em = System::getContainer()->get('doctrine.orm.default_entity_manager');
        $typeRepo = $em->getRepository(PushSubscriptionType::class);
        $types = $typeRepo->findAll();
        $arrTypes = [];
        foreach ($types as $type) {
            $arrTypes[$type->getId()] = $type->getName();
        }

        return $arrTypes;
    }
}