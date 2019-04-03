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
    
    public function createServiceWorkerFile($fileNames, $cacheName, $webPath, $strOfflinePage)
    {
        $this->createCachingCode($fileNames, $cacheName);
        if ($strOfflinePage) {
            $this->createFetchCodeWithOfflinePage($fileNames, $cacheName, $strOfflinePage);
        } else {
            $this->createFetchCode($fileNames, $cacheName);
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
        foreach ($fileNames as $fileName) {
            $this->strContent .= "\t\tcache.add('" . $fileName . "');\n";
        }
        $this->strContent .= "\t})\n";
        $this->strContent .= "));\n";
    }
    
    /**
     * Creates an event listener on the fetch event and tries to serve the desired request from the cache with the
     * given name.
     * @param $fileNames
     * @param $cacheName
     * @param $strOfflinePage
     */
    public function createFetchCode($fileNames, $cacheName)
    {
        $lastFragment = "let fragment = event.request.url.substring(event.request.url.lastIndexOf('/') + 1);\n";
        $switchStmt = "switch(fragment) {\n";
        foreach ($fileNames as $fileName) {
            $switchStmt .= "\t\tcase '$fileName':\n";
            $switchStmt .= "\t\treturn cache.match('$fileName');\n";
        }
        $switchStmt .= "}\n";
        $this->strContent .= <<< JS
self.addEventListener('fetch', event => {
	event.respondWith(
        caches.open("$cacheName")
        // if requested url match the cache entry, serve from cache
        .then(cache => {
            $lastFragment
            $switchStmt
        })
        // if not, fire a request for the requested resource
        .then(function(response) {
            return response || fetch(event.request)
      })
	);
});
JS;
    }
    
    public function createFetchCodeWithOfflinePage($fileNames, $cacheName, $offlinePageName)
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