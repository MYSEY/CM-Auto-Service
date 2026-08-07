<?php

namespace App\Http\Controllers\Pwa;

use App\Models\PushSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushNotificationController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|url',
            'keys' => 'required|array',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        $endpoint = $request->input('endpoint');
        $p256dh = $request->input('keys.p256dh');
        $auth = $request->input('keys.auth');

        $existing = PushSubscription::where('endpoint', $endpoint)->first();

        if ($existing) {
            $existing->update([
                'public_key' => $p256dh,
                'auth_token' => $auth,
                'p256dh_key' => $p256dh,
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'user_agent' => $request->userAgent(),
                'is_active' => true,
            ]);
        } else {
            PushSubscription::create([
                'endpoint' => $endpoint,
                'public_key' => $p256dh,
                'auth_token' => $auth,
                'p256dh_key' => $p256dh,
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'user_agent' => $request->userAgent(),
                'is_active' => true,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Push subscription saved.']);
    }

    public function unsubscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|url',
        ]);

        PushSubscription::where('endpoint', $request->input('endpoint'))->update([
            'is_active' => false,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Push subscription removed.']);
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:1000',
            'url' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $subscriptions = PushSubscription::active()->get();

        if ($subscriptions->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No active subscriptions.'], 404);
        }

        $webPush = $this->getWebPush();

        $payload = json_encode([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'url' => $request->input('url', '/'),
            'icon' => $request->input('icon', '/frontends/assets/img/logo.png'),
        ]);

        $sentCount = 0;
        $failedEndpoints = [];

        foreach ($subscriptions as $sub) {
            try {
                $subscription = Subscription::create([
                    'endpoint' => $sub->endpoint,
                    'publicKey' => $sub->p256dh_key,
                    'authToken' => $sub->auth_token,
                ]);

                $report = $webPush->sendOneNotification($subscription, $payload);

                if ($report->isSuccess()) {
                    $sentCount++;
                } else {
                    $failedEndpoints[] = $sub->endpoint;
                    $sub->update(['is_active' => false]);
                }
            } catch (\Exception $e) {
                $failedEndpoints[] = $sub->endpoint;
                $sub->update(['is_active' => false]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => "Notification sent to {$sentCount} subscriptions.",
            'failed' => count($failedEndpoints),
        ]);
    }

    public function vapidPublicKey()
    {
        return response()->json([
            'publicKey' => config('webpush.vapid.public_key'),
        ]);
    }

    private function getWebPush(): WebPush
    {
        return new WebPush([
            'vapid' => [
                'subject' => config('app.url'),
                'publicKey' => config('webpush.vapid.public_key'),
                'privateKey' => config('webpush.vapid.private_key'),
            ],
        ]);
    }
}
