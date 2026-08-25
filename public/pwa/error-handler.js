(function() {
    'use strict';

    var ERROR_MESSAGES = {
        network: 'Network error. Please check your connection.',
        server: 'Something went wrong. Please try again later.',
        default: 'An unexpected error occurred.'
    };

    function showSafeError(message) {
        if (document.querySelector('.pwa-error-toast')) return;

        var toast = document.createElement('div');
        toast.className = 'pwa-error-toast';
        toast.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);background:#333;color:#fff;padding:12px 24px;border-radius:8px;font-size:14px;z-index:99999;max-width:90%;text-align:center;opacity:0;transition:opacity 0.3s;box-shadow:0 4px 12px rgba(0,0,0,0.3);';
        toast.textContent = message || ERROR_MESSAGES.default;
        document.body.appendChild(toast);

        requestAnimationFrame(function() {
            toast.style.opacity = '1';
        });

        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() {
                if (toast.parentNode) toast.parentNode.removeChild(toast);
            }, 300);
        }, 3000);
    }

    window.onerror = function(msg, url, line, col, error) {
        console.error('PWA Error:', msg, url, line, col, error);
        return false;
    };

    window.addEventListener('unhandledrejection', function(e) {
        var reason = e.reason || '';
        var msg = String(reason).toLowerCase();
        console.warn('PWA Unhandled Rejection:', reason);

        if (msg.indexOf('network') !== -1 || msg.indexOf('failed to fetch') !== -1) {
            showSafeError(ERROR_MESSAGES.network);
        }
        e.preventDefault();
    });

    window.pwaHandleError = function(customMessage) {
        showSafeError(customMessage || ERROR_MESSAGES.default);
    };

    window.pwaFetch = function(url, options) {
        return fetch(url, options).catch(function(error) {
            showSafeError(ERROR_MESSAGES.network);
            throw error;
        });
    };
})();
