<?php

    require_once "../../../connect.php";

    $id = $_POST['id']; 
    $operacion = $_POST['operacion'];

    if($operacion){
        $query = "UPDATE `cajas` SET `estado`='CERRADO' WHERE `idcaja`='$id';";
    }else{
        $query = "UPDATE `cajas` SET `estado`='DESHABILITADO' WHERE `idcaja`='$id';";
    }
    
   
    $result = $mysqli->query($query);

    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        echo '200';
    }
 

?>