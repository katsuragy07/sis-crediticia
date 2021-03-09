<?php

    require_once "../../connect.php";

    $id = $_POST['id']; 
    $operacion = $_POST['operacion'];

    if($operacion){
        $query = "UPDATE `clientes` SET `habilitado`='SI' WHERE `idcliente`='$id';";
    }else{
        $query = "UPDATE `clientes` SET `habilitado`='NO' WHERE `idcliente`='$id';";
    }
    
   
    $result = $mysqli->query($query);

    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        echo '200';
    }
 

?>