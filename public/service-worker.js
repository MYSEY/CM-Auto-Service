const CACHE_NAME = 'cm-auto-service-v3';
const OFFLINE_URL = '/offline.html';
const urlsToCache = [
    '/',
    '/frontends/assets/css/style.css',
    '/frontends/assets/css/plugins.css',
    '/frontends/assets/css/cm.css',
    '/frontends/assets/js/main.js',
    '/frontends/assets/js/plugins.js',
    '/frontends/assets/img/logo.png'
];

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                return Promise.all(
                    urlsToCache.map(function(url) {
                        return cache.add(url).catch(function(err) {
                            console.log('Failed to cache:', url);
                        });
                    })
                );
            })
            .then(function() {
                return self.skipWaiting();
            })
    );
});

self.addEventListener('fetch', function(event) {
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .then(function(response) {
                    var responseToCache = response.clone();
                    caches.open(CACHE_NAME).then(function(cache) {
                        cache.put(event.request, responseToCache);
                    });
                    return response;
                })
                .catch(function() {
                    return caches.match(event.request)
                        .then(function(response) {
                            return response || caches.match(OFFLINE_URL);
                        });
                })
        );
    } else {
        event.respondWith(
            caches.match(event.request)
                .then(function(response) {
                    if (response) {
                        return response;
                    }
                    return fetch(event.request).then(function(response) {
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }
                        var responseToCache = response.clone();
                        caches.open(CACHE_NAME).then(function(cache) {
                            cache.put(event.request, responseToCache);
                        });
                        return response;
                    });
                })
                .catch(function() {
                    return caches.match(OFFLINE_URL);
                })
        );
    }
});

self.addEventListener('activate', function(event) {
    var cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
