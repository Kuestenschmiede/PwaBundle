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
