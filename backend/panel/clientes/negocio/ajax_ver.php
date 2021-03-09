<?php

require_once "../../../connect.php";

switch($_GET['consulta']){
    case 'buscar':  $id = $_GET['id'];
                    $query = "SELECT * FROM negocio WHERE clientes_idcliente='$id';"; break;

    case 'editar':  $id = $_GET['id'];
                    $query = "SELECT * FROM negocio WHERE idnegocio='$id';"; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'id' => $row['idnegocio'],
        'tipo' => $row['tipo'],
        'norm_tipo' => $row['norm_tipo'],
        'norm_tipo_local' => $row['norm_tipo_local'],
        'norm_tipo_negocio' => $row['norm_tipo_negocio'],
        'tiempo' => $row['tiempo'],
        'trans_tipo' => $row['trans_tipo'],
        'trans_placa' => $row['trans_placa'],
        'trans_empresa' => $row['trans_empresa'],
        'trans_direccion' => $row['trans_direccion'],
        'trans_soat' => $row['trans_soat'],
        'trans_soat_cad' => $row['trans_soat_cad'],
        'trans_tarjeta' => $row['trans_tarjeta'],
        'trans_tarjeta_cad' => $row['trans_tarjeta_cad'],
        'url_croquis' => $row['url_croquis']
    );
   
}

echo json_encode($json);



?>