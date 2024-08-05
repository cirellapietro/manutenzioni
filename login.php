<?php
session_start();
include 'db_connection.php';

$googleClientID = "progettotest-388806.apps.googleusercontent.com"; // Sostituisci con il tuo Google Client ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['idtoken'];
    
    // Verifica del token tramite Google API
    $client = new Google_Client(['client_id' => $googleClientID]);
    $payload = $client->verifyIdToken($token);
    if ($payload) {
        $_SESSION['email'] = $payload['email'];
        header('Location: index.php');
        exit();
    } else {
        echo "Errore di autenticazione";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com">
    <script>
        function onSignIn(googleUser) {
            var id_token = googleUser.getAuthResponse().id_token;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'login.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.href = 'index.php';
                }
            };
            xhr.send('idtoken=' + id_token);
        }
    </script>
</head>
<body>
    <div class="g-signin2" data-onsuccess="onSignIn"></div>
</body>
</html>