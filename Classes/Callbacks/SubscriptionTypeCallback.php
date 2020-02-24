<?php

namespace con4gis\PwaBundle\Classes\Callbacks;

use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\Backend;
use Contao\DataContainer;
use Contao\System;

class SubscriptionTypeCallback extends Backend
{
    public function getPushConfigOptions(DataContainer $dc)
    {
        $configs = System::getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository(WebPushConfiguration::class)
            ->findAll();
        $options = [];

        foreach ($configs as $config) {
            $options[$config->getId()] = $config->getName();
        }

        return $options;
    }
}
