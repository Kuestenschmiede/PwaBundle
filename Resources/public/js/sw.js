self.addEventListener('install', event => event.waitUntil(
  caches.open('pwa-con4gis-v1').then(cache => cache.add('/landing.html'))
));

self.addEventListener('fetch', event => event.respondWith(
  caches.open('pwa-con4gis-v1')
  // if requested url match the cache entry, serve from cache
    .then(cache => cache.match(event.request))
    // if not, fire a request for the requested resource
    .then(response => response || fetch(event.request))
));