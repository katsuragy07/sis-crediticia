<?php

    require_once "../../../connect.php";

    $idcaja = $_POST['id'];
    $caja_nombre = $_POST['caja_nombre-edt'];
    $caja_capital = $_POST['caja_capital-edt'];
    $iduser = $_POST['caja_autor-hidden-edt'];

    $caja_hab_billetaje = $_POST['caja_hab_billetaje'];


    $resultadoBD = false;


    $query = "UPDATE `cajas` SET `nombre`='$caja_nombre', `billetaje_reg`='$caja_hab_billetaje', `usuarios_idusuario`='$iduser' WHERE idcaja = '$idcaja';";
    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        $resultadoBD = true;
    }


    if($resultadoBD){
        echo '200';
    }else{
        echo '302';
    }



?>