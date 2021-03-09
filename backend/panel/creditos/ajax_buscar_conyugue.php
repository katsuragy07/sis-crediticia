<?php

    require_once "../../connect.php";

    $clave = $_GET['clave'];
    $idcliente = $_GET['idcliente'];


    $query = "SELECT * FROM conyugue WHERE clientes_idcliente = '$idcliente' AND tipo = 'CONYUGUE' AND concat(conyugue.nombre,' ',conyugue.apellido_pat,' ',conyugue.apellido_mat) LIKE '%$clave%' LIMIT 10;";
    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'id' => $row['idconyugue'],
            'nombre' => $row['nombre'],
            'apellido_pat' => $row['apellido_pat'],
            'apellido_mat' => $row['apellido_mat']
        );
        
       
    }
    
    echo json_encode($json);





?>