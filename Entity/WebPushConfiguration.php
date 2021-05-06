<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2021, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */

namespace con4gis\PwaBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use con4gis\CoreBundle\Entity\BaseEntity;

/**
 * Class WebPushConfiguration
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_c4g_webpush_configuration")
 * @ORM\Entity(repositoryClass="con4gis\PwaBundle\Entity\WebPushConfigurationRepository")
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
     * @var int
     * @ORM\Column(type="integer", options={"default":0})
     */
    protected $importId = 0;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name = "";
    
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
    private $batchSize = 1000;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $timeout = 0;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $icon = null;
    
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
     * @return int
     */
    public function getimportId(): int
    {
        return $this->importId;
    }

    /**
     * @param int $importId
     */
    public function setImportId(int $importId): void
    {
        $this->importId = $importId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
    public function getBatchSize(): int
    {
        return $this->batchSize;
    }

    /**
     * @param int $batchSize
     */
    public function setBatchSize(int $batchSize): void
    {
        $this->batchSize = $batchSize;
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
    
    /**
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }
    
    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }
    
}