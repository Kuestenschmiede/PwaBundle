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
            
            $objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['FMD']['pwa'][0] . ' ###';
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
        $configId = $this->pwaConfiguration;
        $config = System::getContainer()->get('doctrine.orm.entity_manager')
            ->getRepository(PwaConfiguration::class)
            ->findOneBy(['id' => $configId]);
        if ($config instanceof PwaConfiguration) {
            $this->addAppleTouchIcons($config);
            $this->addAppleSplashScreen($config);
            $GLOBALS['TL_HEAD'][] = '<meta name="theme-color" content="#' . $config->getThemeColor() . '">';
        }
        // if jquery is not loaded by contao, load it
        if (!in_array('assets/jquery/js/jquery.min.js|static', $GLOBALS['TL_JAVASCRIPT'])) {
            $GLOBALS['TL_JAVASCRIPT'][] = 'assets/jquery/js/jquery.min.js|static';
        }
        // register service worker
        $GLOBALS['TL_HEAD'][] = '<script>
          if (\'serviceWorker\' in navigator) {
            navigator.serviceWorker.register("./sw.js")
              .catch(err => console.log(err));
          }
        </script>';
        
        // check for cron call
        if ($this->cronActivation) {
            $GLOBALS['TL_BODY'][] = '<script>jQuery.ajax("/_contao/cron");</script>';
        }
    }
    
    /**
     * Adds the required link tags to load the apple touch icons.
     * iOS does not load icons via the manifest file yet.
     * @param PwaConfiguration $config
     */
    public function addAppleTouchIcons(PwaConfiguration $config)
    {
        $apple120Icon = FilesModel::findByUuid($config->getAppleIcon120());
        $apple152Icon = FilesModel::findByUuid($config->getAppleIcon152());
        $apple180Icon = FilesModel::findByUuid($config->getAppleIcon180());
        $apple167Icon = FilesModel::findByUuid($config->getAppleIcon167());
        
        $GLOBALS['TL_HEAD'][] = '<meta name="apple-mobile-web-app-capable" content="yes">';
        $GLOBALS['TL_HEAD'][] = '<meta name="apple-mobile-web-app-status-bar-style" content="' . $config->getIosStyle() . '">';
        $GLOBALS['TL_HEAD'][] = '<meta name="apple-mobile-web-app-title" content="' . $config->getName() . '">';
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
    
    /**
     * Loads the required icons/tags to implement a splash screen on iOS.
     * @param PwaConfiguration $config
     */
    public function addAppleSplashScreen(PwaConfiguration $config)
    {
        $firstSplash = FilesModel::findByUuid($config->getSplashIphoneFirst());
        $secondSplash = FilesModel::findByUuid($config->getSplashIphoneSecond());
        $thirdSplash = FilesModel::findByUuid($config->getSplashIphoneThird());
        $fourthSplash = FilesModel::findByUuid($config->getSplashIphoneFourth());
        $fifthSplash = FilesModel::findByUuid($config->getSplashIpadFirst());
        $sixthSplash = FilesModel::findByUuid($config->getSplashIpadSecond());
        $seventhSplash = FilesModel::findByUuid($config->getSplashIphoneThird());
        
        if ($firstSplash) {
            // iPhone X (1125px x 2436px)
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" href="' . $firstSplash->path . '" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">';
        }
        if ($secondSplash) {
            // iPhone 8, 7, 6s, 6 (750px x 1334px)
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" href="' . $secondSplash->path . '" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
        }
        if ($thirdSplash) {
            // iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus (1242px x 2208px)
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" href="' . $thirdSplash->path . '" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">';
        }
        if ($fourthSplash) {
            // iPhone 5 (640px x 1136px)
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" href="' . $fourthSplash->path . '" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
        }
        if ($fifthSplash) {
            // iPad Mini, Air (1536px x 2048px)
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" href="' . $fifthSplash->path . '" media="(min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">';
        }
        if ($sixthSplash) {
            // iPad Pro 10.5" (1668px x 2224px)
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" href="' . $sixthSplash->path . '" media="(min-device-width: 834px) and (max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">';
        }
        if ($seventhSplash) {
            // iPad Pro 12.9" (2048px x 2732px)
            $GLOBALS['TL_HEAD'][] = '<link rel="apple-touch-startup-image" href="' . $seventhSplash->path . '" media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">';
        }
    }
    
}