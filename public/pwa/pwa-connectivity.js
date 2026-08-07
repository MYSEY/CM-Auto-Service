(function() {
    'use strict';

    var banner = null;
    var isOffline = !navigator.onLine;
    var bannerTimeout = null;

    function createBanner() {
        if (banner) return banner;
        banner = document.createElement('div');
        banner.id = 'pwa-offline-banner';
        banner.className = 'pwa-offline-banner';
        banner.innerHTML = '<span class="pwa-offline-icon">&#128268;</span><span class="pwa-offline-text">You are offline</span>';
        document.body.appendChild(banner);
        return banner;
    }

    function showOfflineBanner() {
        var b = createBanner();
        b.classList.add('show');
        document.body.classList.add('pwa-is-offline');
    }

    function hideOfflineBanner() {
        if (banner) {
            banner.classList.remove('show');
        }
        document.body.classList.remove('pwa-is-offline');
    }

    function showReconnectToast() {
        var toast = document.createElement('div');
        toast.className = 'pwa-reconnect-toast';
        toast.innerHTML = '&#10003; Back online';
        document.body.appendChild(toast);
        requestAnimationFrame(function() { toast.style.opacity = '1'; });
        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 300);
        }, 2500);
    }

    window.addEventListener('offline', function() {
        isOffline = true;
        showOfflineBanner();
    });

    window.addEventListener('online', function() {
        isOffline = false;
        hideOfflineBanner();
        showReconnectToast();
    });

    window.pwaIsOffline = function() {
        return !navigator.onLine;
    };

    window.pwaCheckOnline = function(callback) {
        if (!navigator.onLine) {
            callback(false);
            return;
        }
        fetch('/favicon.ico', { method: 'HEAD', mode: 'no-cors', cache: 'no-store' })
            .then(function() { callback(true); })
            .catch(function() { callback(false); });
    };

    if (isOffline) {
        showOfflineBanner();
    }
})();
