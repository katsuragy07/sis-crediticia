<?php
session_start();
require_once "../../../connect.php";

$iduser = $_SESSION['id'];
$privilegios = $_SESSION['privilegios'];

$clave = $_GET['clave'];


switch($_GET['consulta']){ 
    case 'buscar':
                    if($clave==0){
                        $clave = date("Y-m-d");
                    }
                
                    if($privilegios=="ROOT" || $privilegios=="ADMINISTRADOR"){
                        $query = "
                        SELECT idtransferencia, transferencias.cajas_idcaja AS idcaja_ori, transferencias.cajas_idcaja1 AS idcaja_des, caja_ori.nombre AS caja_ori_nombre, caja_des.nombre AS caja_des_nombre, idusuario, tipo, monto, concepto, fecha_mov, autoriza, privilegios, usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                        FROM transferencias 
                        INNER JOIN  cajas caja_ori ON transferencias.cajas_idcaja = caja_ori.idcaja
						INNER JOIN  cajas caja_des ON transferencias.cajas_idcaja1 = caja_des.idcaja
                        INNER JOIN usuarios ON usuarios.idusuario = transferencias.usuarios_idusuario
                        WHERE fecha_mov LIKE '$clave%' ORDER BY fecha_mov DESC;
                        "; break;
                    }else{
                        $query = "
                        SELECT idtransferencia, transferencias.cajas_idcaja AS idcaja_ori, transferencias.cajas_idcaja1 AS idcaja_des, caja_ori.nombre AS caja_ori_nombre, caja_des.nombre AS caja_des_nombre, idusuario, tipo, monto, concepto, fecha_mov, autoriza, privilegios, usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                        FROM transferencias 
                        INNER JOIN  cajas caja_ori ON transferencias.cajas_idcaja = caja_ori.idcaja
						INNER JOIN  cajas caja_des ON transferencias.cajas_idcaja1 = caja_des.idcaja
                        INNER JOIN usuarios ON usuarios.idusuario = transferencias.usuarios_idusuario
                        WHERE (caja_ori.usuarios_idusuario = '$iduser' OR caja_des.usuarios_idusuario = '$iduser') AND (fecha_mov LIKE '$clave%') ORDER BY fecha_mov DESC;
                        "; break;
                    }
                    

    case 'editar': 
                $id = $_GET['id'];
                $query = "
                            SELECT * FROM cajas WHERE cajas.idcaja='$id';
                            "; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'idtransferencia' => $row['idtransferencia'],
        'idcaja_ori' => $row['idcaja_ori'],
        'idcaja_des' => $row['idcaja_des'],
        'idusuario' => $row['idusuario'],

        'caja_ori_nombre' => $row['caja_ori_nombre'],
        'caja_des_nombre' => $row['caja_des_nombre'],

        'tipo_mov' => $row['tipo'],
        'monto' => $row['monto'],
        'concepto' => $row['concepto'],
        'fecha_mov' => date("d-m-Y H:i:s",strtotime($row['fecha_mov'])),
        'autoriza' => $row['autoriza'],

        'privilegios' => $row['privilegios'],
        'usu_nombre' => $row['usu_nombre'],
        'usu_apellido_pat' => $row['usu_apellido_pat'],
        'usu_apellido_mat' => $row['usu_apellido_mat']
    );
    
   
}

echo json_encode($json);



?>