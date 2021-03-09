<?php

    require_once "../../../connect.php";

    $id = $_POST['id']; 
    $operacion = $_POST['operacion'];

    if($operacion){
        $query = "UPDATE `conyugue` SET `habilitado`='SI' WHERE `id`='$id';";
    }else{
        $query = "UPDATE `conyugue` SET `habilitado`='NO' WHERE `id`='$id';";
    }
    
   
    $result = $mysqli->query($query);

    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        echo '200';
    }
 

?>