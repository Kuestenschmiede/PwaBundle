<?php


namespace con4gis\PwaBundle\Classes\Events;

use Symfony\Component\EventDispatcher\Event;

class PushNotificationEvent extends Event
{
    const NAME = 'con4gis.notification.send';
    
    /**
     * Ids of the subscriptions to which the message should be sent.
     * @var array
     */
    private $endpoints = [];
    
    /**
     * If this is true, the $endpoints property will be ignored and the notification will be sent to every subscriber.
     * @var bool
     */
    private $sendToAll = false;
    
    /**
     * The subscription entities.
     * @var array
     */
    private $subscriptions = [];
    
    /**
     * Title of the notification
     * @var string
     */
    private $title = "";
    
    /**
     * Content of the notification
     * @var string
     */
    private $message = "";
    
    /**
     * @return array
     */
    public function getEndpoints(): array
    {
        return $this->endpoints;
    }
    
    /**
     * @param array $endpoints
     */
    public function setEndpoints(array $endpoints): void
    {
        $this->endpoints = $endpoints;
    }
    
    /**
     * @return bool
     */
    public function isSendToAll(): bool
    {
        return $this->sendToAll;
    }
    
    /**
     * @param bool $sendToAll
     */
    public function setSendToAll(bool $sendToAll): void
    {
        $this->sendToAll = $sendToAll;
    }
    
    /**
     * @return array
     */
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }
    
    /**
     * @param array $subscriptions
     */
    public function setSubscriptions(array $subscriptions): void
    {
        $this->subscriptions = $subscriptions;
    }
    
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    
    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
    
    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}