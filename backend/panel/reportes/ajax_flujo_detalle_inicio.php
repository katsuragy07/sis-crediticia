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
                
if($privilegios=="ROOT" || $privilegios=="ADMINISTRADOR"){
    //$query = "SELECT * FROM aperturas WHERE (DATE(fecha_apertura) LIKE '$clave%') AND cajas_idcaja='$caja' ORDER BY fecha_apertura ASC LIMIT 1;"; 
    $query = "SELECT * FROM aperturas WHERE (date_add((fecha_cierre),INTERVAL +1 DAY) LIKE '$clave%') AND cajas_idcaja='$caja' ORDER BY fecha_cierre DESC LIMIT 1;"; 
}else{
    $query = "SELECT * FROM aperturas WHERE usuarios_idusuario = '$iduser' AND (date_add((fecha_cierre),INTERVAL +1 DAY) LIKE '$clave%') AND cajas_idcaja='$caja' ORDER BY fecha_cierre DESC LIMIT 1;";
}
                    



$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'monto_cierre' => $row['monto_cierre']
    );
    
   
}

echo json_encode($json);



?>