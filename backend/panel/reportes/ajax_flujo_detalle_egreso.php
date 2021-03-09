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
    $query = "
        SELECT sum(movimientos.monto) AS suma_cuotas
		FROM movimientos 
		INNER JOIN cajas ON cajas.idcaja = movimientos.cajas_idcaja
		WHERE (fecha_mov LIKE '$clave%') AND cajas.idcaja='$caja' AND movimientos.tipo = 'EGRESO' ORDER BY fecha_mov DESC;
    "; 
}else{
    $query = "
        SELECT sum(movimientos.monto) AS suma_cuotas
        FROM movimientos 
        INNER JOIN cajas ON cajas.idcaja = movimientos.cajas_idcaja
        WHERE (movimientos.usuarios_idusuario = '$iduser') AND (fecha_mov LIKE '%$clave%') AND cajas.idcaja='$caja' AND movimientos.tipo = 'EGRESO' ORDER BY fecha_mov DESC;
    ";
}
                    




$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'suma_egresos' => $row['suma_cuotas']
    );
    
   
}

echo json_encode($json);



?>