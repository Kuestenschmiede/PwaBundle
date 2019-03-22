<?php
/**
 * Created by PhpStorm.
 * User: cro
 * Date: 22.03.19
 * Time: 09:15
 */

namespace con4gis\PwaBundle\Classes\ServiceWorker;

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
     * @param $cacheName
     */
    public function createFetchCode($cacheName)
    {
        $this->strContent .= <<< JS
self.addEventListener('fetch', event => {
	event.respondWith(
        caches.open("$cacheName")
        // if requested url match the cache entry, serve from cache
        .then(cache => {
            if (event.request.url.endsWith('/landing.html')) {
                return cache.match('landing.html');
            } else if (event.request.url.endsWith('/second.html')) {
                return cache.match('second.html');
            }
        })
        // if not, fire a request for the requested resource
        .then(function(response) {
            return response || fetch(event.request)
      })
	);
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