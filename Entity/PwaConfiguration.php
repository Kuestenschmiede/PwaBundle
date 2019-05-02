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
    
    const PWA_ORIENTATION_ANY = 1;
    const PWA_ORIENTATION_NATURAL = 2;
    const PWA_ORIENTATION_LANDSCAPE = 3;
    const PWA_ORIENTATION_LANDSCAPE_PRIMARY = 4;
    const PWA_ORIENTATION_LANDSCAPE_SECONDARY = 5;
    const PWA_ORIENTATION_PORTRAIT = 6;
    const PWA_ORIENTATION_PORTRAIT_PRIMARY = 7;
    const PWA_ORIENTATION_PORTRAIT_SECONDARY = 8;
    
    const PWA_SERVICE_WORKER_GENERATE = 1;
    const PWA_SERVICE_WORKER_CUSTOM = 2;
    
    const PWA_OFFLINE_HANDLING_ALWAYS = 1;
    const PWA_OFFLINE_HANDLING_FALLBACK = 2;
    
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
     * @var int
     * @ORM\Column(type="integer")
     */
    private $orientation = 0;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $offlinePage = 0;
    
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $offlineHandling = 0;
    
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
     * @var int
     * @ORM\Column(type="integer")
     */
    private $serviceWorkerGen = 0;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $appleIcon120 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $appleIcon152 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $appleIcon180 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $appleIcon167 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $splashIphoneFirst = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $splashIphoneSecond = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $splashIphoneThird = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $splashIphoneFourth = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $splashIpadFirst = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $splashIpadSecond = null;
    
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $splashIpadThird = null;
    
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
     * @return int
     */
    public function getOrientation(): int
    {
        return $this->orientation;
    }
    
    /**
     * @param int $orientation
     */
    public function setOrientation(int $orientation): void
    {
        $this->orientation = $orientation;
    }
    
    /**
     * @return int
     */
    public function getOfflinePage(): int
    {
        return $this->offlinePage;
    }
    
    /**
     * @param int $offlinePage
     */
    public function setOfflinePage(int $offlinePage): void
    {
        $this->offlinePage = $offlinePage;
    }
    
    /**
     * @return int
     */
    public function getOfflineHandling(): int
    {
        return $this->offlineHandling;
    }
    
    /**
     * @param int $offlineHandling
     */
    public function setOfflineHandling(int $offlineHandling): void
    {
        $this->offlineHandling = $offlineHandling;
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
    
    /**
     * @return int
     */
    public function getServiceWorkerGen(): int
    {
        return $this->serviceWorkerGen;
    }
    
    /**
     * @param int $serviceWorkerGen
     */
    public function setServiceWorkerGen(int $serviceWorkerGen): void
    {
        $this->serviceWorkerGen = $serviceWorkerGen;
    }
    
    /**
     * @return string
     */
    public function getAppleIcon120(): string
    {
        return $this->appleIcon120;
    }
    
    /**
     * @param string $appleIcon120
     */
    public function setAppleIcon120(string $appleIcon120): void
    {
        $this->appleIcon120 = $appleIcon120;
    }
    
    /**
     * @return string
     */
    public function getAppleIcon152(): string
    {
        return $this->appleIcon152;
    }
    
    /**
     * @param string $appleIcon152
     */
    public function setAppleIcon152(string $appleIcon152): void
    {
        $this->appleIcon152 = $appleIcon152;
    }
    
    /**
     * @return string
     */
    public function getAppleIcon180(): string
    {
        return $this->appleIcon180;
    }
    
    /**
     * @param string $appleIcon180
     */
    public function setAppleIcon180(string $appleIcon180): void
    {
        $this->appleIcon180 = $appleIcon180;
    }
    
    /**
     * @return string
     */
    public function getAppleIcon167(): string
    {
        return $this->appleIcon167;
    }
    
    /**
     * @param string $appleIcon167
     */
    public function setAppleIcon167(string $appleIcon167): void
    {
        $this->appleIcon167 = $appleIcon167;
    }
    
    /**
     * @return string
     */
    public function getSplashIphoneFirst(): string
    {
        return $this->splashIphoneFirst;
    }
    
    /**
     * @param string $splashIphoneFirst
     */
    public function setSplashIphoneFirst(string $splashIphoneFirst): void
    {
        $this->splashIphoneFirst = $splashIphoneFirst;
    }
    
    /**
     * @return string
     */
    public function getSplashIphoneSecond(): string
    {
        return $this->splashIphoneSecond;
    }
    
    /**
     * @param string $splashIphoneSecond
     */
    public function setSplashIphoneSecond(string $splashIphoneSecond): void
    {
        $this->splashIphoneSecond = $splashIphoneSecond;
    }
    
    /**
     * @return string
     */
    public function getSplashIphoneThird(): string
    {
        return $this->splashIphoneThird;
    }
    
    /**
     * @param string $splashIphoneThird
     */
    public function setSplashIphoneThird(string $splashIphoneThird): void
    {
        $this->splashIphoneThird = $splashIphoneThird;
    }
    
    /**
     * @return string
     */
    public function getSplashIphoneFourth(): string
    {
        return $this->splashIphoneFourth;
    }
    
    /**
     * @param string $splashIphoneFourth
     */
    public function setSplashIphoneFourth(string $splashIphoneFourth): void
    {
        $this->splashIphoneFourth = $splashIphoneFourth;
    }
    
    /**
     * @return string
     */
    public function getSplashIpadFirst(): string
    {
        return $this->splashIpadFirst;
    }
    
    /**
     * @param string $splashIpadFirst
     */
    public function setSplashIpadFirst(string $splashIpadFirst): void
    {
        $this->splashIpadFirst = $splashIpadFirst;
    }
    
    /**
     * @return string
     */
    public function getSplashIpadSecond(): string
    {
        return $this->splashIpadSecond;
    }
    
    /**
     * @param string $splashIpadSecond
     */
    public function setSplashIpadSecond(string $splashIpadSecond): void
    {
        $this->splashIpadSecond = $splashIpadSecond;
    }
    
    /**
     * @return string
     */
    public function getSplashIpadThird(): string
    {
        return $this->splashIpadThird;
    }
    
    /**
     * @param string $splashIpadThird
     */
    public function setSplashIpadThird(string $splashIpadThird): void
    {
        $this->splashIpadThird = $splashIpadThird;
    }
}