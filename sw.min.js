/**
 * Service worker.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 2.0
 * @version    1.0.0
 * @since      1.0.0
 */
const PRECACHE_VERSION = 'static-v1.0.0';
const RUNTIME_VERSION = 'runtime-v1.0.0';

const PRECACHE_URLS = [
    'cssOMS/styles.css',
    'Web/Backend/js/backend.min.js',
    'Web/Backend/img/404.svg',
    'Web/Backend/img/default-user.jpg',
    'Web/Backend/img/favicon.ico',
    'Web/Backend/img/maskable_icon.png',
    'Web/Backend/img/logo.png',
    'Web/Backend/img/logo.webp',
    'Web/Backend/img/protected_content.svg',
    'Web/Backend/offline.htm',
];

/** @var {navigator.serviceWorker} self */
/** global: caches */
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(PRECACHE_VERSION)
            .then(cache => cache.addAll(PRECACHE_URLS))
            .then(self.skipWaiting())
    );

    setInterval(fetchNotification, 5 * 60 * 1000);
    //setInterval(submitGeolocation, 5 * 60 * 1000);
});

const offlineMessageHTML = '<div style="position: fixed; bottom: 0; left: 0; width: 100%; background-color: red; color: white; text-align: center; padding: 10px;">Offline Mode</div>';
self.addEventListener('fetch', event => {
    // Skip cross-origin and none-GET
    if (!event.request.url.startsWith(self.location.origin)
        || event.request.method !== 'GET' // Important for login
    ) {
        return;
    }

    // Network first approach
    event.respondWith(
        fetch(event.request)
        .then(() => {
            // Always update cache
            return caches.open(RUNTIME_VERSION).then(cache => {
                return fetch(event.request).then(response => {
                    return cache.put(event.request, response.clone()).then(() => {
                        return response;
                    });
                });
            });
        })
        .catch(() => {
            return caches.match(event.request).then(cachedResponse => {
                if (cachedResponse) {
                    let modifiedResponse = cachedResponse.clone();

                    return modifiedResponse.text().then(function(cachedText) {
                        if (!cachedText.includes("<body>")) {
                            return cachedResponse;
                        }

                        const offlinePageWithMessage = cachedText.replace('<body>', '<body>' + offlineMessageHTML);

                        return new Response(offlinePageWithMessage, {
                            headers: cachedResponse.headers,
                            status: cachedResponse.status,
                            statusText: cachedResponse.statusText
                        });
                    });
                }

                return caches.match('Web/Backend/offline.htm');
            });
        })
    );
});

self.addEventListener('activate', event => {
    const CURRENT_CACHES = [PRECACHE_VERSION, RUNTIME_VERSION];

    event.waitUntil(
        caches.keys().then(cacheNames => {
            return cacheNames.filter(cacheName => !CURRENT_CACHES.includes(cacheName));
        }).then(cachesToDelete => {
            return Promise.all(
                cachesToDelete.map(cacheToDelete => {
                    return caches.delete(cacheToDelete);
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener("periodicsync", (event) => {
    if (event.tag === "get-latest-notification") {
        /*
        const dt = new Date(Date.now() - 60 * 5);

        event.waitUntil(
            fetch('/api/notification?start=' + encodeURIComponent(dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate() + ' ' + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds())).then(response => {
                if (!response.ok) {
                    throw new Error();
                }

                return response.json();
            }).then (data => {
                if (Notification.permission === "granted") {
                    registration.showNotification(data[0].title, {
                        body: data[0].message,
                        vibrate: [200, 100],
                        tag: "notification",
                        });
                } else if (Notification.permission !== "denied") {
                    Notification.requestPermission().then(permission => {
                        if (permission === "granted") {
                            registration.showNotification(data[0].title, {
                            body: data[0].message,
                            vibrate: [200, 100],
                            tag: "notification",
                        });
                        }
                    });
                }
            })
        );
        */
    }
});

function fetchNotification() {
    if (Notification.permission !== "granted") {
        return;
    }

    const dt = new Date(Date.now() - 60 * 5);

    fetch('/api/notification?start=' + encodeURIComponent(dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate() + ' ' + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds())).then(response => {
        if (!response.ok) {
            throw new Error();
        }

        return response.json();
    }).then (data => {
        if (typeof data[0] !== 'undefined'
            && data[0].response.length > 0
        ) {
            registration.showNotification(data[0].title, {
                body: data[0].message,
                vibrate: [200, 100],
                tag: "notification",
            });
        }
    });
}

function submitGeolocation() {
    if(!navigator.geolocation) {
        return;
    }

    navigator.geolocation.getCurrentPosition(position => {
        fetch('/api/geotracking', {
            method: 'PUT',
            headers: {'Content-Type': 'application/json'},
            body: Json.stringify({'lat': position.coords.latitude, 'lon': position.coords.longitude})
        });
    })
}