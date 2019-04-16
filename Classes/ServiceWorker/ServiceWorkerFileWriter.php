<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 22.03.19
 * Time: 09:15
 */

namespace con4gis\PwaBundle\Classes\ServiceWorker;

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
    
    public function createServiceWorkerFile($fileNames, $cacheName, $webPath, $strOfflinePage, $intOfflineHandling)
    {
        $this->createCachingCode($fileNames, $cacheName);
        if ($strOfflinePage) {
            if ($strOfflinePage && $intOfflineHandling === PwaConfiguration::PWA_OFFLINE_HANDLING_FALLBACK) {
                // fallback offline mode
                $this->createFetchCodeWithOfflinePage($strOfflinePage);
            } else {
                // always offlinePage mode
                $this->createFetchCodeForOfflineFallback($strOfflinePage);
            }
        } else {
            // no offline page => no fallback when request failes and no cache matches
            $this->createFetchCode();
        }
        $this->createPushCode();
        file_put_contents($webPath . "/sw.js",$this->strContent);
    }
    
    /**
     * Creates an event listener on the install event for the service worker and caches all given file names.
     * @param $fileNames
     * @param $cacheName
     */
    public function createCachingCode($fileNames, $cacheName)
    {
        $this->strContent .= "self.addEventListener('install', event => event.waitUntil(\n";
        $this->strContent .= "\tcaches.open('" . $cacheName . "').then(cache => {\n";
        $this->strContent .= "\t\tcache.add('/');\n";
        $this->strContent .= "\t\tcache.add('/manifest.webmanifest');\n";
        foreach ($fileNames as $fileName) {
            $this->strContent .= "\t\tcache.add('" . $fileName . "');\n";
        }
        $this->strContent .= "\t})\n";
        $this->strContent .= "));\n";
    }
    
    /**
     * Creates an event listener on the fetch event and tries to serve the desired request from the cache with the
     * given name.
     */
    public function createFetchCode()
    {
        // should fail when no cache match happens
        $this->strContent .= <<< JS
self.addEventListener('fetch', event => {
  if (event.request.mode === 'navigate') {
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
    public function createFetchCodeWithOfflinePage($offlinePage)
    {
        // should return offline page when everything else failes
        $this->strContent .= <<< JS
self.addEventListener('fetch', event => {
  if (event.request.mode === 'navigate') {
    return event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request.url))//.catch(() => caches.match('$offlinePage'))
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
    public function createFetchCodeForOfflineFallback($offlinePageName)
    {
        $this->strContent.= <<< JS
self.addEventListener('fetch', event => {
  if (event.request.mode === 'navigate') {
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
  self.registration.showNotification(notification.title, notification);
});
JS;
    }
    
    /**
     * @return string
     */
    public function getStrContent(): string
    {
        return $this->strContent;
    }
}