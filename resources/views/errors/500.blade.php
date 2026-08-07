<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0d1b3e">
    <title>Server Error — CM Auto Service</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .error-container {
            text-align: center;
            padding: 40px 20px;
            max-width: 400px;
        }
        .error-code {
            font-size: 72px;
            font-weight: 700;
            color: #0d1b3e;
            margin-bottom: 8px;
        }
        .error-title {
            font-size: 20px;
            font-weight: 500;
            color: #0d1b3e;
            margin-bottom: 12px;
        }
        .error-message {
            font-size: 15px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .retry-btn {
            display: inline-block;
            padding: 12px 32px;
            background: #0d1b3e;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }
        .retry-btn:hover { background: #1a2f5e; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">500</div>
        <h1 class="error-title">Something Went Wrong</h1>
        <p class="error-message">We're experiencing technical difficulties. Please try again later.</p>
        <a href="/" class="retry-btn">Go Home</a>
    </div>
</body>
</html>
