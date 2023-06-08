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
    private $strContent = '';

    /**
     * @param $fileNames
     * @param $cacheName
     * @param $webPath
     * @param $strOfflinePage
     * @param $intOfflineHandling
     * @param $blockedUrls
     */
    public function createServiceWorkerFile($fileNames, $cacheName, $webPath, $strOfflinePage, $intOfflineHandling, $blockedUrls)
    {
        $this->createCachingCode($fileNames, $cacheName, $webPath);
        //$this->createActivationListener($cacheName);
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
        file_put_contents($webPath . '.js', $this->strContent);
    }

    /**
     * Creates an event listener on the install event for the service worker and caches all given file names.
     * @param $fileNames
     * @param $cacheName
     */
    public function createCachingCode($fileNames, $cacheName, $webPath)
    {
        // new folder location https://docs.contao.org/manual/en/migration/#document-root
        $pos = strpos($webPath, '/public/sw', 0);
        $strip = 10;
        if ($pos === false) {
            // old folder location
            $pos = strpos($webPath, '/web/sw', 0);
            $strip = 7;
        }
        $path = substr($webPath, $pos + $strip);

        $this->strContent .= "self.addEventListener('install', function(event) {\n";
        $this->strContent .= "\tevent.waitUntil(\n";
        $this->strContent .= "\tcaches.open('" . $cacheName . "').then(cache => \n";
        $this->strContent .= "\t\tcache.addAll(['.',\n";
        if ($pos !== false) {
            $this->strContent .= "\t\t'" . $path . "/manifest.webmanifest',\n";
        }
        $lastIndex = count($fileNames) - 1;
        foreach ($fileNames as $index => $fileName) {
            $this->strContent .= "\t\t'" . $fileName . "'";
            if ($index !== $lastIndex) {
                $this->strContent .= ",\n";
            } else {
                $this->strContent .= "\n";
            }
        }
        $this->strContent .= "\t])";
        $this->strContent .= "\t).catch((ex) => {console.warn(\"Error caching some of the pages: \"+ex); self.skipWaiting();})\n";
        $this->strContent .= "\t.then(() => self.skipWaiting()));\n";
//        $this->strContent .= "\tself.skipWaiting();\n";
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
     * @param $urlFilterString
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
     * @param $urlFilterString
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
     * @param $offlinePageName
     * @param $urlFilterString
     */
    public function createFetchCodeForOfflineFallback($offlinePageName, $urlFilterString)
    {
        $this->strContent .= <<< JS
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
  const notification = event.data && event.data.text() ? JSON.parse(event.data.text()) : event.data.json();
  if (notification !== "string" && notification.click_action && notification.click_action !== undefined) {
      self.click_action = notification.click_action;
      event.waitUntil(self.registration.showNotification(notification.title, {
        body: notification.body,
        icon: notification.icon,
        badge: notification.badge,
        image: notification.image,
        click_action: notification.click_action
      }));
  } else if (notification.title === undefined) { 
     self.click_action = undefined;
      event.waitUntil(self.registration.showNotification(notification, {
        body: notification,
        click_action: undefined
      }));
  } else {
      self.click_action = undefined;
      event.waitUntil(self.registration.showNotification(notification.title, {
        body: notification.body,
        icon: notification.icon,
        badge: notification.badge,
        image: notification.image,
        click_action: undefined
      }));
  }
});
JS;
    }

    public function createNotificationClickCode()
    {
        $this->strContent .= <<< JS
self.addEventListener('notificationclick', event => {
    // event.notification.close();
    if (self.click_action && (self.click_action !== undefined)) {
    const chain = clients.openWindow(self.click_action);
    event.waitUntil(chain);
    }
}, false);
JS;
    }

    /**
     * @param $arrUrls
     * @return string
     */
    public function createUrlFilterString($arrUrls)
    {
        $returnFragment = "return event.respondWith(\nfetch(event.request)\n);\n";
        $strReturn = '';
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
