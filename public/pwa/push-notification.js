const PushNotification = {
    registration: null,
    vapidPublicKey: null,

    async init() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            console.log('Push notifications not supported');
            return;
        }

        try {
            this.registration = await navigator.serviceWorker.ready;
            await this.loadVapidKey();
            this.updateUI();
        } catch (error) {
            console.log('Push notification init failed:', error);
        }
    },

    async loadVapidKey() {
        try {
            const response = await fetch('/pwa/push/vapid-key');
            const data = await response.json();
            this.vapidPublicKey = data.publicKey;
        } catch (error) {
            console.log('Failed to load VAPID key:', error);
        }
    },

    async subscribe() {
        if (!this.registration || !this.vapidPublicKey) {
            console.log('Push notification not ready');
            return false;
        }

        try {
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                console.log('Notification permission denied');
                return false;
            }

            const subscription = await this.registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: this.urlBase64ToUint8Array(this.vapidPublicKey)
            });

            const subscriptionJson = subscription.toJSON();

            await fetch('/pwa/push/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    endpoint: subscriptionJson.endpoint,
                    keys: {
                        p256dh: subscriptionJson.keys.p256dh,
                        auth: subscriptionJson.keys.auth
                    }
                })
            });

            this.updateUI();
            this.showToast('Push notifications enabled!');
            return true;
        } catch (error) {
            console.log('Push subscribe failed:', error);
            return false;
        }
    },

    async unsubscribe() {
        if (!this.registration) return false;

        try {
            const subscription = await this.registration.pushManager.getSubscription();
            if (!subscription) return false;

            const endpoint = subscription.endpoint;

            await subscription.unsubscribe();

            await fetch('/pwa/push/unsubscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ endpoint: endpoint })
            });

            this.updateUI();
            this.showToast('Push notifications disabled');
            return true;
        } catch (error) {
            console.log('Push unsubscribe failed:', error);
            return false;
        }
    },

    async isSubscribed() {
        if (!this.registration) return false;

        try {
            const subscription = await this.registration.pushManager.getSubscription();
            return subscription !== null;
        } catch (error) {
            return false;
        }
    },

    async updateUI() {
        const subscribed = await this.isSubscribed();
        const toggleElements = document.querySelectorAll('.push-toggle');

        toggleElements.forEach(el => {
            if (subscribed) {
                el.classList.add('active');
                el.setAttribute('data-subscribed', 'true');
            } else {
                el.classList.remove('active');
                el.setAttribute('data-subscribed', 'false');
            }
        });

        const permissionElements = document.querySelectorAll('.push-permission-status');
        permissionElements.forEach(el => {
            el.textContent = Notification.permission === 'granted' ? 'Granted' : 'Not Granted';
        });
    },

    getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    },

    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    },

    showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'push-toast';
        toast.textContent = message;
        toast.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);background:#333;color:#fff;padding:12px 24px;border-radius:8px;z-index:99999;font-size:14px;';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    PushNotification.init();
});
