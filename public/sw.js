const CACHE_NAME = 'saf-tagihan-v2';

function appUrl(path) {
  return new URL(path, self.location).href;
}

const OFFLINE_URL = appUrl('offline.html');

const PRECACHE_ASSETS = [
  appUrl('./'),
  OFFLINE_URL,
  appUrl('app.webmanifest'),
  appUrl('logo.jpeg'),
  appUrl('icons/icon-72x72.png'),
  appUrl('icons/icon-96x96.png'),
  appUrl('icons/icon-128x128.png'),
  appUrl('icons/icon-144x144.png'),
  appUrl('icons/icon-152x152.png'),
  appUrl('icons/icon-192x192.png'),
  appUrl('icons/icon-384x384.png'),
  appUrl('icons/icon-512x512.png'),
  appUrl('icons/apple-touch-icon.png')
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(PRECACHE_ASSETS).catch(err => {
        console.warn('[SW] Pre-caching partial failure:', err);
      });
    }).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
      );
    }).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  const { request } = event;
  const url = new URL(request.url);

  // Jangan cache request non-GET (POST, PUT, DELETE dll)
  if (request.method !== 'GET') {
    event.respondWith(
      fetch(request).catch(err => {
        const accept = request.headers.get('Accept') || '';
        if (accept.includes('application/json')) {
          return new Response(
            JSON.stringify({
              status: false,
              message: 'Tidak ada koneksi internet. Silakan hubungkan internet lalu coba lagi.'
            }),
            {
              status: 503,
              headers: { 'Content-Type': 'application/json' }
            }
          );
        }
        throw err;
      })
    );
    return;
  }

  // 1. Navigation requests (HTML pages)
  if (request.mode === 'navigate') {
    event.respondWith(
      fetch(request)
        .then(response => {
          if (response && response.status === 200) {
            const clone = response.clone();
            caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
          }
          return response;
        })
        .catch(async () => {
          const cachedResponse = await caches.match(request);
          if (cachedResponse) return cachedResponse;
          const offlinePage = await caches.match(OFFLINE_URL);
          return offlinePage || new Response('Offline', { status: 503, statusText: 'Offline' });
        })
    );
    return;
  }

  // 2. Static assets (images, fonts, stylesheets, scripts)
  const isStatic =
    url.origin === location.origin ||
    url.hostname.includes('fonts.googleapis.com') ||
    url.hostname.includes('fonts.gstatic.com') ||
    url.hostname.includes('cdn.jsdelivr.net') ||
    url.hostname.includes('cdn.tailwindcss.com');

  if (isStatic) {
    event.respondWith(
      caches.match(request).then(cached => {
        const networkFetch = fetch(request).then(response => {
          if (response && response.status === 200) {
            const clone = response.clone();
            caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
          }
          return response;
        }).catch(() => cached);

        return cached || networkFetch;
      })
    );
    return;
  }

  // 3. Fallback request
  event.respondWith(
    fetch(request).catch(() => caches.match(request))
  );
});

self.addEventListener('message', event => {
  if (event.data && event.data.action === 'skipWaiting') {
    self.skipWaiting();
  }
});
