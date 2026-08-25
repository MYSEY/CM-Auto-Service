if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/service-worker.js')
            .then(function(registration) {
                console.log('ServiceWorker registered: ', registration.scope);
                registration.update();
            })
            .catch(function(error) {
                console.log('ServiceWorker registration failed: ', error);
            });

        let refreshing = false;
        navigator.serviceWorker.addEventListener('controllerchange', function() {
            if (!refreshing) {
                refreshing = true;
                window.location.reload();
            }
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

// Ensure fast, reliable touch navigation on Android/mobile for bottom nav links
document.addEventListener('DOMContentLoaded', function() {
    var navLinks = document.querySelectorAll('.pwa-footer-nav a.nav-pill, .ios-bottom-nav a.nav-pill');
    navLinks.forEach(function(link) {
        var startY = 0;
        var startX = 0;
        link.addEventListener('touchstart', function(e) {
            if (e.touches && e.touches[0]) {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
            }
        }, { passive: true });

        link.addEventListener('touchend', function(e) {
            if (e.changedTouches && e.changedTouches[0]) {
                var diffX = Math.abs(e.changedTouches[0].clientX - startX);
                var diffY = Math.abs(e.changedTouches[0].clientY - startY);
                if (diffX < 10 && diffY < 10) {
                    var href = this.getAttribute('href');
                    if (href && href !== '#' && href !== 'javascript:void(0);') {
                        window.location.href = href;
                    }
                }
            }
        }, { passive: true });
    });
});