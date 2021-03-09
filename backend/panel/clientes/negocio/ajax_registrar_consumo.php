<?php

    require_once "../../../connect.php";

    $id_cliente = $_POST['id_cliente'];
  
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
    


    $query = "INSERT INTO consumo (dedicacion,tiempo,ingreso,lugar_trabajo,profesion,clientes_idcliente) VALUES ('$dedicacion','$tiempo','$ingreso','$trabajo','$profesion','$id_cliente');";   


    
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