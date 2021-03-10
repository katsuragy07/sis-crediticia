<?php

date_default_timezone_set('America/Lima');

header('Content-Type: text/html; charset=utf-8');
define("SERVER", "beykmhusoekvcva8ujk8-mysql.services.clever-cloud.com");
define("USER", "udnkpboaxrvzkscu");
define("PASSWORD", "awqqEbDdwseFC4pFcS2P");
define("DBNAME", "beykmhusoekvcva8ujk8");

$mysqli = new mysqli(
    SERVER,USER,PASSWORD,DBNAME
);



/* verificar la conexión */
if (mysqli_connect_errno()) {
    printf("Falló la conexión failed: %s\n", $mysqli->connect_error);
    exit();
}

$mysqli->set_charset("utf8");
$mysqli->query("SET time_zone = '-05:00';");

//printf("Conjunto de caracteres inicial: %s\n", $mysqli->character_set_name());



?>
