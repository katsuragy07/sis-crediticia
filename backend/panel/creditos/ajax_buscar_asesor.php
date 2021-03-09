<?php
    
    session_start();
    require_once "../../connect.php";

    $id_asesor = $_SESSION['id'];


    $query = "SELECT * FROM usuarios WHERE idusuario='$id_asesor';";
    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'idusuario' => $row['idusuario'],
            'nombre' => $row['nombre'],
            'apellido_pat' => $row['apellido_pat'],
            'apellido_mat' => $row['apellido_mat']
        );
        
       
    }
    
    echo json_encode($json);





?>