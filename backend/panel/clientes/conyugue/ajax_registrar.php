<?php

    require_once "../../../connect.php";

    $id_cliente = $_POST['id_cliente'];

    $apellido_pat = $_POST['input_con_AP'];
    $apellido_mat = $_POST['input_con_AM'];
    $nombre = $_POST['input_con_NOM'];
    $dni = $_POST['input_con_DNI'];
    $sexo = $_POST['input_con_SEXO'];
    $nacimiento = $_POST['input_con_FN'];
    $direccion = $_POST['input_con_DIR'];
    $referencia = $_POST['input_con_REF'];
    $ocupacion = $_POST['input_con_OCUP'];
    $dir_trabajo = $_POST['input_con_DIRT'];
    $parentesco = $_POST['input_con_PT'];
    $tipo = $_POST['input_con_CA'];

   

    /*
    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    } 
    */ 
    //Modo de uso 
    //$comentario = saltoLinea($comentario);
    

    $resultadoBD = false;

    if($tipo=="CONYUGUE"){
        $query = "INSERT INTO conyugue(dni,apellido_pat,apellido_mat,nombre,sexo,nacimiento,direccion,referencia,ocupacion,dir_trabajo,parentesco,tipo,clientes_idcliente,habilitado) VALUES ('$dni','$apellido_pat','$apellido_mat','$nombre','$sexo','$nacimiento','$direccion','$referencia','$ocupacion','$dir_trabajo','$parentesco','$tipo','$id_cliente','SI');"; 
    }else{
        $query = "INSERT INTO aval(dni,apellido_pat,apellido_mat,nombre,sexo,nacimiento,direccion,referencia,ocupacion,dir_trabajo,parentesco,tipo,clientes_idcliente,habilitado) VALUES ('$dni','$apellido_pat','$apellido_mat','$nombre','$sexo','$nacimiento','$direccion','$referencia','$ocupacion','$dir_trabajo','$parentesco','$tipo','$id_cliente','SI');"; 
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