<?php

    require_once "../../connect.php";

    $id = $_POST['id'];

    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    }  
 
  
    $resultadoBD = false;

    if($id){
        $query = "UPDATE `usuarios` SET `telefono`='';";
    }else{
        $query = "UPDATE `usuarios` SET `telefono`='963852741';";
    }
    



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