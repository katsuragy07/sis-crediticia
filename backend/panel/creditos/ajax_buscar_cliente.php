<?php

    require_once "../../connect.php";

    $clave = $_GET['clave'];


    $query = "SELECT * FROM clientes WHERE concat(clientes.nombre,' ',clientes.apellido_pat,' ',clientes.apellido_mat) LIKE '%$clave%' LIMIT 10;";
    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'id' => $row['idcliente'],
            'nombre' => $row['nombre'],
            'apellido_pat' => $row['apellido_pat'],
            'apellido_mat' => $row['apellido_mat']
        );
        
       
    }
    
    echo json_encode($json);





?>