<?php
    
    session_start();
    require_once "../../connect.php";

    $clave = $_GET['clave'];


    $query = "SELECT * FROM usuarios WHERE concat(nombre,' ',apellido_pat,' ',apellido_mat) LIKE '%$clave%';";
    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'id' => $row['idusuario'],
            'nombre' => $row['nombre'],
            'apellido_pat' => $row['apellido_pat'],
            'apellido_mat' => $row['apellido_mat'],
            'privilegios' => $row['privilegios']
        );
        
       
    }
    
    echo json_encode($json);





?>