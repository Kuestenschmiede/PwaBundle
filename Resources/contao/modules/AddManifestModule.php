<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 20.03.19
 * Time: 16:45
 */

namespace con4gis\PwaBundle\Resources\contao\modules;


use con4gis\PwaBundle\Entity\PwaConfiguration;
use Contao\FilesModel;
use Contao\Module;
use Contao\System;

class AddManifestModule extends Module
{
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            
            $objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['pwa'][0].' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->title;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            
            return $objTemplate->parse();
        }
        return parent::generate();
    }
    
    protected function compile()
    {
        // add manifest entry
        $GLOBALS['TL_HEAD'][] = '<link rel="manifest" href="manifest.webmanifest">';
        $this->addAppleTouchIcons();
        $this->addAppleSplashScreen();
        // register service worker
        $GLOBALS['TL_HEAD'][] = '<script>
          if (\'serviceWorker\' in navigator) {
            navigator.serviceWorker.register("./sw.js")
              .catch(err => console.log(err));
          }
        </script>';
    }
    
    /**
     * Adds the required link tags to load the apple touch icons.
     * iOS does not load icons via the manifest file yet.
     */
    public function addAppleTouchIcons()
    {
        $configId = $this->pwaConfiguration;
        $config = System::getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository(PwaConfiguration::class)
            ->findOneBy(['id' => $configId]);
        if ($config instanceof PwaConfiguration) {
            $apple120Icon = FilesModel::findByUuid($config->getAppleIcon120());
            $apple152Icon = FilesModel::findByUuid($config->getAppleIcon152());
            $apple180Icon = FilesModel::findByUuid($config->getAppleIcon180());
            $apple167Icon = FilesModel::findByUuid($config->getAppleIcon167());
            
            $GLOBALS['TL_HEAD'][] = '<meta name="apple-mobile-web-app-capable" content="yes">';
            $GLOBALS['TL_HEAD'][] = '<meta name="apple-mobile-web-app-status-bar-style" content="#ff0000">';
            $GLOBALS['TL_HEAD'][] = '<meta name="apple-mobile-web-app-title" content="Test App">';
            if ($apple120Icon) {
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-icon" sizes="120x120" href="' . $apple120Icon->path . '">';
            }
            if ($apple152Icon) {
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-icon" sizes="152x152" href="' . $apple152Icon->path . '">';
            }
            if ($apple167Icon) {
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-icon" sizes="167x167" href="' . $apple167Icon->path . '">';
            }
            if ($apple180Icon) {
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-icon" href="' . $apple180Icon->path . '">';
            }
        }
    }
    
    /**
     * Loads the required icons/tags to implement a splash screen on iOS.
     */
    public function addAppleSplashScreen()
    {
        $configId = $this->pwaConfiguration;
        $config = System::getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository(PwaConfiguration::class)
            ->findOneBy(['id' => $configId]);
        if ($config instanceof PwaConfiguration) {
            $firstSplash = FilesModel::findByUuid($config->getSplashIphoneFirst());
            $secondSplash = FilesModel::findByUuid($config->getSplashIphoneSecond());
            $thirdSplash = FilesModel::findByUuid($config->getSplashIphoneThird());
            $fourthSplash = FilesModel::findByUuid($config->getSplashIphoneFourth());
            $fifthSplash = FilesModel::findByUuid($config->getSplashIpadFirst());
            $sixthSplash = FilesModel::findByUuid($config->getSplashIpadSecond());
            $seventhSplash = FilesModel::findByUuid($config->getSplashIphoneThird());
    
            if ($firstSplash) {
                // iPhone X (1125px x 2436px)
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/' . $firstSplash->path . '">';
            }
            if ($secondSplash) {
                // iPhone 8, 7, 6s, 6 (750px x 1334px)
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/' . $secondSplash->path . '">';
            }
            if ($thirdSplash) {
                // iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus (1242px x 2208px)
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)" href="/' . $thirdSplash->path . '">';
            }
            if ($fourthSplash) {
                // iPhone 5 (640px x 1136px)
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)" href="/' . $fourthSplash->path . '">';
            }
            if ($fifthSplash) {
                // iPad Mini, Air (1536px x 2048px)
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" media="(min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)" href="/' . $fifthSplash->path . '">';
            }
            if ($sixthSplash) {
                // iPad Pro 10.5" (1668px x 2224px)
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" media="(min-device-width: 834px) and (max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)" href="/' . $sixthSplash->path . '">';
            }
            if ($seventhSplash) {
                // iPad Pro 12.9" (2048px x 2732px)
                $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)" href="/' . $seventhSplash->path . '">';
            }
        }
    }
    
}