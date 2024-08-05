<?php
include 'db_connection.php';
global $pdo;

$id = $_POST['id'] ?? null;
$tabellaMaster = $_POST['table'] ?? null;

if (!$id || !$tabellaMaster) {
    die("Parametri mancanti.");
}

$columns = array_keys($_POST);
$values = array_values($_POST);

$updateList = "";
foreach ($columns as $column) {
    if ($column != 'id' && $column != 'table') {
        $updateList .= "$column = ?, ";
    }
}
$updateList = rtrim($updateList, ", ");

$query = "UPDATE $tabellaMaster SET $updateList WHERE id = ?";
$stmt = $pdo->prepare($query);

$values[] = $id;
$stmt->execute($values);

if ($stmt->rowCount() > 0) {
    echo "Record aggiornato con successo.";
} else {
    echo "Errore nell'aggiornamento del record.";
}
?>