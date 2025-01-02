<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 10
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2025, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
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
