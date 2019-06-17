<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    6
 * @author  	con4gis contributors (see "authors.txt")
 * @license 	LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

namespace con4gis\PwaBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use con4gis\CoreBundle\Entity\BaseEntity;

/**
 * Class PushSubscription
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_c4g_push_subscription")
 * @package con4gis\PwaBundle\Entity
 */
class PushSubscription extends BaseEntity
{
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
    private $endpoint = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $authKey = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $p256dhKey = "";
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $typeId = 0;
    
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
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }
    
    /**
     * @param string $endpoint
     */
    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }
    
    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->authKey;
    }
    
    /**
     * @param string $authKey
     */
    public function setAuthKey(string $authKey): void
    {
        $this->authKey = $authKey;
    }
    
    /**
     * @return string
     */
    public function getP256dhKey(): string
    {
        return $this->p256dhKey;
    }
    
    /**
     * @param string $p256dhKey
     */
    public function setP256dhKey(string $p256dhKey): void
    {
        $this->p256dhKey = $p256dhKey;
    }
    
    /**
     * @return int
     */
    public function getTypeId(): int
    {
        return $this->typeId;
    }
    
    /**
     * @param int $typeId
     */
    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }
}