<?php


namespace con4gis\PwaBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use con4gis\CoreBundle\Entity\BaseEntity;

/**
 * Class PushSubscriptionType
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_c4g_push_subscription_type")
 * @package con4gis\PwaBundle\Entity
 */
class PushSubscriptionType extends BaseEntity
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
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $pushConfig = 0;
    
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
     * @return int
     */
    public function getPushConfig(): int
    {
        return $this->pushConfig;
    }

    /**
     * @param int $pushConfig
     */
    public function setPushConfig(int $pushConfig): void
    {
        $this->pushConfig = $pushConfig;
    }
}