<?php

    require_once "../../connect.php";

    $id = $_POST['id']; 
    $operacion = $_POST['operacion'];

    if($operacion){
        $query = "UPDATE `cuenta_corriente` SET `estado`='HABILITADO' WHERE `idcuenta`='$id';";
    }else{
        $query = "UPDATE `cuenta_corriente` SET `estado`='DESHABILITADO' WHERE `idcuenta`='$id';";
    }
    
   
    $result = $mysqli->query($query);

    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        echo '200';
    }
 

?>