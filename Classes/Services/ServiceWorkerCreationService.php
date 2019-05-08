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

namespace con4gis\PwaBundle\Classes\Services;

use con4gis\PwaBundle\Entity\PwaConfiguration;
use Contao\Database;
use Contao\PageModel;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceWorkerCreationService
{
    private $webPath = "";
    
    /**
     * @var ContainerInterface
     */
    private $container = null;
    
    /**
     * ServiceWorkerCreationService constructor.
     * @param string $webPath
     * @param ContainerInterface $container
     */
    public function __construct(string $webPath, ContainerInterface $container)
    {
        $this->webPath = $webPath;
        $this->container = $container;
    }
    
    public function createServiceWorker(PwaConfiguration $pwaConfiguration, PageModel $pageRoot)
    {
        $suffix = $this->container->getParameter('contao.url_suffix');;
        // TODO geht aktuell nur eine ebene tief
        $childPages = PageModel::findPublishedByPid($pageRoot->id);
        $arrPagenames = [];
        
        if ($pwaConfiguration->getOfflinePage()) {
            $offlinePage = PageModel::findById($pwaConfiguration->getOfflinePage());
            $arrPagenames[] = $offlinePage->alias . $suffix;
        }
        
        if(!($pwaConfiguration->getOfflinePage()) || ($pwaConfiguration->getOfflinePage() && $pwaConfiguration->getOfflineHandling() == 2)) {
            // cache all pages except the exceptions
            $pageIds = unserialize($pageRoot->uncachedPages);
            
            foreach ($childPages as $childPage) {
                if (!in_array($childPage->id, $pageIds)) {
                    $arrPagenames[] = $childPage->alias . $suffix;
                }
            }
        }
        
        $version = Database::getInstance()
            ->prepare("SELECT version FROM tl_version WHERE fromTable = 'tl_page' AND pid = ? ORDER BY tstamp DESC LIMIT 1")
            ->execute($pageRoot->id)->fetchAssoc();
        if ($version && count($version) == 1) {
            $intVersion = $version['version'];
        } else {
            $intVersion = 1;
        }
        
        // check for additional urls to cache
        if ($pwaConfiguration->getAdditionalUrls()) {
            $arrUrls = explode(',', $pwaConfiguration->getAdditionalUrls());
            $arrPagenames = array_merge($arrPagenames, $arrUrls);
        }
        
        $blockedUrls = [];
        // check for blocked urls
        if ($pwaConfiguration->getBlockedUrls()) {
            $blockedUrls = explode(",", $pwaConfiguration->getBlockedUrls());
        }
        
        $cacheName = 'pwa-con4gis-v' . $intVersion;
        $this->createServiceWorkerFile(
            $arrPagenames,
            $cacheName,
            $pwaConfiguration->getOfflinePage() ? $offlinePage->alias . $suffix : "",
            $pwaConfiguration->getOfflineHandling(),
            $blockedUrls
        );
    }
    
    private function createServiceWorkerFile($arrPages, $cacheName, $strOfflinePage, $offlineHandling, $blockedUrls)
    {
        $writer = new ServiceWorkerFileWriter();
        $writer->createServiceWorkerFile($arrPages, $cacheName, $this->webPath, $strOfflinePage, $offlineHandling, $blockedUrls);
    }
}