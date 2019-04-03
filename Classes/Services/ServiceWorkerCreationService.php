<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 21.03.19
 * Time: 14:06
 */

namespace con4gis\PwaBundle\Classes\Services;


use con4gis\PwaBundle\Classes\ServiceWorker\ServiceWorkerFileWriter;
use con4gis\PwaBundle\Entity\PwaConfiguration;
use Contao\PageModel;

class ServiceWorkerCreationService
{
    private $webPath = "";
    
    /**
     * ServiceWorkerCreationService constructor.
     * @param string $webPath
     */
    public function __construct(string $webPath)
    {
        $this->webPath = $webPath;
    }
    
    public function createServiceWorker(PwaConfiguration $pwaConfiguration, PageModel $pageRoot)
    {
        // TODO check if .html needs to be appended, set to empty string if not
        $suffix = ".html";
        // TODO geht aktuell nur eine ebene tief
        $childPages = PageModel::findPublishedByPid($pageRoot->id);
        $arrPagenames = [];
        if ($pwaConfiguration->getOfflinePage()) {
            $offlinePage = PageModel::findById($pwaConfiguration->getOfflinePage());
            $arrPagenames[] = $offlinePage->alias . $suffix;
        } else {
            // cache all pages except the exceptions
            $pageIds = unserialize($pageRoot->uncachedPages);
            foreach ($childPages as $childPage) {
                if (!in_array($childPage->id, $pageIds)) {
                    $arrPagenames[] = $childPage->alias . $suffix;
                }
            }
        }
        $version = 1;
        $cacheName = 'pwa-con4gis-v' . $version;
        $this->createServiceWorkerFile($arrPagenames, $cacheName, $pwaConfiguration->getOfflinePage() ? $offlinePage->alias . $suffix : "");
    }
    
    private function createServiceWorkerFile($arrPages, $cacheName, $strOfflinePage)
    {
        $writer = new ServiceWorkerFileWriter();
        $writer->createServiceWorkerFile($arrPages, $cacheName, $this->webPath, $strOfflinePage);
    }
}