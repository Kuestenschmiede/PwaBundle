<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    7
 * @author  	con4gis contributors (see "authors.txt")
 * @license 	LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
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
    const PWA_UPDATEVIACACHE_IMPORTS = 'imports';
    const PWA_UPDATEVIACACHE_ALL = 'all';
    const PWA_UPDATEVIACACHE_NONE = 'none';

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
    
    const PWA_OFFLINE_HANDLING_ALWAYS = 1;
    const PWA_OFFLINE_HANDLING_FALLBACK = 2;
    
    const PWA_IOS_STYLE_BLACK = 'black';
    const PWA_IOS_STYLE_DEFAULT = 'default';
    
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
     * @ORM\Column(type="string")
     */
    private $startUrl = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $scope = "";

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $updateViaCache = "imports";

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $icon192 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $icon512 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $maskableIcon = null;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $maskableIconSize = "";
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $additionalUrls = "";
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $blockedUrls = "";
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $iosStyle = "";
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $appleIcon120 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $appleIcon152 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $appleIcon180 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $appleIcon167 = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $splashIphoneFirst = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $splashIphoneSecond = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $splashIphoneThird = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $splashIphoneFourth = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $splashIpadFirst = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $splashIpadSecond = null;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
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
    public function getStartUrl(): string
    {
        return $this->startUrl;
    }
    
    /**
     * @param string $startUrl
     */
    public function setStartUrl(string $startUrl): void
    {
        $this->startUrl = $startUrl;
    }
    
    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }
    
    /**
     * @param string $scope
     */
    public function setScope(string $scope): void
    {
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getUpdateViaCache(): string
    {
        return $this->updateViaCache;
    }

    /**
     * @param string $updateViaCache
     */
    public function setUpdateViaCache(string $updateViaCache): void
    {
        $this->updateViaCache = $updateViaCache;
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
     * @return string
     */
    public function getMaskableIcon(): ?string
    {
        return $this->maskableIcon;
    }
    
    /**
     * @param string $maskableIcon
     */
    public function setMaskableIcon(?string $maskableIcon): void
    {
        $this->maskableIcon = $maskableIcon;
    }
    
    /**
     * @return string
     */
    public function getMaskableIconSize(): string
    {
        return $this->maskableIconSize;
    }
    
    /**
     * @param string $maskableIconSize
     */
    public function setMaskableIconSize(string $maskableIconSize): void
    {
        $this->maskableIconSize = $maskableIconSize;
    }
    
    /**
     * @return string
     */
    public function getAdditionalUrls(): string
    {
        return $this->additionalUrls;
    }
    
    /**
     * @param string $additionalUrls
     */
    public function setAdditionalUrls(string $additionalUrls): void
    {
        $this->additionalUrls = $additionalUrls;
    }
    
    /**
     * @return string
     */
    public function getBlockedUrls(): string
    {
        return $this->blockedUrls;
    }
    
    /**
     * @param string $blockedUrls
     */
    public function setBlockedUrls(string $blockedUrls): void
    {
        $this->blockedUrls = $blockedUrls;
    }
    
    /**
     * @return string
     */
    public function getAppleIcon120(): ?string
    {
        return $this->appleIcon120;
    }
    
    /**
     * @return string
     */
    public function getIosStyle(): string
    {
        return $this->iosStyle;
    }
    
    /**
     * @param string $iosStyle
     */
    public function setIosStyle(string $iosStyle): void
    {
        $this->iosStyle = $iosStyle;
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
    public function getAppleIcon152(): ?string
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
    public function getAppleIcon180(): ?string
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
    public function getAppleIcon167(): ?string
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
    public function getSplashIphoneFirst(): ?string
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
    public function getSplashIphoneSecond(): ?string
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
    public function getSplashIphoneThird(): ?string
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
    public function getSplashIphoneFourth(): ?string
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
    public function getSplashIpadFirst(): ?string
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
    public function getSplashIpadSecond(): ?string
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
    public function getSplashIpadThird(): ?string
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