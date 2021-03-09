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
		INNER JOIN creditos ON movimientos.creditos_idcredito = creditos.idcredito
		INNER JOIN clientes ON creditos.clientes_idcliente = clientes.idcliente
		INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
		INNER JOIN usuarios ON usuarios.idusuario = solicitudes.usuarios_idusuario
		WHERE (fecha_mov LIKE '$clave%') AND cajas.idcaja='$caja' AND movimientos.tipo = 'INGRESO' ORDER BY fecha_mov DESC;
    "; 
}else{
    $query = "
        SELECT sum(movimientos.monto) AS suma_cuotas
        FROM movimientos 
        INNER JOIN cajas ON cajas.idcaja = movimientos.cajas_idcaja
        INNER JOIN creditos ON movimientos.creditos_idcredito = creditos.idcredito
        INNER JOIN clientes ON creditos.clientes_idcliente = clientes.idcliente
        INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
        INNER JOIN usuarios ON usuarios.idusuario = solicitudes.usuarios_idusuario
        WHERE (movimientos.usuarios_idusuario = '$iduser') AND (fecha_mov LIKE '%$clave%') AND cajas.idcaja='$caja' AND movimientos.tipo = 'INGRESO' ORDER BY fecha_mov DESC;
    ";
}
                    




$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'suma_cuotas' => $row['suma_cuotas']
    );
    
   
}

echo json_encode($json);



?>