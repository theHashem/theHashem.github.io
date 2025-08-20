<?php
// Den gesamten POST-Body, den das iOS-Gerät sendet, auslesen.
// Es handelt sich hierbei um eine Property List (XML-Format).
$plist_data = file_get_contents('php://input');

// Wir suchen nach dem UDID-Eintrag in der XML-Datei.
$udid = '';
if (preg_match('/<key>UDID<\/key>\s*<string>([^<]+)<\/string>/', $plist_data, $matches)) {
    $udid = $matches[1];
}

// HTML-Seite generieren, um die UDID anzuzeigen.
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deine iOS UDID</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f0f0f0; text-align: center; }
        .container { background-color: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        p { background-color: #eee; padding: 15px; border-radius: 6px; font-size: 1.2em; font-family: "SF Mono", "Courier New", monospace; word-wrap: break-word; }
        .copy-button { background-color: #007aff; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 1em; margin-top: 10px; }
        .copy-button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($udid)): ?>
            <h1>Geräte UDID erfolgreich ausgelesen!</h1>
            <p id="udid-text"><?php echo htmlspecialchars($udid); ?></p>
            <button class="copy-button" onclick="copyToClipboard()">UDID kopieren</button>
            <p style="font-size: 0.8em; color: #666; background: none; padding: 0; margin-top: 20px;">Du kannst dieses Fenster nun schließen.</p>
        <?php else: ?>
            <h1>Fehler</h1>
            <p>Es konnte keine UDID empfangen werden. Bitte stelle sicher, dass du das Profil auf einem iOS-Gerät installierst.</p>
        <?php endif; ?>
    </div>

    <script>
        function copyToClipboard() {
            const udidText = document.getElementById('udid-text').innerText;
            navigator.clipboard.writeText(udidText).then(function() {
                alert('UDID wurde in die Zwischenablage kopiert!');
            }, function(err) {
                alert('Fehler beim Kopieren: ' + err);
            });
        }
    </script>
</body>
</html>