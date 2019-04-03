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
use Symfony\Component\DependencyInjection\Container;
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