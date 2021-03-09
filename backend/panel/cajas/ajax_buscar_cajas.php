<?php
    
    session_start();
    require_once "../../connect.php";

    $iduser = $_SESSION['id'];
    $privilegios = $_SESSION['privilegios'];

    if($privilegios=="CAJA"){
        $query = "SELECT * FROM cajas WHERE usuarios_idusuario = '$iduser' AND estado = 'ABIERTO';";
    }else{
        $query = "SELECT * FROM cajas WHERE estado = 'ABIERTO';";
    }
    


    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'idcaja' => $row['idcaja'],
            'nombre' => $row['nombre'],
            'capital' => $row['capital'],
            'estado' => $row['estado'],
            'fecha_creacion' => $row['fecha_creacion']
        );
        
       
    }
    
    echo json_encode($json);





?>