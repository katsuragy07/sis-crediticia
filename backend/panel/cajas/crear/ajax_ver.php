<?php

require_once "../../../connect.php";

switch($_GET['consulta']){
    case 'buscar': $query = "
                            SELECT cajas.idcaja, cajas.nombre, cajas.capital, cajas.billetaje_reg, cajas.estado, cajas.fecha_creacion, usuarios.idusuario, usuarios.nombre as user_nombre, usuarios.apellido_pat, usuarios.apellido_mat FROM cajas INNER JOIN usuarios ON cajas.usuarios_idusuario = usuarios.idusuario;
                            "; break;

    case 'editar': $id = $_GET['id'];
                   $query = "
                            SELECT cajas.idcaja, cajas.nombre, cajas.capital, cajas.billetaje_reg, cajas.estado, cajas.fecha_creacion, usuarios.idusuario, usuarios.nombre as user_nombre, usuarios.apellido_pat, usuarios.apellido_mat FROM cajas INNER JOIN usuarios ON cajas.usuarios_idusuario = usuarios.idusuario WHERE cajas.idcaja='$id';
                            "; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'idcaja' => $row['idcaja'],
        'idusuario' => $row['idusuario'],
        'nombre' => $row['nombre'],
        'capital' => $row['capital'],
        'estado' => $row['estado'],
        'billetaje_reg' => $row['billetaje_reg'],
        'fecha_creacion' => $row['fecha_creacion'],

        'user_nombre' => $row['user_nombre'],
        'apellido_pat' => $row['apellido_pat'],
        'apellido_mat' => $row['apellido_mat']


    );
    
   
}

echo json_encode($json);



?>