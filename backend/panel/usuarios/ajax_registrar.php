<?php

    require_once "../../connect.php";

    $editURL = $_POST['editURLimg'];
    
    $privilegios = $_POST['inputPRIV'];
    $apellido_pat = $_POST['inputAP'];
    $apellido_mat = $_POST['inputAM'];
    $nombres = $_POST['inputNOM'];
    $dni = $_POST['inputDNI'];
    $user = $_POST['inputUSER'];
    $pass = $_POST['inputPASS'];
    $fecha_nacimiento = $_POST['inputNAC'];
    $grado = $_POST['inputGRADO'];
    $estado_civil = $_POST['inputEC'];
    $lugar_nacimiento = $_POST['inputLN'];
    $comentarios = $_POST['inputCOM'];
    $telefono = $_POST['inputTEL'];
    $direccion = $_POST['inputDIR'];
    $referencia = $_POST['inputREF'];
    $distrito = $_POST['inputDIS'];
    $provincia = $_POST['inputPROV'];
    $correo = $_POST['inputEMAIL'];

    
    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    }  
    //Modo de uso 
    $comentarios = saltoLinea($comentarios);
    

    
    $resultadoUP = false;
    $resultadoBD = false;
    
    $uploadedFile = '';

    if($editURL){
        $uploadedFile = '';
        if(!empty($_FILES["inputIMG"]["type"])){
            $fileName = uniqid();
            $valid_extensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["inputIMG"]["name"]);
            $file_extension = strtolower(end($temporary));
            $fileName = $fileName.".".$file_extension;
            if((($_FILES["inputIMG"]["type"] == "video/mp4") || ($_FILES["inputIMG"]["type"] == "video/webm") || ($_FILES["inputIMG"]["type"] == "video/ogv") || ($_FILES["inputIMG"]["type"] == "image/png") || ($_FILES["inputIMG"]["type"] == "image/jpg") || ($_FILES["inputIMG"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                $sourcePath = $_FILES['inputIMG']['tmp_name'];
                $targetPath = "../../../img/upload/usuarios/".$fileName;
                if(move_uploaded_file($sourcePath,$targetPath)){
                    $uploadedFile = $fileName;
                    $resultadoUP = true;
                }
            }
        }
        
        if($resultadoUP){
            $query = "INSERT INTO usuarios(privilegios,apellido_pat,apellido_mat,nombre,doc_nro,usuario,pass,nacimiento,grado,estado_civil,lugar_nacimiento,comentarios,telefono,direccion,referencia,distrito,provincia,correo,habilitado,url_foto) VALUES ('$privilegios','$apellido_pat','$apellido_mat','$nombres','$dni','$user','$pass','$fecha_nacimiento','$grado','$estado_civil','$lugar_nacimiento','$comentarios','$telefono','$direccion','$referencia','$distrito','$provincia','$correo','SI','$uploadedFile');";   
        }
    }else{
        $query = "INSERT INTO usuarios(privilegios,apellido_pat,apellido_mat,nombre,doc_nro,usuario,pass,nacimiento,grado,estado_civil,lugar_nacimiento,comentarios,telefono,direccion,referencia,distrito,provincia,correo,habilitado) VALUES ('$privilegios','$apellido_pat','$apellido_mat','$nombres','$dni','$user','$pass','$fecha_nacimiento','$grado','$estado_civil','$lugar_nacimiento','$comentarios','$telefono','$direccion','$referencia','$distrito','$provincia','$correo','SI');";   
        $resultadoUP = true;
    }

        
    
    if($resultadoUP){
    
        $result = $mysqli->query($query);
    
        if(!$result){
            die("Query error " . mysqli_error($mysqli));
        }else{
            $resultadoBD = true;
        }
    }
    
    if($resultadoUP){
        if($resultadoBD){
            echo '200';
        }else{
            echo '302';
        }
    }else{
        echo '301';
    }
    








?>