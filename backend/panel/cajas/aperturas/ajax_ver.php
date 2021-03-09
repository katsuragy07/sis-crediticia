<?php
session_start();
require_once "../../../connect.php";

$iduser = $_SESSION['id'];
$privilegios = $_SESSION['privilegios'];


switch($_GET['consulta']){
    case 'buscar': 
                    if($privilegios=="CAJA"){
                        $query = "SELECT cajas.idcaja, cajas.nombre, cajas.billetaje_reg, cajas.capital, cajas.estado, cajas.fecha_creacion, usuarios.idusuario, usuarios.nombre as user_nombre, usuarios.apellido_pat, usuarios.apellido_mat, usuarios.privilegios, cant_200, cant_100, cant_50, cant_20, cant_10, cant_5, cant_2, cant_1, cant_0_5, cant_0_2, cant_0_1 
                                    FROM cajas INNER JOIN usuarios ON cajas.usuarios_idusuario = usuarios.idusuario
                                    LEFT JOIN billetaje ON billetaje.idbilletaje = cajas.billetaje_idbilletaje
                                    WHERE estado != 'DESHABILITADO' AND usuarios_idusuario = '$iduser';"; 
                    }else{
                        $query = "SELECT cajas.idcaja, cajas.nombre, cajas.billetaje_reg, cajas.capital, cajas.estado, cajas.fecha_creacion, usuarios.idusuario, usuarios.nombre as user_nombre, usuarios.apellido_pat, usuarios.apellido_mat, usuarios.privilegios, cant_200, cant_100, cant_50, cant_20, cant_10, cant_5, cant_2, cant_1, cant_0_5, cant_0_2, cant_0_1
                                    FROM cajas INNER JOIN usuarios ON cajas.usuarios_idusuario = usuarios.idusuario 
                                    LEFT JOIN billetaje ON billetaje.idbilletaje = cajas.billetaje_idbilletaje
                                    WHERE estado != 'DESHABILITADO';"; 
                    }
                    break;

    case 'editar': $id = $_GET['id'];
                   $query = "SELECT cajas.idcaja, cajas.nombre, cajas.billetaje_reg, cajas.capital, cajas.estado, cajas.fecha_creacion, usuarios.idusuario, usuarios.nombre as user_nombre, usuarios.apellido_pat, usuarios.apellido_mat, usuarios.privilegios, cant_200, cant_100, cant_50, cant_20, cant_10, cant_5, cant_2, cant_1, cant_0_5, cant_0_2, cant_0_1
                                    FROM cajas INNER JOIN usuarios ON cajas.usuarios_idusuario = usuarios.idusuario 
                                    LEFT JOIN billetaje ON billetaje.idbilletaje = cajas.billetaje_idbilletaje
                                    WHERE cajas.idcaja='$id';"; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'idcaja' => $row['idcaja'],
        'nombre' => $row['nombre'],
        'capital' => $row['capital'],
        'nombre' => $row['nombre'],
        'capital' => $row['capital'],
        'estado' => $row['estado'],
        'billetaje_reg' => $row['billetaje_reg'],
        'fecha_creacion' => $row['fecha_creacion'],

        'm200' => $row['cant_200'],
        'm100' => $row['cant_100'],
        'm50' => $row['cant_50'],
        'm20' => $row['cant_20'],
        'm10' => $row['cant_10'],
        'm5' => $row['cant_5'],
        'm2' => $row['cant_2'],
        'm1' => $row['cant_1'],
        'm0_5' => $row['cant_0_5'],
        'm0_2' => $row['cant_0_2'],
        'm0_1' => $row['cant_0_1'],

        'privilegios' => $privilegios,
        'user_nombre' => $row['user_nombre'],
        'apellido_pat' => $row['apellido_pat'],
        'apellido_mat' => $row['apellido_mat']
    );
    
   
}

echo json_encode($json);



?>