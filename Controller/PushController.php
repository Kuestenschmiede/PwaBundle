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
use Contao\ModuleModel;
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
     * @Route("/con4gis/pushSubscription/", name="getPushSubscription", methods={"GET"})
     * @param $request
     * @return JsonResponse
     */
    public function getSubscriptionAction(Request $request)
    {
        $data = $request->query->all();
        $endpoint = $data['endpoint'];
        if (!$endpoint) {
            return JsonResponse::create()->setStatusCode(400);
        }
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $subscription = $em->getRepository(PushSubscription::class)
            ->findOneBy(['endpoint' => $endpoint]);
        if ($subscription) {
            $response = new JsonResponse();
            $arrData = [];
            $arrData['types'] = $subscription->getTypes();
            $response->setData($arrData);
        } else {
            $response = new JsonResponse();
            $response->setStatusCode(404);
        }
        return $response;
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
        $moduleId = $arrData['moduleId'];
        $subscriptionTypes = $arrData['subscriptionTypes'];
        $subscriptionTypes = $this->checkSubscriptionPermissions(intval($moduleId), $subscriptionTypes);
        if (!$subscriptionTypes || count($subscriptionTypes) < 1) {
            return JsonResponse::create()->setStatusCode(400);
        }
        $subsRepo = $entityManager->getRepository(PushSubscription::class);
        if ($subsRepo->findOneBy(['endpoint' => $endpoint]) === null) {
            // subscription is new, persist it
            $subscription = new PushSubscription();
            $subscription->setEndpoint($endpoint);
            $subscription->setAuthKey($arrData['keys']['auth']);
            $subscription->setP256dhKey($arrData['keys']['p256dh']);
            $subscription->setTstamp(time());
            $subscription->setTypes($subscriptionTypes);
            try {
                $entityManager->persist($subscription);
                $entityManager->flush();
            } catch (ORMException $exception) {
                return new JsonResponse(["error" => "Oops, something went wrong.."], 500);
            }
        }
        return new JsonResponse([]);
    }
    
    /**
     * @Route("/con4gis/pushSubscription", name="updatePushSubscription", methods={"PUT"})
     * @param $request
     * @return JsonResponse
     */
    public function updateSubscriptionAction(Request $request)
    {
        $this->get('contao.framework')->initialize();
        $data = $request->request->all();
        $endpoint = $data['endpoint'];
        $types = $data['types'];
        $types = $this->checkSubscriptionPermissions(intval($data['moduleId']), $types);
        if ((!$endpoint || !$types) || !is_array($types)) {
            return JsonResponse::create()->setStatusCode(400);
        }
        $em = $this->get('doctrine.orm.default_entity_manager');
        $subscription = $em->getRepository(PushSubscription::class)
            ->findOneBy(['endpoint' => $endpoint]);
        if (!$subscription) {
            return JsonResponse::create()->setStatusCode(404);
        }
        $subscription->setTypes($types);
        try {
            $em->persist($subscription);
            $em->flush();
        } catch (ORMException $e) {
            return JsonResponse::create()->setStatusCode(500);
        }
        return JsonResponse::create()->setStatusCode(200);
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
                return new JsonResponse(["error" => "Oops, something went wrong.."], 500);
            }
        }
        return new JsonResponse([]);
        
    }
    
    /**
     * Checks if the $subscriptionTypes are allowed for the module. Removes the types which are
     * not allowed.
     * @param int $moduleId
     * @param array $subscriptionTypes
     * @return array
     */
    private function checkSubscriptionPermissions(int $moduleId, array $subscriptionTypes)
    {
        $module = ModuleModel::findById($moduleId);
        $resultingTypes = [];
        if ($module) {
            $allowedTypes = unserialize($module->subscriptionTypes);
            foreach ($subscriptionTypes as $key => $value) {
                if (in_array($value, $allowedTypes)) {
                    $resultingTypes[] = $value;
                }
            }
        }
        return $resultingTypes;
    }
}