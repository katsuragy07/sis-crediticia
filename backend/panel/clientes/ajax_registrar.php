<?php

    require_once "../../connect.php";

    $editURL1 = $_POST['editURLimg'];
    $editURL2 = $_POST['editURLimg2'];
    
    $dni = $_POST['inputDNI'];
    $apellido_pat = $_POST['inputAP'];
    $apellido_mat = $_POST['inputAM'];
    $nombres = $_POST['inputNOM'];
    $ocupacion_tipo = $_POST['inputOCUPACION_TIPO'];
    $ocupacion_des = $_POST['inputOCUPACION_DES'];
    $nacimiento = $_POST['inputNAC'];
    $hijos = $_POST['inputNH'];
    $grado_ins = $_POST['inputGRADO'];
    $estado_civ = $_POST['inputEC'];
    $lugar_nac = $_POST['inputLN'];
    $direccion = $_POST['inputDIR'];
    $referencia = $_POST['inputREF'];
    $tipo_viv = $_POST['inputDOM'];
    $distrito = $_POST['inputDIS'];
    $provincia = $_POST['inputPROV'];
    $tiempo_viv = $_POST['inputTR'];
    $comentario = $_POST['inputCOM'];
    $inscripcion = $_POST['inputINS'];
    $telefono = $_POST['inputTEL'];
   

    
    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    }  
    //Modo de uso 
    $comentario = saltoLinea($comentario);
    

    
    $resultadoUP1 = false;
    $resultadoUP2 = false;
    $resultadoBD = false;

    
    $uploadedFile1 = '';
    $uploadedFile2 = '';

    if($editURL1){
        $uploadedFile1 = '';
        if(!empty($_FILES["inputIMG"]["type"])){
            $fileName = uniqid();
            $valid_extensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["inputIMG"]["name"]);
            $file_extension = strtolower(end($temporary));
            $fileName = $fileName.".".$file_extension;
            if((($_FILES["inputIMG"]["type"] == "video/mp4") || ($_FILES["inputIMG"]["type"] == "video/webm") || ($_FILES["inputIMG"]["type"] == "video/ogv") || ($_FILES["inputIMG"]["type"] == "image/png") || ($_FILES["inputIMG"]["type"] == "image/jpg") || ($_FILES["inputIMG"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                $sourcePath = $_FILES['inputIMG']['tmp_name'];
                $targetPath = "../../../img/upload/clientes/".$fileName;
                if(move_uploaded_file($sourcePath,$targetPath)){
                    $uploadedFile1 = $fileName;
                    $resultadoUP1 = true;
                }
            }
        }   
    }

    if($editURL2){
        $uploadedFile2 = '';
        if(!empty($_FILES["inputCROQ"]["type"])){
            $fileName = uniqid();
            $valid_extensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["inputCROQ"]["name"]);
            $file_extension = strtolower(end($temporary));
            $fileName = $fileName.".".$file_extension;
            if((($_FILES["inputCROQ"]["type"] == "video/mp4") || ($_FILES["inputCROQ"]["type"] == "video/webm") || ($_FILES["inputCROQ"]["type"] == "video/ogv") || ($_FILES["inputCROQ"]["type"] == "image/png") || ($_FILES["inputCROQ"]["type"] == "image/jpg") || ($_FILES["inputCROQ"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                $sourcePath = $_FILES['inputCROQ']['tmp_name'];
                $targetPath = "../../../img/upload/clientes/".$fileName;
                if(move_uploaded_file($sourcePath,$targetPath)){
                    $uploadedFile2 = $fileName;
                    $resultadoUP2 = true;
                }
            }
        }   
    }
    

    if($editURL1==1 && $editURL2==0){
        $query = "INSERT INTO clientes(dni,apellido_pat,apellido_mat,nombre,ocupacion_tipo,ocupacion_des,nacimiento,hijos,grado_ins,estado_civ,lugar_nac,direccion,referencia,tipo_viv,distrito,provincia,tiempo_viv,comentario,inscripcion,telefono,habilitado,url_foto) VALUES ('$dni','$apellido_pat','$apellido_mat','$nombres','$nacimiento','$hijos','$grado_ins','$estado_civ','$lugar_nac','$direccion','$referencia','$tipo_viv','$distrito','$provincia','$tiempo_viv','$comentario','$inscripcion','$telefono','SI','$uploadedFile1');";  
        $resultadoUP2 = true;
    }
    if($editURL1==0 && $editURL2==1){
        $query = "INSERT INTO clientes(dni,apellido_pat,apellido_mat,nombre,ocupacion_tipo,ocupacion_des,nacimiento,hijos,grado_ins,estado_civ,lugar_nac,direccion,referencia,tipo_viv,distrito,provincia,tiempo_viv,comentario,inscripcion,telefono,habilitado,url_domicilio) VALUES ('$dni','$apellido_pat','$apellido_mat','$nombres','$nacimiento','$hijos','$grado_ins','$estado_civ','$lugar_nac','$direccion','$referencia','$tipo_viv','$distrito','$provincia','$tiempo_viv','$comentario','$inscripcion','$telefono','SI','$uploadedFile2');"; 
        $resultadoUP1 = true;
    }
    if($editURL1==1 && $editURL2==1){
        $query = "INSERT INTO clientes(dni,apellido_pat,apellido_mat,nombre,ocupacion_tipo,ocupacion_des,nacimiento,hijos,grado_ins,estado_civ,lugar_nac,direccion,referencia,tipo_viv,distrito,provincia,tiempo_viv,comentario,inscripcion,telefono,habilitado,url_foto,url_domicilio) VALUES ('$dni','$apellido_pat','$apellido_mat','$nombres','$ocupacion_tipo','$ocupacion_des','$nacimiento','$hijos','$grado_ins','$estado_civ','$lugar_nac','$direccion','$referencia','$tipo_viv','$distrito','$provincia','$tiempo_viv','$comentario','$inscripcion','$telefono','SI','$uploadedFile1','$uploadedFile2');";   
    }
    if($editURL1==0 && $editURL2==0){
        $query = "INSERT INTO clientes(dni,apellido_pat,apellido_mat,nombre,ocupacion_tipo,ocupacion_des,nacimiento,hijos,grado_ins,estado_civ,lugar_nac,direccion,referencia,tipo_viv,distrito,provincia,tiempo_viv,comentario,inscripcion,telefono,habilitado) VALUES ('$dni','$apellido_pat','$apellido_mat','$nombres','$ocupacion_tipo','$ocupacion_des','$nacimiento','$hijos','$grado_ins','$estado_civ','$lugar_nac','$direccion','$referencia','$tipo_viv','$distrito','$provincia','$tiempo_viv','$comentario','$inscripcion','$telefono','SI');"; 
        $resultadoUP1 = true;
        $resultadoUP2 = true;
    }


    $result = $mysqli->query($query);
    
    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        $resultadoBD = true;
    }

    

    if($resultadoUP1 && $resultadoUP2){
        if($resultadoBD){
            echo '200';
        }else{
            echo '302';
        }
    }else{
        echo '301';
    }
    








?>