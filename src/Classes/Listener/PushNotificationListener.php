<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2022, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */

namespace con4gis\PwaBundle\Classes\Listener;

use con4gis\CoreBundle\Resources\contao\models\C4gLogModel;
use con4gis\PwaBundle\Classes\Events\PushNotificationEvent;
use con4gis\PwaBundle\Entity\PushSubscription;
use con4gis\PwaBundle\Entity\PushSubscriptionType;
use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\FilesModel;
use Doctrine\ORM\EntityManager;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PushNotificationListener
{
    /**
     * @var EntityManager
     */
    private $entityManager = null;

    /**
     * @var WebPush
     */
    private $webPushService = null;

    /**
     * @var LoggerInterface
     */
    private $logger = null;

    /**
     * PushNotificationListener constructor.
     * @param $entityManager
     * @param $webPushService
     * @param LoggerInterface $logger
     */
    public function __construct($entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    /**
     * Gets the subscriptions.
     * @param PushNotificationEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function onPushNotificationGetSubscriptions(
        PushNotificationEvent $event,
        $eventName,
        EventDispatcherInterface $eventDispatcher
    ) {
        $types = $event->getSubscriptionTypes();

        if (!$types || (count($types) == 0)) {
            return;
        }
        $resSubscriptions = [];
        foreach ($types as $typeId) {
            $type = $this->entityManager->getRepository(PushSubscriptionType::class)->findOneBy(['id' => intval($typeId)]);
            if ($type) {
                $webpushConfig = $this->entityManager->getRepository(WebPushConfiguration::class)->findOneBy(['id' => $type->getPushConfig()]);
                
                $clickUrl = $event->getClickUrl();
                if ($clickUrl && (substr($clickUrl, 0, 2) === '<a')) {
                    // parse the href
                    $dom = new \DOMDocument();
                    $dom->loadHTML($clickUrl);
                    $href = '';
                    foreach ($dom->getElementsByTagName('a') as $node) {
                        $href = $node->getAttribute('href');
                    }
                } else {
                    $href = $clickUrl;
                }
                $arrContent = [
                        'title' => $event->getTitle(),
                        'body' => $event->getMessage(),
                        'click_action' => $href,
                    ];
    
                $iconModel = FilesModel::findByUuid($webpushConfig->getIcon());
                
                if ($iconModel !== null) {
                    $filePath = $iconModel->path;
                    
                    $arrContent['icon'] = $filePath;
                }
                

                $subscriptions = $this->entityManager->getRepository(PushSubscription::class)->findAll();
                foreach ($subscriptions as $subscription) {
                    if (array_intersect([$typeId], $subscription->getTypes())) {
                        if (count($types) > 0) {
                            $subscription->setContent($arrContent);
                            $subscription->setConfig($webpushConfig);
                            $resSubscriptions[$subscription->getId()] = $subscription;
                        }
                    }
                }
            }
        }

        $event->setSubscriptions($resSubscriptions);
    }

    /**
     * Sends the notifications.
     * @param PushNotificationEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function onPushNotificationSendNotifications(
        PushNotificationEvent $event,
        $eventName,
        EventDispatcherInterface $eventDispatcher
    ) {
        $subscriptions = $event->getSubscriptions();

        try {
            foreach ($subscriptions as $subscription) {
                $webpushConfig = (object) $subscription->getConfig();
                $auth = [
                    'VAPID' => [
                        'subject' => html_entity_decode($webpushConfig->getVapidSubject()), // can be a mailto: or your website address
                        'publicKey' => html_entity_decode($webpushConfig->getVapidPublickey()), // (recommended) uncompressed public key P-256 encoded in Base64-URL
                        'privateKey' => html_entity_decode($webpushConfig->getVapidPrivatekey()), // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
                    ],
                ];
                $this->webPushService = new WebPush($auth);

                $sub = Subscription::create([
                    'endpoint' => $subscription->getEndpoint(),
                    'contentEncoding' => 'aesgcm',
                    'publicKey' => $subscription->getP256dhKey(),
                    'authToken' => $subscription->getAuthKey(),
                ]);

                //ToDo form configuration
                $defaultOptions = [
                    'TTL' => intval($webpushConfig->getTtl()), // defaults to 4 weeks
                    'urgency' => $webpushConfig->getUrgency(), // protocol defaults to "normal"
                    'topic' => $webpushConfig->getTopic(), // not defined by default,
                    'batchSize' => intval($webpushConfig->getBatchSize()), // defaults to 1000
                ];
                
                if ($defaultOptions['batchSize'] === 0) {
                    $defaultOptions['batchSize'] = 1000;
                }

                $this->webPushService->queueNotification($sub, \GuzzleHttp\json_encode($subscription->getContent()));
                $this->handleSendingForService($this->webPushService, $defaultOptions);
            }
        } catch (\ErrorException $exception) {
            // log error message with stack trace
            C4gLogModel::addLogEntry('pwa', $exception->getMessage() . "\n" . $exception->getTrace());
        }
    }

    private function handleSendingForService(WebPush $webPushService, array $defaultOptions)
    {
        $webPushService->setDefaultOptions($defaultOptions);

        foreach ($webPushService->flush() as $report) {
            $endpoint = $report->getRequest()->getUri()->__toString();

            if ($report->isSuccess()) {
                C4gLogModel::addLogEntry('pwa', "[v] Message sent successfully for subscription {$endpoint}.");
            } else {
                C4gLogModel::addLogEntry('pwa', "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}");
            }
        }
    }
}
