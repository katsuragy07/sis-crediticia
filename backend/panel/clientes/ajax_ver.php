<?php

require_once "../../connect.php";

switch($_GET['consulta']){
    case 'buscar': $query = 'SELECT * FROM clientes ORDER BY idcliente DESC;'; break;
    case 'editar': $id = $_GET['id'];
                   $query = "SELECT * FROM clientes WHERE idcliente='$id';"; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'id' => $row['idcliente'],
        'dni' => $row['dni'],
        'apellido_pat' => $row['apellido_pat'],
        'apellido_mat' => $row['apellido_mat'],
        'nombre' => $row['nombre'],
        'ocupacion_tipo' => $row['ocupacion_tipo'],
        'ocupacion_des' => $row['ocupacion_des'],
        'nacimiento' => $row['nacimiento'],
        'hijos' => $row['hijos'],
        'grado_ins' => $row['grado_ins'],
        'estado_civ' => $row['estado_civ'],
        'lugar_nac' => $row['lugar_nac'],
        'direccion' => $row['direccion'],
        'referencia' => $row['referencia'],
        'tipo_viv' => $row['tipo_viv'],  
        'distrito' => $row['distrito'],
        'provincia' => $row['provincia'],
        'tiempo_viv' => $row['tiempo_viv'],
        'comentario' => $row['comentario'],     
        'url_foto' => $row['url_foto'],
        'url_domicilio' => $row['url_domicilio'],
        'inscripcion' => $row['inscripcion'],    
        'telefono' => $row['telefono'],
        'calificacion' => $row['calificacion'],
        'habilitado' => $row['habilitado'],
        'observaciones' => $row['observaciones']
    );
    
   
}

echo json_encode($json);



?>