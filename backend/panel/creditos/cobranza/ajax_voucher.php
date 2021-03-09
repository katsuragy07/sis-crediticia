<?php

require_once "../../../connect.php";
date_default_timezone_set("America/Lima");

$idvoucher = $_GET['idvoucher'];


$query = "
            SELECT 	idvoucher, monto_pago, fecha_pago, tipo_vp,
            creditos.idcredito, creditos.monto_aprob, creditos.n_cuotas_aprob, creditos.frecuencia,
            clientes.idcliente, clientes.dni AS cli_dni, clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat,
            usuarios.idusuario, usuarios.privilegios AS usu_privilegios, usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                    FROM voucher_pago 
                    INNER JOIN creditos ON creditos.idcredito = voucher_pago.creditos_idcredito
                    INNER JOIN clientes ON clientes.idcliente = creditos.clientes_idcliente
                    INNER JOIN usuarios ON usuarios.idusuario = voucher_pago.usuarios_idusuario
                    WHERE voucher_pago.idvoucher = '$idvoucher';
    ";



$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$fecha = date('d-m-Y H:i');
$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'fecha' => $fecha,
        'idvoucher' => $row['idvoucher'],
        'idcredito' => $row['idcredito'],
        'idcliente' => $row['idcliente'],
        'idusuario' => $row['idusuario'],

        'monto_pagado' => $row['monto_pago'],
        'fecha_pagado' => date("d-m-Y H:i:s",strtotime($row['fecha_pago'])),
      
        'monto_aprob' => $row['monto_aprob'],
        'n_cuotas_aprob' => $row['n_cuotas_aprob'],
        'frecuencia' => $row['frecuencia'],
        'tipo_vp' => $row['tipo_vp'],

        'cli_dni' => $row['cli_dni'],
        'cli_nombre' => $row['cli_nombre'],
        'cli_apellido_pat' => $row['cli_apellido_pat'],
        'cli_apellido_mat' => $row['cli_apellido_mat'],

        'usu_privilegios' => $row['usu_privilegios'],
        'usu_nombre' => $row['usu_nombre'],
        'usu_apellido_pat' => $row['usu_apellido_pat'],
        'usu_apellido_mat' => $row['usu_apellido_mat']
        
    );
    
   
}

echo json_encode($json);



?>