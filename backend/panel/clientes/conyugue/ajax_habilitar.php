<?php

    require_once "../../../connect.php";

    $id = $_POST['id']; 
    $operacion = $_POST['operacion'];
    $tipo = $_POST['tipo'];

    if($operacion){
        if($tipo=="CONYUGUE"){
            $query = "UPDATE `conyugue` SET `habilitado`='SI' WHERE `idconyugue`='$id';";
        }else{
            $query = "UPDATE `aval` SET `habilitado`='SI' WHERE `idconyugue`='$id';";
        } 
    }else{
        if($tipo=="CONYUGUE"){
            $query = "UPDATE `conyugue` SET `habilitado`='NO' WHERE `idconyugue`='$id';";
        }else{
            $query = "UPDATE `aval` SET `habilitado`='NO' WHERE `idconyugue`='$id';";
        }  
    }
    
   
    $result = $mysqli->query($query);

    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        echo '200';
    }
 

?>