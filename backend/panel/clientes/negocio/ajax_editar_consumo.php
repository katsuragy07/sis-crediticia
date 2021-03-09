<?php

    require_once "../../../connect.php";

    $id = $_POST['id']; 
 
    $dedicacion = $_POST['input_cons_DEDICA'];
    $tiempo = $_POST['input_cons_TIEMPO'];
    $ingreso = $_POST['input_cons_INGRESO'];
    $trabajo = $_POST['input_cons_TRABAJO'];
    $profesion = $_POST['input_cons_PROFESION'];


    /*
    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    }  
    */


    $resultadoBD = false;



    $query = "UPDATE `consumo` SET `dedicacion`='$dedicacion', `tiempo`='$tiempo', `ingreso`='$ingreso', `lugar_trabajo`='$trabajo', `profesion`='$profesion' WHERE `idconsumo`='$id';";
    

    
    $result = $mysqli->query($query);



   
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