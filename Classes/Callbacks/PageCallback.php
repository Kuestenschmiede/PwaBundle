<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 21.03.19
 * Time: 14:22
 */

namespace con4gis\PwaBundle\Classes\Callbacks;


use con4gis\PwaBundle\Entity\PwaConfiguration;
use Contao\Backend;
use Contao\DataContainer;
use Contao\System;

class PageCallback extends Backend
{
    public function createServiceWorker(DataContainer $dc)
    {
        // check if pwa is enabled
        if ($dc->activeRecord->pwaConfig > 0) {
            $config = System::getContainer()->get('doctrine.orm.default_entity_manager')
                ->getRepository(PwaConfiguration::class)
                ->findOneBy(['id' => $dc->activeRecord->pwaConfig]);
            if ($config) {
                $manifestService = System::getContainer()->get('con4gis_pwa_manifest');
                $serviceWorkerService = System::getContainer()->get('con4gis_pwa_service_worker');
                $manifestService->createManifestFile($config);
                $serviceWorkerService->createServiceWorker($config, \PageModel::findByPk($dc->activeRecord->id));
            }
        }
    }
    
    public function getPwaConfigOptions(DataContainer $dc)
    {
        $configs = System::getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository(PwaConfiguration::class)
            ->findAll();
        $options = [];
        
        foreach ($configs as $config) {
            $options[$config->getId()] = $config->getName();
        }
        
        return $options;
    }
}