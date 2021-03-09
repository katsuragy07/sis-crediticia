<?php

require_once "../../connect.php";

switch($_GET['consulta']){
    case 'buscar': $query = 'SELECT * FROM usuarios;'; break;
    case 'editar': $id = $_GET['id'];
                   $query = "SELECT * FROM usuarios WHERE idusuario='$id';"; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'id' => $row['idusuario'],
        'privilegios' => $row['privilegios'],
        'apellido_pat' => $row['apellido_pat'],
        'apellido_mat' => $row['apellido_mat'],
        'nombre' => $row['nombre'],
        'doc_nro' => $row['doc_nro'],
        'usuario' => $row['usuario'],
        'pass' => $row['pass'],
        'nacimiento' => $row['nacimiento'],
        'grado' => $row['grado'],
        'estado_civil' => $row['estado_civil'],
        'lugar_nacimiento' => $row['lugar_nacimiento'],
        'comentarios' => $row['comentarios'],
        'telefono' => $row['telefono'],
        'direccion' => $row['direccion'],
        'referencia' => $row['referencia'],
        'distrito' => $row['distrito'],
        'provincia' => $row['provincia'],
        'correo' => $row['correo'],
        'url_foto' => $row['url_foto'],
        'habilitado' => $row['habilitado']
    );
    
   
}

echo json_encode($json);



?>