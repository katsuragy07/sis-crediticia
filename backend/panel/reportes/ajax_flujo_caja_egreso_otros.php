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
        SELECT 	movimientos.idmovimiento, movimientos.monto, movimientos.concepto, movimientos.tipo_comprobante, movimientos.nro_comprobante,
		cajas.nombre AS caja_nombre
		FROM movimientos 
		INNER JOIN cajas ON cajas.idcaja = movimientos.cajas_idcaja
		WHERE (fecha_mov LIKE '$clave%') AND cajas.idcaja='$caja' AND movimientos.tipo = 'EGRESO' AND concepto != 'DESEMBOLSO DE CREDITO' ORDER BY fecha_mov DESC;
    "; 
}else{
    $query = "
        SELECT 	movimientos.idmovimiento, movimientos.monto, movimientos.concepto, movimientos.tipo_comprobante, movimientos.nro_comprobante,
		cajas.nombre AS caja_nombre
        FROM movimientos 
        INNER JOIN cajas ON cajas.idcaja = movimientos.cajas_idcaja
        WHERE (movimientos.usuarios_idusuario = '$iduser') AND (fecha_mov LIKE '%$clave%') AND cajas.idcaja='$caja' AND movimientos.tipo = 'EGRESO' AND concepto != 'DESEMBOLSO DE CREDITO' ORDER BY fecha_mov DESC;
    ";
}
                    




$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'idmovimiento' => $row['idmovimiento'],
        'monto' => $row['monto'],
        'concepto' => $row['concepto'],
        'caja_nombre' => $row['caja_nombre'],
        'tipo_comprobante' => $row['tipo_comprobante'],
        'nro_comprobante' => $row['nro_comprobante']
    );
    
   
}

echo json_encode($json);



?>