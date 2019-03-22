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
        // TODO geht aktuell nur eine ebene tief
        $childPages = PageModel::findPublishedByPid($pageRoot->id);
        $arrPagenames = [];
        foreach ($childPages as $childPage) {
            // TODO Abfragen, ob html Suffix angehängt werden muss oder nicht
            $arrPagenames[] = $childPage->alias . ".html";
        }
        $version = 1;
        $cacheName = 'pwa-con4gis-v' . $version;
        $this->createServiceWorkerFile($arrPagenames, $cacheName);
    }
    
    private function createServiceWorkerFile($arrPages, $cacheName)
    {
        $writer = new ServiceWorkerFileWriter();
        $writer->createServiceWorkerFile($arrPages, $cacheName, $this->webPath);
    }
}