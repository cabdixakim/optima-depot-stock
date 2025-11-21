self.addEventListener('install', (event) => {
    console.log('Twins Depot service worker installed');
});

self.addEventListener('activate', (event) => {
    console.log('Twins Depot service worker activated');
});

self.addEventListener('fetch', (event) => {
    event.respondWith(fetch(event.request));
});