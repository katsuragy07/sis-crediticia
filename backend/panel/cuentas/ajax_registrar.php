<?php

    require_once "../../connect.php";
  

    $iduser = $_POST['iduser'];
    $idcliente = $_POST['inputCLIENT-hidden'];

   

    
    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    }  
    //Modo de uso 
  
    

    $resultadoBD = false;

   
    $query = "INSERT INTO cuenta_corriente(monto,fecha_apertura,estado,clientes_idcliente,usuarios_idusuario) VALUES('0',now(),'HABILITADO','$idcliente','$iduser');";

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