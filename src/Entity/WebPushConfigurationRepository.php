<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @author con4gis contributors (see "authors.md")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2026, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */

namespace con4gis\PwaBundle\Entity;


use Doctrine\ORM\EntityRepository;

class WebPushConfigurationRepository extends EntityRepository
{
    public function findOnly()
    {
        $arrEntities =  $this->getEntityManager()
            ->createQuery("SELECT wc FROM con4gisPwaBundle:WebPushConfiguration wc")
            ->setMaxResults(1)
            ->getResult();
        if ($arrEntities && count($arrEntities) > 0) {
            return $arrEntities[0];
        } else {
            return null;
        }
    }
}