if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/service-worker.js')
            .then(function(registration) {
                console.log('ServiceWorker registered: ', registration.scope);
            })
            .catch(function(error) {
                console.log('ServiceWorker registration failed: ', error);
            });
    });
}

let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
});

function installPWA() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
            }
            deferredPrompt = null;
        });
    }
}