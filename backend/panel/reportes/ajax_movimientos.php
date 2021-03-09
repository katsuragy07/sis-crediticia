<?php
session_start();
require_once "../../connect.php";

$iduser = $_SESSION['id'];
$privilegios = $_SESSION['privilegios'];

$inicio = $_GET['inicio'];
$fin = $_GET['fin'];

if($inicio==null || $inicio == ""){
    $inicio = date("Y-m-d");
}

if($fin==null || $fin == ""){
    $fin = date("Y-m-d");
}

switch($_GET['consulta']){ 
    case 'buscar':
                    if($privilegios=="ROOT" || $privilegios=="ADMINISTRADOR"){
                        $query = "
                        SELECT idmovimiento, idcaja, idusuario, tipo, monto, concepto, fecha_mov, autoriza, cajas.nombre AS caja_nombre, capital, estado, privilegios, usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                        FROM movimientos 
                        INNER JOIN  cajas ON movimientos.cajas_idcaja = cajas.idcaja
                        INNER JOIN usuarios ON usuarios.idusuario = movimientos.usuarios_idusuario
                        WHERE DATE(fecha_mov) >= '$inicio' AND DATE(fecha_mov) <= '$fin' ORDER BY fecha_mov ASC;
                        "; break;
                    }else{
                        $query = "
                        SELECT idmovimiento, idcaja, idusuario, tipo, monto, concepto, fecha_mov, autoriza, cajas.nombre AS caja_nombre, capital, estado, privilegios, usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                        FROM movimientos 
                        INNER JOIN  cajas ON movimientos.cajas_idcaja = cajas.idcaja
                        INNER JOIN usuarios ON usuarios.idusuario = movimientos.usuarios_idusuario
                        WHERE (movimientos.usuarios_idusuario = '$iduser') AND (DATE(fecha_mov) >= '$inicio' AND DATE(fecha_mov) <= '$fin') ORDER BY fecha_mov ASC;
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
        'idmovimiento' => $row['idmovimiento'],
        'idcaja' => $row['idcaja'],
        'idusuario' => $row['idusuario'],

        'tipo_mov' => $row['tipo'],
        'monto' => $row['monto'],
        'concepto' => $row['concepto'],
        'fecha_mov' => date("d-m-Y H:i:s",strtotime($row['fecha_mov'])),
        'autoriza' => $row['autoriza'],

        'caja_nombre' => $row['caja_nombre'],

        'privilegios' => $row['privilegios'],
        'usu_nombre' => $row['usu_nombre'],
        'usu_apellido_pat' => $row['usu_apellido_pat'],
        'usu_apellido_mat' => $row['usu_apellido_mat']
    );
    
   
}

echo json_encode($json);



?>