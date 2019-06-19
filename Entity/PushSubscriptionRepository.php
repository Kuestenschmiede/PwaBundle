<?php


namespace con4gis\PwaBundle\Entity;


use Doctrine\ORM\EntityRepository;

class PushSubscriptionRepository extends EntityRepository
{
    public function findByTypes(array $typeIds)
    {
        $result = [];
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select("ps")
            ->from('con4gisPwaBundle:PushSubscription', 'ps')
            ->where($qb->expr()->like('ps.types', ':typeParam'))
            ->getQuery();
        foreach ($typeIds as $typeId) {
//            $query = $em->createQuery('SELECT u FROM MyProject\Model\User u WHERE u.age > 20');
//            $users = $query->getResult();
//            $query = $this->getEntityManager()
//                ->createQuery('SELECT ps FROM con4gisPwaBundle:PushSubscription ps WHERE ps.types LIKE :fotze');
            $query->setParameter("typeParam", '%' . ':":'. $typeId . '"' . '%');
            $query->execute();
//            $sql = $query->getSQL();
//
//            $connection = $this->getEntityManager()->getConnection();
//            $connection->
            
            $tmpResult = $query->getArrayResult();
            if ($tmpResult && count($tmpResult) > 0) {
                $result = array_merge($tmpResult);
            }
        }
        return $result;
    }
}