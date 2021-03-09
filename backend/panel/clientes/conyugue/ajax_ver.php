<?php

require_once "../../../connect.php";

switch($_GET['consulta']){
    case 'buscar':  $id = $_GET['id'];
                    $query = "SELECT * FROM conyugue WHERE clientes_idcliente='$id' UNION ALL SELECT * FROM aval WHERE clientes_idcliente='$id';"; break;

    case 'editar':  $id = $_GET['id'];
                    $tipo = $_GET['tipo'];
                    if($tipo=="CONYUGUE"){
                        $query = "SELECT * FROM conyugue WHERE idconyugue='$id';";
                    }else{
                        $query = "SELECT * FROM aval WHERE idconyugue='$id';";
                    }
                    break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'id' => $row['idconyugue'],
        'dni' => $row['dni'],
        'apellido_pat' => $row['apellido_pat'],
        'apellido_mat' => $row['apellido_mat'],
        'nombre' => $row['nombre'],
        'nacimiento' => $row['nacimiento'],
        'sexo' => $row['sexo'],
        'direccion' => $row['direccion'],
        'referencia' => $row['referencia'],
        'ocupacion' => $row['ocupacion'],
        'dir_trabajo' => $row['dir_trabajo'],
        'parentesco' => $row['parentesco'],
        'tipo' => $row['tipo'],
        'habilitado' => $row['habilitado'],
        'idcliente' => $row['clientes_idcliente']
    );
    
   
}

echo json_encode($json);



?>