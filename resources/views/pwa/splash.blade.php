<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0d1b3e">
    <title>CM Auto Service</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: linear-gradient(160deg, #070f24 0%, #0d1b3e 40%, #1a2d5a 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* Animated background glow */
        .splash-glow {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(192,200,212,0.12) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }
        .splash-glow:nth-child(2) {
            width: 200px; height: 200px;
            animation-delay: 1.5s;
            background: radial-gradient(circle, rgba(52,152,219,0.1) 0%, transparent 70%);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.3); opacity: 1; }
        }

        /* Logo container */
        .splash-logo {
            position: relative;
            z-index: 2;
            animation: logoFadeIn 1s ease-out forwards;
        }
        .splash-logo img {
            width: 160px;
            height: auto;
            filter: drop-shadow(0 8px 32px rgba(13,27,62,0.5));
        }

        @keyframes logoFadeIn {
            0% { opacity: 0; transform: scale(0.8) translateY(20px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* Text */
        .splash-text {
            position: relative;
            z-index: 2;
            text-align: center;
            margin-top: 24px;
            animation: textFadeIn 1s ease-out 0.3s forwards;
            opacity: 0;
        }
        .splash-title {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 1px;
        }
        .splash-subtitle {
            font-size: 12px;
            color: rgba(192,200,212,0.7);
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 6px;
        }

        @keyframes textFadeIn {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Loading dots */
        .splash-loading {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 6px;
            margin-top: 40px;
            animation: textFadeIn 1s ease-out 0.6s forwards;
            opacity: 0;
        }
        .splash-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(192,200,212,0.4);
            animation: dotBounce 1.4s ease-in-out infinite;
        }
        .splash-dot:nth-child(2) { animation-delay: 0.2s; }
        .splash-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes dotBounce {
            0%, 80%, 100% { transform: scale(0.6); background: rgba(192,200,212,0.4); }
            40% { transform: scale(1); background: #c0c8d4; }
        }

        /* Chrome line */
        .splash-line {
            position: absolute;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            border-radius: 2px;
            background: linear-gradient(90deg, transparent, #c0c8d4, transparent);
            animation: lineShimmer 2s ease-in-out infinite;
        }
        @keyframes lineShimmer {
            0%, 100% { opacity: 0.3; width: 40px; }
            50% { opacity: 1; width: 60px; }
        }
    </style>
</head>
<body>
    <div class="splash-glow"></div>
    <div class="splash-glow"></div>

    <div class="splash-logo">
        <img src="{{ asset('frontends/assets/img/logo.png') }}" alt="CM Auto">
    </div>

    <div class="splash-text">
        <div class="splash-title">CM Auto Service</div>
        <div class="splash-subtitle">ECU &bull; Auto Parts &bull; Programming</div>
    </div>

    <div class="splash-loading">
        <div class="splash-dot"></div>
        <div class="splash-dot"></div>
        <div class="splash-dot"></div>
    </div>

    <div class="splash-line"></div>

    <script>
        setTimeout(function() {
            window.location.href = '/pwa';
        }, 2500);
    </script>
</body>
</html>
