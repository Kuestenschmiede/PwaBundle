<?php


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