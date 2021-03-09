<?php

require_once "../../../connect.php";

switch($_GET['consulta']){
    case 'buscar':  $id = $_GET['id'];
                    $query = "SELECT * FROM consumo WHERE clientes_idcliente='$id';"; break;

    case 'editar':  $id = $_GET['id'];
                    $query = "SELECT * FROM consumo WHERE idconsumo='$id';"; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'id' => $row['idconsumo'],
        'dedicacion' => $row['dedicacion'],
        'tiempo' => $row['tiempo'],
        'ingreso' => $row['ingreso'],
        'lugar_trabajo' => $row['lugar_trabajo'],
        'profesion' => $row['profesion']
    );
   
}

echo json_encode($json);



?>