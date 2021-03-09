<?php

    require_once "../../connect.php";

    $id = $_POST['id']; 
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
    $comentario = saltoLinea($comentario);

    $resultadoUP1 = false;
    $resultadoUP2 = false;
    $resultadoBD = false;


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
        $query = "UPDATE `clientes` SET `dni`='$dni',`apellido_pat`='$apellido_pat',`apellido_mat`='$apellido_mat',`nombre`='$nombres',`ocupacion_tipo`='$ocupacion_tipo',`ocupacion_des`='$ocupacion_des',`nacimiento`='$nacimiento',`hijos`='$hijos',`grado_ins`='$grado_ins',`estado_civ`='$estado_civ',`lugar_nac`='$lugar_nac',`direccion`='$direccion',`referencia`='$referencia',`tipo_viv`='$tipo_viv',`distrito`='$distrito',`provincia`='$provincia',`tiempo_viv`='$tiempo_viv',`comentario`='$comentario',`inscripcion`='$inscripcion',`telefono`='$telefono',`url_foto`='$uploadedFile1' WHERE `idcliente`='$id';";
        $resultadoUP2 = true;
    }
    if($editURL1==0 && $editURL2==1){
        $query = "UPDATE `clientes` SET `dni`='$dni',`apellido_pat`='$apellido_pat',`apellido_mat`='$apellido_mat',`nombre`='$nombres',`ocupacion_tipo`='$ocupacion_tipo',`ocupacion_des`='$ocupacion_des',`nacimiento`='$nacimiento',`hijos`='$hijos',`grado_ins`='$grado_ins',`estado_civ`='$estado_civ',`lugar_nac`='$lugar_nac',`direccion`='$direccion',`referencia`='$referencia',`tipo_viv`='$tipo_viv',`distrito`='$distrito',`provincia`='$provincia',`tiempo_viv`='$tiempo_viv',`comentario`='$comentario',`inscripcion`='$inscripcion',`telefono`='$telefono',`url_domicilio`='$uploadedFile2' WHERE `idcliente`='$id';";
        $resultadoUP1 = true;
    }
    if($editURL1==1 && $editURL2==1){
        $query = "UPDATE `clientes` SET `dni`='$dni',`apellido_pat`='$apellido_pat',`apellido_mat`='$apellido_mat',`nombre`='$nombres',`ocupacion_tipo`='$ocupacion_tipo',`ocupacion_des`='$ocupacion_des',`nacimiento`='$nacimiento',`hijos`='$hijos',`grado_ins`='$grado_ins',`estado_civ`='$estado_civ',`lugar_nac`='$lugar_nac',`direccion`='$direccion',`referencia`='$referencia',`tipo_viv`='$tipo_viv',`distrito`='$distrito',`provincia`='$provincia',`tiempo_viv`='$tiempo_viv',`comentario`='$comentario',`inscripcion`='$inscripcion',`telefono`='$telefono',`url_foto`='$uploadedFile1',`url_domicilio`='$uploadedFile2' WHERE `idcliente`='$id';";  
    }
    if($editURL1==0 && $editURL2==0){
        $query = "UPDATE `clientes` SET `dni`='$dni',`apellido_pat`='$apellido_pat',`apellido_mat`='$apellido_mat',`nombre`='$nombres',`ocupacion_tipo`='$ocupacion_tipo',`ocupacion_des`='$ocupacion_des',`nacimiento`='$nacimiento',`hijos`='$hijos',`grado_ins`='$grado_ins',`estado_civ`='$estado_civ',`lugar_nac`='$lugar_nac',`direccion`='$direccion',`referencia`='$referencia',`tipo_viv`='$tipo_viv',`distrito`='$distrito',`provincia`='$provincia',`tiempo_viv`='$tiempo_viv',`comentario`='$comentario',`inscripcion`='$inscripcion',`telefono`='$telefono' WHERE `idcliente`='$id';";
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