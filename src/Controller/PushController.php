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

namespace con4gis\PwaBundle\Controller;

use con4gis\CoreBundle\Controller\BaseController;
use con4gis\CoreBundle\Resources\contao\models\C4gLogModel;
use con4gis\PwaBundle\Entity\PushSubscription;
use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\ModuleModel;
use Contao\System;
use Contao\Database;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Contao\CoreBundle\Framework\ContaoFramework;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PushController extends BaseController
{
    public function __construct(
        ContainerInterface $container,
        ContaoFramework $framework
    ) {
        parent::__construct($container);
        $framework->initialize(true);
    }

    protected function initialize($withEntityManager = true)
    {
        parent::initialize(false);
    }

    /**
     * @Route(
     *      path="/con4gis/pushSubscription/getKey",
     *      name="getPushPublicKey",
     *      methods={"GET"}
     *  )
     * @param $request
     * @return JsonResponse
     */
    #[Route(
        path: '/con4gis/pushSubscription/getKey',
        name: 'getPushPublicKey',
        methods: ['GET']
    )]
    public function getPublicKeyAction(Request $request)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $data = $request->query->all();
        $moduleId = $data ? $data['moduleId'] : false;
        $publicKey = false;
        if ($moduleId) {
            $module = ModuleModel::findById($moduleId);
            if ($module && $module->pushConfig) {
                $config = $em->getRepository(WebPushConfiguration::class)->findOneBy(['id'=>$module->pushConfig]);
                $publicKey = $config ? $config->getVapidPublickey() : false;
            }
        }

        //if there are no config in module we take first publicKey
        if (!$publicKey) {
            $configurations = $em->getRepository(WebPushConfiguration::class)->findAll();
            foreach ($configurations as $config) {
                $publicKey = $config->getVapidPublickey();
                break;
            }
        }

        return new JsonResponse(['key' => html_entity_decode($publicKey)]);
    }
    
    /**
     * @Route(
     *      path="/con4gis/pushSubscription/",
     *      name="getPushSubscription",
     *      methods={"GET"}
     *  )
     * @param $request
     * @return JsonResponse
     */
    #[Route(
        path: '/con4gis/pushSubscription/',
        name: 'getPushSubscription',
        methods: ['GET']
    )]
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
            $arrData['types'] = [];
            $response->setData($arrData);
        }
        return $response;
    }
    
    /**
     * @Route(
     *      path="/con4gis/pushSubscription",
     *      name="createPushSubscription",
     *      methods={"POST"}
     *  )
     * @param $request
     * @return JsonResponse
     */
    #[Route(
        path: '/con4gis/pushSubscription',
        name: 'createPushSubscription',
        methods: ['POST']
    )]
    public function createSubscription(Request $request)
    {
        $this->container->get('contao.framework')->initialize();
        $entityManager = System::getContainer()->get('doctrine.orm.default_entity_manager');
        $arrData = $request->request->all();
        $endpoint = $arrData['endpoint'];
        $moduleId = $arrData['moduleId'];
        $subscriptionTypes = $arrData['subscriptionTypes'];
        if (!$subscriptionTypes || count($subscriptionTypes) < 1) {
            $subscriptionTypes = [];
        }
        $subscriptionTypes = $this->checkSubscriptionPermissions(intval($moduleId), $subscriptionTypes);
        
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
                C4gLogModel::addLogEntry('pwa', $exception->getMessage());
                return new JsonResponse(["error" => "Oops, something went wrong.."], 500);
            }
        }
        return new JsonResponse([]);
    }
    
    /**
     * @Route(
     *      path="/con4gis/pushSubscription",
     *      name="updatePushSubscription",
     *      methods={"PUT"}
     *  )
     * @param $request
     * @return JsonResponse
     */
    #[Route(
        path: '/con4gis/pushSubscription',
        name: 'updatePushSubscription',
        methods: ['PUT']
    )]
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
            C4gLogModel::addLogEntry('pwa', $e->getMessage());
            return JsonResponse::create()->setStatusCode(500);
        }
        return JsonResponse::create()->setStatusCode(200);
    }
    
    /**
     * @Route(
     *      path="/con4gis/pushSubscription",
     *      name="deleteSubscriptionAction",
     *      methods={"DELETE"}
     *  )
     * @param Request $request
     * @return JsonResponse
     */
    #[Route(
        path: '/con4gis/pushSubscription',
        name: 'deleteSubscriptionAction',
        methods: ['DELETE']
    )]
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
                C4gLogModel::addLogEntry('pwa', $exception->getMessage());
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
        if ($module && $module->subscriptionTypes) {
            $allowedTypes = \Contao\StringUtil::deserialize($module->subscriptionTypes);
            foreach ($subscriptionTypes as $key => $value) {
                if (in_array($value, $allowedTypes)) {
                    $resultingTypes[] = $value;
                }
            }
        } else {
            return $subscriptionTypes;
        }
        return $resultingTypes;
    }
}