<?php
    
    session_start();
    require_once "../../connect.php";

    $id_adm = $_SESSION['id'];


    $query = "SELECT * FROM usuarios WHERE idusuario='$id_adm';";
    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'idcaja' => $row['idusuario'],
            'nombre' => $row['nombre'],
            'apellido_pat' => $row['apellido_pat'],
            'apellido_mat' => $row['apellido_mat']
        );
        
       
    }
    
    echo json_encode($json);





?>