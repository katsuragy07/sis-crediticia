<?php

require_once "../../../connect.php";
date_default_timezone_set("America/Lima");

switch($_GET['consulta']){
    case 'editar': $id = $_GET['id'];
                   $query = "
                        SELECT idtransferencia, transferencias.cajas_idcaja AS idcaja_ori, transferencias.cajas_idcaja1 AS idcaja_des, caja_ori.nombre AS caja_ori_nombre, caja_des.nombre AS caja_des_nombre, tipo, monto, concepto, fecha_mov, autoriza, cajero.privilegios AS usu_privilegios, 
                        cajero.idusuario AS usu_idusuario,cajero.nombre AS usu_nombre, cajero.apellido_pat AS usu_apellido_pat, cajero.apellido_mat AS usu_apellido_mat,
                        autoriza.idusuario AS autoriza_idusuario,autoriza.nombre AS autoriza_nombre, autoriza.apellido_pat AS autoriza_apellido_pat, autoriza.apellido_mat AS autoriza_apellido_mat
                        FROM transferencias 
                        INNER JOIN  cajas caja_ori ON transferencias.cajas_idcaja = caja_ori.idcaja
                        INNER JOIN  cajas caja_des ON transferencias.cajas_idcaja1 = caja_des.idcaja
                        INNER JOIN usuarios cajero ON cajero.idusuario = transferencias.usuarios_idusuario
                        INNER JOIN usuarios autoriza ON autoriza.idusuario = transferencias.usuarios_idusuario1
                        WHERE transferencias.idtransferencia = '$id';
                            "; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$fecha = date('d-m-Y H:i');
$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'idtransferencia' => $row['idtransferencia'],
        'idcaja_ori' => $row['idcaja_ori'],
        'idcaja_des' => $row['idcaja_des'],
        'idusuario' => $row['usu_idusuario'],

        'caja_ori_nombre' => $row['caja_ori_nombre'],
        'caja_des_nombre' => $row['caja_des_nombre'],

        'tipo_mov' => $row['tipo'],
        'monto' => $row['monto'],
        'concepto' => $row['concepto'],
        'fecha_mov' => date("d-m-Y H:i:s",strtotime($row['fecha_mov'])),
        'autoriza' => $row['autoriza'],

        'privilegios' => $row['usu_privilegios'],
        'usu_nombre' => $row['usu_nombre'],
        'usu_apellido_pat' => $row['usu_apellido_pat'],
        'usu_apellido_mat' => $row['usu_apellido_mat'],

        'autoriza_nombre' => $row['autoriza_nombre'],
        'autoriza_apellido_pat' => $row['autoriza_apellido_pat'],
        'autoriza_apellido_mat' => $row['autoriza_apellido_mat']
    );
    
   
}

echo json_encode($json);



?>