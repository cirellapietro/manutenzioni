<?php
require_once('db_connection.php');

$utente_ID = $_GET['utente_ID'] ?? null;
$tabellaMaster = $_GET['table'] ?? null;

if (!$utente_ID || !$tabellaMaster) {
    die("Parametri mancanti.");
}

try {
    // Query per eliminare il record
    $query = "DELETE FROM $tabellaMaster WHERE utente_ID = :utente_ID";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['utente_ID' => $utente_ID]);

    if ($stmt->rowCount() > 0) {
        echo "Record eliminato con successo.";
    } else {
        echo "Errore: record non trovato o non eliminato.";
    }

    // Reindirizza alla pagina principale
    header("Location: index.php");

} catch (PDOException $e) {
    die("Errore nell'eliminazione del record: " . $e->getMessage());
}
?>