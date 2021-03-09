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
        SELECT 	movimientos.idmovimiento, movimientos.monto, movimientos.concepto,
		cajas.nombre AS caja_nombre,
		clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat,
		usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat,
		creditos.frecuencia 
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
        SELECT 	movimientos.idmovimiento, movimientos.monto, movimientos.concepto,
        cajas.nombre AS caja_nombre,
        clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat,
        usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat,
        creditos.frecuencia 
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
        'idmovimiento' => $row['idmovimiento'],
    
        'monto' => $row['monto'],
        'concepto' => $row['concepto'],
        'caja_nombre' => $row['caja_nombre'],
        'frecuencia' => $row['frecuencia'],

        'cli_nombre' => $row['cli_nombre'],
        'cli_apellido_pat' => $row['cli_apellido_pat'],
        'cli_apellido_mat' => $row['cli_apellido_mat'],

        'usu_nombre' => $row['usu_nombre'],
        'usu_apellido_pat' => $row['usu_apellido_pat'],
        'usu_apellido_mat' => $row['usu_apellido_mat']
    );
    
   
}

echo json_encode($json);



?>