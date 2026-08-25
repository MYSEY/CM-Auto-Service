(function() {
    'use strict';

    var banner = null;

    function createBanner() {
        if (banner) return banner;
        if (!document.body) return null;
        banner = document.createElement('div');
        banner.id = 'pwa-offline-banner';
        banner.className = 'pwa-offline-banner';
        banner.innerHTML = '<span class="pwa-offline-icon">&#9888;</span><span class="pwa-offline-text">You are offline. Please check your connection.</span>';
        document.body.appendChild(banner);
        return banner;
    }

    function showOfflineBanner() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', showOfflineBanner);
            return;
        }
        var b = createBanner();
        if (b) {
            b.classList.add('show');
        }
        if (document.body) {
            document.body.classList.add('pwa-is-offline');
        }
    }

    function hideOfflineBanner() {
        if (banner) {
            banner.classList.remove('show');
        }
        if (document.body) {
            document.body.classList.remove('pwa-is-offline');
        }
    }

    function showReconnectToast() {
        if (!document.body) return;
        var toast = document.createElement('div');
        toast.className = 'pwa-reconnect-toast';
        toast.innerHTML = '&#10003; Back online';
        document.body.appendChild(toast);
        requestAnimationFrame(function() {
            toast.style.opacity = '1';
            toast.style.transform = 'translate(-50%, 0)';
        });
        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transform = 'translate(-50%, -10px)';
            setTimeout(function() { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 300);
        }, 2500);
    }

    window.addEventListener('offline', function() {
        showOfflineBanner();
    });

    window.addEventListener('online', function() {
        hideOfflineBanner();
        showReconnectToast();
    });

    window.pwaIsOffline = function() {
        return !navigator.onLine;
    };

    if (!navigator.onLine) {
        showOfflineBanner();
    }
})();
