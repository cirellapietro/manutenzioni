<?php
require_once('db_connection.php');

// Imposta le variabili come richiesto
$record_ID = $_GET['record_ID'] ?? null;
$tabellaMaster = $_GET['table'] ?? null;
$campoJoinMasterDetail = $_GET['join'] ?? null;
$campiNascosti = ["utenti_ID", "dataOraAgg"]; // Campi da nascondere
$tabellaDetail = 'Veicoli'; // Nome della tabella di dettaglio
$campoJoinMasterDetail = 'utenti_ID'; // Campo di join tra la tabella master e quella di dettaglio

if (!$record_ID || !$tabellaMaster || !$campoJoinMasterDetail) {
    die("Parametri mancanti.");
}

try {
    // Query per ottenere il record selezionato
    $query = "SELECT * FROM $tabellaMaster WHERE $campoJoinMasterDetail = :record_ID";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['record_ID' => $record_ID]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        echo "<h2>Modifica Dettagli del Record</h2>";
        echo "<form method='post' action='updateRecord.php'>";
        echo "<input type='hidden' name='record_ID' value='" . htmlspecialchars($record_ID) . "'>";
        echo "<input type='hidden' name='table' value='" . htmlspecialchars($tabellaMaster) . "'>";

        foreach ($record as $key => $value) {
            if (!in_array($key, $campiNascosti)) {
                // Decodifica i campi che contengono '_ID'
                if (strpos($key, '_ID') !== false) {
                    $decodificaQuery = "SELECT descrizione FROM " . str_replace('_ID', '', $key) . " WHERE $key = :id";
                    $stmtDecodifica = $pdo->prepare($decodificaQuery);
                    $stmtDecodifica->execute(['id' => $value]);
                    $descrizione = $stmtDecodifica->fetchColumn();

                    echo "<div>";
                    echo "<label for='$key'>" . htmlspecialchars($key) . ":</label>";
                    echo "<select id='$key' name='$key'>";
                    echo "<option value='$value' selected>" . htmlspecialchars($descrizione) . "</option>";

                    // Aggiungi altre opzioni se necessario
                    $opzioniQuery = "SELECT $key, descrizione FROM " . str_replace('_ID', '', $key);
                    $stmtOpzioni = $pdo->query($opzioniQuery);
                    while ($opzione = $stmtOpzioni->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($opzione[$key]) . "'>" . htmlspecialchars($opzione['descrizione']) . "</option>";
                    }
                    echo "</select>";
                    echo "</div>";

                } else {
                    // Ottieni il tipo di campo dal database
                    $queryTipo = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = :table AND column_name = :column";
                    $stmtTipo = $pdo->prepare($queryTipo);
                    $stmtTipo->execute(['table' => $tabellaMaster, 'column' => $key]);
                    $tipoCampo = $stmtTipo->fetchColumn();

                    echo "<div>";
                    echo "<label for='$key'>" . htmlspecialchars($key) . ":</label>";

                    // Genera l'input in base al tipo di campo
                    switch ($tipoCampo) {
                        case 'int':
                        case 'tinyint':
                        case 'smallint':
                        case 'mediumint':
                        case 'bigint':
                        case 'decimal':
                        case 'float':
                        case 'double':
                            echo "<input type='number' id='$key' name='$key' value='" . htmlspecialchars($value) . "'><br>";
                            break;

                        case 'date':
                            echo "<input type='date' id='$key' name='$key' value='" . htmlspecialchars($value) . "'><br>";
                            break;

                        case 'datetime':
                        case 'timestamp':
                            echo "<input type='datetime-local' id='$key' name='$key' value='" . htmlspecialchars(str_replace(' ', 'T', $value)) . "'><br>";
                            break;

                        case 'text':
                        case 'longtext':
                        case 'mediumtext':
                            echo "<textarea id='$key' name='$key'>" . htmlspecialchars($value) . "</textarea><br>";
                            break;

                        case 'varchar':
                        case 'char':
                        default:
                            echo "<input type='text' id='$key' name='$key' value='" . htmlspecialchars($value) . "'><br>";
                            break;
                    }
                    echo "</div>";
                }
            }
        }

        echo "<input type='submit' value='Salva Modifiche'>";
        echo "</form>";

        // Visualizza i record della tabella di dettaglio se le variabili sono valorizzate
        if ($tabellaDetail && $campoJoinMasterDetail) {
            echo "<h3>Record Correlati della Tabella " . htmlspecialchars($tabellaDetail) . "</h3>";
            visualizzaRecord($tabellaDetail, null, $campoJoinMasterDetail, $campiNascosti);
        }

    } else {
        echo "Record non trovato.";
    }

} catch (PDOException $e) {
    die("Errore nella query: " . $e->getMessage());
}
?>