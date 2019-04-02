<?php

namespace con4gis\PwaBundle\Controller;

use con4gis\CoreBundle\Controller\BaseController;
use con4gis\PwaBundle\Entity\PushSubscription;
use Contao\System;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PushController extends AbstractController
{
    
    // TODO entityManager vernünftig injecten
    
    public function getPublicKeyAction(Request $request)
    {
    
    }
    
    /**
     * @Route("/con4gis/pushSubscription", name="createPushSubscription", methods={"POST"})
     * @param $request
     * @return JsonResponse
     */
    public function createSubscription(Request $request)
    {
        $this->container->get('contao.framework')->initialize();
        $entityManager = System::getContainer()->get('doctrine.orm.default_entity_manager');
        $arrData = $request->request->all();
        $endpoint = $arrData['endpoint'];
        $subsRepo = $entityManager->getRepository(PushSubscription::class);
        if ($subsRepo->findOneBy(['endpoint' => $endpoint]) === null) {
            // subscription is new, persist it
            $subscription = new PushSubscription();
            $subscription->setEndpoint($endpoint);
            $subscription->setAuthKey($arrData['keys']['auth']);
            $subscription->setP256dhKey($arrData['keys']['p256dh']);
            $subscription->setTstamp(time());
            try {
                $entityManager->persist($subscription);
                $entityManager->flush();
            } catch (ORMException $exception) {
                // TODO handle exception
                return new JsonResponse([], 500);
            }
        }
        return new JsonResponse([]);
    }
    
    public function updateSubscriptionAction(Request $request)
    {
    
    }
    
    /**
     * @Route("/con4gis/pushSubscription", name="deleteSubscriptionAction", methods={"DELETE"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteSubscriptionAction(Request $request)
    {
        $this->container->get('contao.framework')->initialize();
        /** @var EntityManager $entityManager */
        $entityManager = System::getContainer()->get('doctrine.orm.default_entity_manager');
        $arrData = $request->request->all();
        $endpoint = $arrData['endpoint'];
        $subscription = $entityManager->getRepository(PushSubscription::class)
            ->findOneBy(['endpoint' => $endpoint]);
        try {
            $entityManager->remove($subscription);
            $entityManager->flush();
        } catch (ORMException $exception) {
            // TODO catch exception
        }
        return new JsonResponse([]);
        
    }
}