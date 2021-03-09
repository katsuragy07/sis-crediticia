<?php
session_start();
require_once "../../connect.php";

$iduser = $_SESSION['id'];
$privilegios = $_SESSION['privilegios'];

$clave = $_GET['fecha'];
$caja = $_GET['caja'];


if($clave==0 || $clave==null || $clave==""){
    $clave = date("Y-m-d");
}
                


$query1 = "SELECT * FROM aperturas WHERE (fecha_apertura LIKE '$clave%') AND cajas_idcaja='$caja' ORDER BY fecha_apertura ASC LIMIT 1;"; 
$result1 = $mysqli->query($query1);
$query2 = "SELECT * FROM aperturas WHERE (fecha_cierre LIKE '$clave%') AND cajas_idcaja='$caja' ORDER BY fecha_cierre DESC LIMIT 1;"; 
$result2 = $mysqli->query($query2);
                    

if(!$result1){
    die("Query error " . mysqli_error($mysqli));
}
if(!$result2){
    die("Query error " . mysqli_error($mysqli));
}

$fecha_apertura;
$fecha_cierre;

while($row1 = $result1->fetch_array()){
    $fecha_apertura = date("h:i:s A",strtotime($row1['fecha_apertura']));
}

while($row2 = $result2->fetch_array()){
    $fecha_cierre = date("h:i:s A",strtotime($row2['fecha_cierre']));
}

$json = array();

  
    $json[] = array(
        'fecha_apertura' => $fecha_apertura,
        'fecha_cierre' => $fecha_cierre,
    );
    

echo json_encode($json);



?>