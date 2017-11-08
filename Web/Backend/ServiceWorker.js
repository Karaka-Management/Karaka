/**
 * Service worker.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
const CACHE_VERSION = 'static-v1';

/** global: self */
self.addEventListener('install', event =>
{
    event.waitUntil(
        /** global: caches */
        caches.open(CACHE_VERSION).then(cache => cache.addAll([
            '/en/E404', // todo: this should be /en/404 but since it's header is 404 it cannot get cached
            //'/en/backend' // todo: doesn't work with login since the login page will be cached instead of the backend
            //'/Web/E404/css/styles.css'
        ])).then(self.skipWaiting())
    );
});

self.addEventListener('fetch', event =>
{
    /** global: URL */
    const url = new URL(event.request.url);

    event.respondWith(
        caches.match(event.request).then(response => response || fetch(event.request)).catch(() => {
                if (event.request.mode == 'navigate') {
                    return caches.match('/en/E404');
                }
            }
        )
    );
});

self.addEventListener('activate', event =>
{
    const CURRENT_CACHES = [CACHE_VERSION];

    event.waitUntil(
        caches.keys().then(cacheNames =>
        {
            return CURRENT_CACHES.filter(cacheName => !CURRENT_CACHES.includes(cacheName));
        }).then(cachesToDelete => {
            return Promise.all(
                cachesToDelete.map(cacheName =>
                {
                    return caches.delete(cacheName);
                })
            );
        }).then(() => self.clients.claim())
    );
});
