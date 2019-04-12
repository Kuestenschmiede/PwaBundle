<?php


namespace con4gis\PwaBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use con4gis\CoreBundle\Entity\BaseEntity;

/**
 * Class WebPushConfiguration
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_c4g_webpush_configuration")
 * @package con4gis\PwaBundle\Entity
 */
class WebPushConfiguration extends BaseEntity
{
    const URGENCY_VERY_LOW = 'very-low';
    const URGENCY_LOW = 'low';
    const URGENCY_NORMAL = 'normal';
    const URGENCY_HIGH = 'high';
    
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id = 0;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $tstamp = 0;
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $vapidSubject = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $vapidPublickey = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $vapidPrivatekey = "";
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $ttl = 0;
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $urgency = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $topic = "";
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $timeout = 0;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    /**
     * @return int
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }
    
    /**
     * @param int $tstamp
     */
    public function setTstamp(int $tstamp): void
    {
        $this->tstamp = $tstamp;
    }
    
    /**
     * @return string
     */
    public function getVapidSubject(): string
    {
        return $this->vapidSubject;
    }
    
    /**
     * @param string $vapidSubject
     */
    public function setVapidSubject(string $vapidSubject): void
    {
        $this->vapidSubject = $vapidSubject;
    }
    
    /**
     * @return string
     */
    public function getVapidPublickey(): string
    {
        return $this->vapidPublickey;
    }
    
    /**
     * @param string $vapidPublickey
     */
    public function setVapidPublickey(string $vapidPublickey): void
    {
        $this->vapidPublickey = $vapidPublickey;
    }
    
    /**
     * @return string
     */
    public function getVapidPrivatekey(): string
    {
        return $this->vapidPrivatekey;
    }
    
    /**
     * @param string $vapidPrivatekey
     */
    public function setVapidPrivatekey(string $vapidPrivatekey): void
    {
        $this->vapidPrivatekey = $vapidPrivatekey;
    }
    
    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }
    
    /**
     * @param int $ttl
     */
    public function setTtl(int $ttl): void
    {
        $this->ttl = $ttl;
    }
    
    /**
     * @return string
     */
    public function getUrgency(): string
    {
        return $this->urgency;
    }
    
    /**
     * @param string $urgency
     */
    public function setUrgency(string $urgency): void
    {
        $this->urgency = $urgency;
    }
    
    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }
    
    /**
     * @param string $topic
     */
    public function setTopic(string $topic): void
    {
        $this->topic = $topic;
    }
    
    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }
    
    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }
}