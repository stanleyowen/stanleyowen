const offlineCache = '../offline/index.html';
self.addEventListener('install', e => {
	e.waitUntil(
		caches.open(offlineCache)
		.then(cache => {
			cache.add(offlineCache).then(() => self.skipWaiting())
		})
	);
});

self.addEventListener('activate', e => {
	e.waitUntil(
		caches.keys().then(cacheNames => {
			return Promise.all(
				cacheNames.map(cache => {
					if(cache !== offlineCache){
						return caches.delete(cache);
					}
				})
			)
		})
	)
})

self.addEventListener('fetch', e => {
	e.respondWith(
		fetch(e.request).catch((error) => caches.match(offlineCache))
	);
});