<?php

    require_once "../../../connect.php";

    $id = $_POST['id']; 

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
    $con_tipo = $_POST['input_con_CA'];
    $tipo = $_POST['tipo'];
    $id_cliente = $_POST['input_con_IDCLI'];

    /*
    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    }  
    */

 
    $resultadoBD = false;

    if($tipo=="CONYUGUE"){
        if($con_tipo=="CONYUGUE"){
            $query = "UPDATE `conyugue` SET `dni`='$dni',`apellido_pat`='$apellido_pat',`apellido_mat`='$apellido_mat',`nombre`='$nombre',`nacimiento`='$nacimiento',`sexo`='$sexo',`direccion`='$direccion',`referencia`='$referencia',`ocupacion`='$ocupacion',`dir_trabajo`='$dir_trabajo',`parentesco`='$parentesco',`tipo`='$tipo' WHERE `idconyugue`='$id';";
        }else{
            $query = "INSERT INTO aval(dni,apellido_pat,apellido_mat,nombre,sexo,nacimiento,direccion,referencia,ocupacion,dir_trabajo,parentesco,tipo,clientes_idcliente,habilitado) VALUES ('$dni','$apellido_pat','$apellido_mat','$nombre','$sexo','$nacimiento','$direccion','$referencia','$ocupacion','$dir_trabajo','$parentesco','$con_tipo','$id_cliente','SI');"; 
            $query.= "DELETE FROM conyugue WHERE `idconyugue`='$id';";
        }
        
    }else{
        if($con_tipo=="AVAL"){
            $query = "UPDATE `aval` SET `dni`='$dni',`apellido_pat`='$apellido_pat',`apellido_mat`='$apellido_mat',`nombre`='$nombre',`nacimiento`='$nacimiento',`sexo`='$sexo',`direccion`='$direccion',`referencia`='$referencia',`ocupacion`='$ocupacion',`dir_trabajo`='$dir_trabajo',`parentesco`='$parentesco',`tipo`='$tipo' WHERE `idconyugue`='$id';";
        }else{
            $query = "INSERT INTO conyugue(dni,apellido_pat,apellido_mat,nombre,sexo,nacimiento,direccion,referencia,ocupacion,dir_trabajo,parentesco,tipo,clientes_idcliente,habilitado) VALUES ('$dni','$apellido_pat','$apellido_mat','$nombre','$sexo','$nacimiento','$direccion','$referencia','$ocupacion','$dir_trabajo','$parentesco','$con_tipo','$id_cliente','SI');"; 
            $query.= "DELETE FROM aval WHERE `idconyugue`='$id';";
        }
        
    }
    
    
    $result = $mysqli->multi_query($query);



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