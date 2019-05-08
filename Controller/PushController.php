<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package   	con4gis
 * @version    6
 * @author  	con4gis contributors (see "authors.txt")
 * @license 	LGPL-3.0-or-later
 * @copyright 	Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

namespace con4gis\PwaBundle\Controller;

use con4gis\CoreBundle\Controller\BaseController;
use con4gis\PwaBundle\Entity\PushSubscription;
use Contao\System;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PushController extends AbstractController
{
    /**
     * @Route("/con4gis/pushSubscription/getKey", name="getPushPublicKey", methods={"GET"})
     * @param $request
     * @return JsonResponse
     */
    public function getPublicKeyAction(Request $request)
    {
        $this->container->get('contao.framework')->initialize();
        $container = System::getContainer();
        $publicKey = $container->getParameter('minishlink_web_push.auth')['VAPID']['publicKey'];
        return new JsonResponse(['key' => $publicKey]);
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
        if ($subscription) {
            try {
                $entityManager->remove($subscription);
                $entityManager->flush();
            } catch (ORMException $exception) {
                // TODO catch exception
            }
        }
        return new JsonResponse([]);
        
    }
}