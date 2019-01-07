importScripts("/service-worker/precache-manifest.9e01c6ab82f13f95a87ff56d5c6246f9.js", "https://storage.googleapis.com/workbox-cdn/releases/3.6.3/workbox-sw.js");

workbox.skipWaiting()
workbox.clientsClaim()

// fonts
workbox.routing.registerRoute(
    new RegExp('https://fonts.*'),
    workbox.strategies.cacheFirst({
        cacheName: 'fonts',
        plugins: [
            new workbox.cacheableResponse.Plugin({
                statuses: [0, 200]
            })
        ]
    })
)

// google stuff
workbox.routing.registerRoute(
    new RegExp('.*(?:googleapis|gstatic).com.*$'),
    workbox.strategies.networkFirst({
        cacheName: 'google'
    })
)

// static
workbox.routing.registerRoute(
    new RegExp('.(?:js|css|ico)$'),
    workbox.strategies.networkFirst({
        cacheName: 'static'
    }),
)

// images
workbox.routing.registerRoute(
    new RegExp('.(?:jpg|png|gif|svg)$'),
    workbox.strategies.cacheFirst({
        cacheName: 'images',
        plugins: [
            new workbox.expiration.Plugin({
                maxEntries: 20,
                purgeOnQuotaError: true,
            })
        ]
    })
)

// pre-cache pages
workbox.precaching.precacheAndRoute([
    {
        url: '/#',
        revision: Date.now()
    }
])

/**
 * save pages to cache on visit & serve when offline
 * or if not cached then serve the "offline view"
 */
const customHandler = async (args) => {
    try {
        return await workbox.strategies.networkFirst({
            cacheName: 'pages',
        }).handle(args) || caches.match('/#')
    } catch (error) {
        return caches.match('/#')
    }
}

const navigationRoute = new workbox.routing.NavigationRoute(customHandler, {
    // dont cache this urls
    blacklist: [
        new RegExp('/(login|register|logout)')
    ]
})

workbox.routing.registerRoute(navigationRoute)
