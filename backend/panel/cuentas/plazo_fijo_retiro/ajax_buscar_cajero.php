<?php
    
    session_start();
    require_once "../../connect.php";

    $id_caja = $_SESSION['id'];


    $query = "SELECT * FROM usuarios WHERE idusuario='$id_caja';";
    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'idcajero' => $row['idusuario'],
            'nombre' => $row['nombre'],
            'apellido_pat' => $row['apellido_pat'],
            'apellido_mat' => $row['apellido_mat']
        );
        
       
    }
    
    echo json_encode($json);





?>