<?php

    require_once "../../connect.php";

    $id = $_POST['id']; 
    $operacion = $_POST['operacion'];

    if($operacion){
        $query = "UPDATE `usuarios` SET `habilitado`='SI' WHERE `idusuario`='$id';";
    }else{
        $query = "UPDATE `usuarios` SET `habilitado`='NO' WHERE `idusuario`='$id';";
    }
    
   
    $result = $mysqli->query($query);

    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        echo '200';
    }
 

?>