<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");

    $caja_nombre = $_POST['caja_nombre'];
    $caja_capital = $_POST['caja_capital'];
    $iduser = $_POST['caja_autor-hidden'];
    
    $resultadoBD = false;

    $query = "INSERT INTO billetaje(idbilletaje) VALUES (NULL);";
    $result = $mysqli->query($query);

    $query = "INSERT INTO cajas(nombre,capital,estado,billetaje_reg,fecha_creacion,usuarios_idusuario,billetaje_idbilletaje) VALUES ('$caja_nombre','$caja_capital','DESHABILITADO','NO', NOW(),'$iduser',(SELECT MAX(idbilletaje) FROM billetaje));";
    
    $result = $mysqli->query($query);

    

    if($result){
        $resultadoBD = true;
    }else{   
        die("Query error " . mysqli_error($mysqli));
        $resultadoBD = false;
    }


    if($resultadoBD){
        echo '200';
    }else{
        echo '302';
    }
  







?>