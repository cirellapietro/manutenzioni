<?php
//session_start();
require_once('db_connection.php');
require_once('debug.php');
require_once('messages.php');
/*    
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
*/
// Correggi qui: rendi $campiNascosti un array
$tabellaMaster = 'Utenti';
$tabellaDetail = 'Veicoli';
$campoJoinMasterDetail = 'utenti_ID';
$campiNascosti = ['utenti_ID', 'Veicolo_ID', 'dataOraDisabilita', 'dataOraAgg']; // Era una stringa, ora è un array
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Veicoli</title>
    <link rel="stylesheet" href="css/styles.css">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-app-pub-5545202856432487~8771480571",
            enable_page_level_ads: true
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Gestione Veicoli</h1>
        <?php
        require_once('visualizzaRecord.php');
        visualizzaRecord($tabellaMaster, $tabellaDetail, $campoJoinMasterDetail, $campiNascosti);
        ?>
    </div>
</body>
</html>