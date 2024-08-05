self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open('v1').then(function(cache) {
            return cache.addAll([
                '/',
                '/index.php',
                '/addRecord.php',
                '/deleteRecord.php',
                '/updateRecord.php',
                '/detailRecord.php',
                '/visualizzaRecord.php',
                '/css/styles.css',
                '/manifest.json'
            ]);
        })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request);
        })
    );
});