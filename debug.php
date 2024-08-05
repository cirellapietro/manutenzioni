<?php
// Assicurati che non ci siano spazi o linee vuote prima di questo tag

function debug($string) {
    // Evita di inviare output se non necessario
    $debug = false; // Assicurati che la modalità debug sia disattivata per l'ambiente di produzione

    if ($debug) {
        echo '<div class="alert alert-danger" role="alert">';
        echo htmlspecialchars($string);
        echo '</div>';
    }
}
?>