<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 22.03.19
 * Time: 09:15
 */

namespace con4gis\PwaBundle\Classes\Services;

use con4gis\PwaBundle\Entity\PwaConfiguration;

/**
 * Class ServiceWorkerFileWriter
 * Provides helper methods to write the service worker javascript file chunk by chunk.
 * @package con4gis\PwaBundle\Classes\ServiceWorker
 */
class ServiceWorkerFileWriter
{
    /**
     * Current content of the writing buffer.
     * @var string
     */
    private $strContent = "";
    
    public function createServiceWorkerFile($fileNames, $cacheName, $webPath, $strOfflinePage, $intOfflineHandling, $blockedUrls)
    {
        $this->createCachingCode($fileNames, $cacheName);
        $this->createActivationListener($cacheName);
        $urlFilterString = $this->createUrlFilterString($blockedUrls);
        if ($strOfflinePage) {
            if ($strOfflinePage && $intOfflineHandling === PwaConfiguration::PWA_OFFLINE_HANDLING_FALLBACK) {
                // fallback offline mode
                $this->createFetchCodeWithOfflinePage($strOfflinePage, $urlFilterString);
            } else {
                // always offlinePage mode
                $this->createFetchCodeForOfflineFallback($strOfflinePage, $urlFilterString);
            }
        } else {
            // no offline page => no fallback when request failes and no cache matches
            $this->createFetchCode($urlFilterString);
        }
        $this->createPushCode();
        $this->createNotificationClickCode();
        file_put_contents($webPath . "/sw.js",$this->strContent);
    }
    
    /**
     * Creates an event listener on the install event for the service worker and caches all given file names.
     * @param $fileNames
     * @param $cacheName
     */
    public function createCachingCode($fileNames, $cacheName)
    {
        $this->strContent .= "self.addEventListener('install', function(event) {\n";
        $this->strContent .= "\tself.skipWaiting();\n";
        $this->strContent .= "\tevent => event.waitUntil(\n";
        $this->strContent .= "\tcaches.open('" . $cacheName . "').then(cache => {\n";
        $this->strContent .= "\t\tcache.add('/');\n";
        $this->strContent .= "\t\tcache.add('manifest.webmanifest');\n";
        foreach ($fileNames as $fileName) {
            $this->strContent .= "\t\tcache.add('" . $fileName . "');\n";
        }
        $this->strContent .= "\t}))\n";
        $this->strContent .= "});\n";
    }
    
    /**
     * Creates an activate listener that deletes all old caches.
     * @param $cacheName
     */
    public function createActivationListener($cacheName)
    {
    $this->strContent .= <<< JS
self.addEventListener('activate', function(event) {
  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.filter(function(cacheName) {
          // but remember that caches are shared across
          // the whole origin
          if (cacheName !== '$cacheName') {
            return true;
          }
        }).map(function(cacheName) {
          return caches.delete(cacheName);
        })
      );
    })
  );
});
JS;
    }
    
    /**
     * Creates an event listener on the fetch event and tries to serve the desired request from the cache with the
     * given name.
     */
    public function createFetchCode($urlFilterString)
    {
        // should fail when no cache match happens
        $this->strContent .= <<< JS
self.addEventListener('fetch', event => {
  if (event.request.mode === 'navigate') {
   $urlFilterString
   return event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request.url))
   );
  }
});

JS;
    
    }
    
    /**
     * Creates a fetch listener to match either requested pages from cache or serve the offline page,
     * if no cache matches.
     * @param $offlinePage
     */
    public function createFetchCodeWithOfflinePage($offlinePage, $urlFilterString)
    {
        // should return offline page when everything else failes
        $this->strContent .= <<< JS
self.addEventListener('fetch', event => {
  if (event.request.mode === 'navigate') {
    $urlFilterString
    return event.respondWith(
      fetch(event.request).catch(() => {
        return caches.match(event.request.url).then(function(response) {
          if (!response) {
            return caches.match('$offlinePage')
          } else {
            return response
          }
        })
      })
    );
  }
});

JS;
    
    }
    
    /**
     * Creates a fetch listener that always serves the offline page, when a request fails due to connection issues.
     * @param $fileNames
     * @param $cacheName
     * @param $offlinePageName
     */
    public function createFetchCodeForOfflineFallback($offlinePageName, $urlFilterString)
    {
        $this->strContent.= <<< JS
self.addEventListener('fetch', event => {
  if (event.request.mode === 'navigate') {
    $urlFilterString
    return event.respondWith(
      fetch(event.request).catch(() => caches.match('$offlinePageName'))
    );
  }
});

JS;
    }
    
    /**
     * Creates a push listener that shows the incoming push notification.
     */
    public function createPushCode()
    {
        $this->strContent .= <<< JS
self.addEventListener('push', event => {
  const notification = event.data.json();
  self.registration.showNotification(notification.title, {
    body: notification.body,
    icon: notification.icon,
    badge: notification.badge,
    image: notification.image,
    vibrate: [1000, 2000, 1000]
  });
});
JS;
    }
    
    public function createNotificationClickCode()
    {
        $this->strContent .= <<< JS
self.addEventListener('notificationclick', event => {
  event.notification.close();
  event.waitUntil(
    clients.matchAll().then(
      windowClients => {
        windowClients.length ? windowClients[0].focus() : clients.openWindow('/')
      }
    )
  );
});
JS;

    }
    
    public function createUrlFilterString($arrUrls)
    {
        $returnFragment = "return event.respondWith(\nfetch(event.request)\n);\n";
        $strReturn = "";
        foreach ($arrUrls as $url) {
            $strReturn .= "if (event.request.url.includes('$url')) {\n$returnFragment}\n";
        }
        return $strReturn;
    }
    
    /**
     * @return string
     */
    public function getStrContent(): string
    {
        return $this->strContent;
    }
}