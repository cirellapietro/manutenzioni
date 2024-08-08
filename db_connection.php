<?php
// Configurazione del database
// Avvia la sessione se non è già stata avviata
/*
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
*/
//require_once('debug.php');
$hostTMP = $_SERVER['HTTP_HOST'];


$ip_address = explode(':', $hostTMP)[0];
    $host = $ip_address . ':' . 3306;

global $host;
global $dbname;
global $username;
global $password;

 
global $pdo;
//echo $_SERVER['HTTP_HOST'].'<br>';
//echo '>>>'.$hostTMP.'<<<'.'<br>';
//echo '>>>'.$ip_address.'<<<'.'<br>';

$valore1 = '0.0.0.0';
$valore2 = trim('equivalent-precauti.000webhostapp.com');
//$valore3 = '192.168.178.58:8080';
$valore3 = '192.168.178.58';
//substr($stringa, 0, 5)
try {
switch ($ip_address) {
  case $valore1:
    // Blocco di codice da eseguire se $espressione è uguale a $valore1
    //echo 'valore1';
    $host = $ip_address . ':' . 3306;
    $dbname = 'manutenzioni';
    $username = 'root';
    $password = 'root';
    $charset = 'utf8';
    
  break;
    
  case $valore2:
    // Blocco di codice da eseguire se $espressione è uguale a $valore2
    //echo 'valore2';
    $host = 'localhost';
    //$host = 'http://192.168.178.58:3306';
    $dbname = 'id20821487_manutenzioni';
    $username = 'id20821487_pietro';
    $password = '%gWkF>clF8V$(]{O';
    
  break;
    
  case $valore3:
    // Blocco di codice da eseguire se $espressione è uguale a $valore1

    //echo 'valore1';
    $host = $ip_address . ':' . 3306;
    $dbname = 'manutenzioni';
    $username = 'root';
    $password = 'root';
    $charset = 'utf8';
    
  break;
    
    
  default:
    // Blocco di codice da eseguire se $espressione non è uguale a nessuno dei valori precedenti
    $host = "";
    echo "nessuna connessione DB estremi non validi";
}

 if($host!=""){
    //echo '>>>'.$host.'<<<';
    // Crea un'istanza di PDO
   
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Imposta PDO per lanciare eccezioni in caso di errore
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //$pdo=initDb();
	//echo 'Connessione effettuata';
 } 
    // Sarà utilizzato nelle pagine che importano questo file per operazioni sul database
} catch (PDOException $e) {
    // Gestisci gli errori di connessione
    //echo "Connessione fallita: " . $e->getMessage();
    // Registra o gestisci l'errore come necessario
    // Stampa le informazioni di connessione a schermo

var_dump($host, $dbname, $username, $password);
}
session_write_close();

if (!function_exists('initDb')) {
    function initDb() {
      debug("initDb INIZIO");
      // Inizializza l'oggetto PDO
      $conndb = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
      $conndb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        debug("initDb FINE");
    return $conndb;
  }
}


?>