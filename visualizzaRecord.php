<?php
require_once('db_connection.php');

if (!function_exists('visualizzaRecord')) {
    function visualizzaRecord($tabellaMaster, $tabellaDetail, $campoJoinMasterDetail, $campiNascosti) {
        global $pdo;

        // Esegue la query per ottenere i dati dalla tabella Master
        $query = "SELECT * FROM $tabellaMaster";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            echo "<table class='responsive-table'>";
            echo "<thead><tr>";
            foreach ($result[0] as $key => $value) {
                if (!in_array($key, $campiNascosti)) {
                    echo "<th>" . htmlspecialchars($key) . "</th>";
                }
            }
            echo "<th>Elimina</th></tr></thead>";
            echo "<tbody>";

            foreach ($result as $row) {
                $record_ID = $row[$campoJoinMasterDetail] ?? null;

                echo "<tr>";
                foreach ($row as $key => $value) {
                    if (!in_array($key, $campiNascosti)) {
                        // Creazione di un link per ciascun valore di campo
                        echo "<td><a href='detailRecord.php?record_ID=" . urlencode($record_ID) . "&table=$tabellaMaster&join=$campoJoinMasterDetail'>" . htmlspecialchars($value) . "</a></td>";
                    }
                }

                if (!empty($record_ID)) {
                    echo "<td><a href='deleteRecord.php?record_ID=" . urlencode($record_ID) . "&table=$tabellaMaster' onclick=\"return confirm('Sei sicuro di voler eliminare questo record?');\">Elimina</a></td>";
                } else {
                    echo "<td>Elimina non disponibile</td>";
                }
                echo "</tr>";
            }
            echo "</tbody></table>";
            echo "<a href='addRecord.php?table=$tabellaMaster'>Aggiungi</a>";
        } else {
            echo "0 risultati";
        }
    }
}
?>