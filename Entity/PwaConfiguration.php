<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 21.03.19
 * Time: 10:47
 */

namespace con4gis\PwaBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use con4gis\CoreBundle\Entity\BaseEntity;

/**
 * Class PwaConfiguration
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_c4g_pwa_configuration")
 * @package con4gis\PwaBundle\Entity
 */
class PwaConfiguration extends BaseEntity
{
    const PWA_DISPLAY_FULLSCREEN = 1;
    const PWA_DISPLAY_STANDALONE = 2;
    const PWA_DISPLAY_MINIMAL_UI = 3;
    const PWA_DISPLAY_BROWSER    = 4;
    
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
    private $name = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $shortName = "";
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $display = 0;
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $backgroundColor = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $themeColor = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $description = "";
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $icon192 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $icon512 = null;
    
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
    public function getShortName(): string
    {
        return $this->shortName;
    }
    
    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName): void
    {
        $this->shortName = $shortName;
    }
    
    /**
     * @return int
     */
    public function getDisplay(): int
    {
        return $this->display;
    }
    
    /**
     * @param int $display
     */
    public function setDisplay(int $display): void
    {
        $this->display = $display;
    }
    
    /**
     * @return string
     */
    public function getBackgroundColor(): string
    {
        return $this->backgroundColor;
    }
    
    /**
     * @param string $backgroundColor
     */
    public function setBackgroundColor(string $backgroundColor): void
    {
        $this->backgroundColor = $backgroundColor;
    }
    
    /**
     * @return string
     */
    public function getThemeColor(): string
    {
        return $this->themeColor;
    }
    
    /**
     * @param string $themeColor
     */
    public function setThemeColor(string $themeColor): void
    {
        $this->themeColor = $themeColor;
    }
    
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    
    /**
     * @return string
     */
    public function getIcon192(): string
    {
        return $this->icon192;
    }
    
    /**
     * @param string $icon192
     */
    public function setIcon192(string $icon192): void
    {
        $this->icon192 = $icon192;
    }
    
    /**
     * @return string
     */
    public function getIcon512(): string
    {
        return $this->icon512;
    }
    
    /**
     * @param string $icon512
     */
    public function setIcon512(string $icon512): void
    {
        $this->icon512 = $icon512;
    }
}