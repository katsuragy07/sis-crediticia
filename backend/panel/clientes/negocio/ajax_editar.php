<?php

    require_once "../../../connect.php";

    $id = $_POST['id']; 
    $tipo = $_POST['tipo'];
    $editURL = $_POST['editURLimg'];
    $editURL2 = $_POST['editURLimg2'];


    if($tipo=="NEGOCIO"){
        $norm_tipo = $_POST['input_neg_TIPO'];
        $norm_tipo_local = $_POST['input_neg_TIPOLOC'];
        $norm_tipo_negocio = $_POST['input_neg_SECTOR'];
        $tiempo = $_POST['input_neg_TIEMPO'];

        $trans_tipo = null;
        $trans_placa = null;
        $trans_empresa = null;
        $trans_direccion = null;
        $trans_soat = null;
        $trans_soat_cad = null;
        $trans_tarjeta = null;
        $trans_tarjeta_cad = null;
 
    }else{
        $norm_tipo = null;
        $norm_tipo_local = null;
        $norm_tipo_negocio = null;

        $trans_tipo = $_POST['input_trans_TIPO'];
        $trans_placa = $_POST['input_trans_PLACA'];
        $trans_empresa = $_POST['input_trans_EMP'];
        $trans_direccion = $_POST['input_trans_DIR'];
        $trans_soat = $_POST['input_trans_SOAT'];
        $trans_soat_cad = $_POST['input_trans_SOAT_CAD'];
        $trans_tarjeta = $_POST['input_trans_TARJETA'];
        $trans_tarjeta_cad = $_POST['input_trans_TARJETA_CAD'];
        $tiempo = $_POST['input_trans_TIEMPO'];   
    }


    /*
    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    }  
    */


    $resultadoUP = false;
    $resultadoBD = false;
    
    $uploadedFile = '';


    if($editURL){
        $uploadedFile = '';
        if(!empty($_FILES["input_neg_CROQUIS"]["type"])){
            $fileName = uniqid();
            $valid_extensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["input_neg_CROQUIS"]["name"]);
            $file_extension = strtolower(end($temporary));
            $fileName = $fileName.".".$file_extension;
            if((($_FILES["input_neg_CROQUIS"]["type"] == "video/mp4") || ($_FILES["input_neg_CROQUIS"]["type"] == "video/webm") || ($_FILES["input_neg_CROQUIS"]["type"] == "video/ogv") || ($_FILES["input_neg_CROQUIS"]["type"] == "image/png") || ($_FILES["input_neg_CROQUIS"]["type"] == "image/jpg") || ($_FILES["input_neg_CROQUIS"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                $sourcePath = $_FILES['input_neg_CROQUIS']['tmp_name'];
                $targetPath = "../../../img/upload/clientes/negocio/".$fileName;
                if(move_uploaded_file($sourcePath,$targetPath)){
                    $uploadedFile = $fileName;
                    $resultadoUP = true;
                }
            }
        }
    }
    if($editURL2){
        $uploadedFile = '';
        if(!empty($_FILES["input_trans_CROQUIS"]["type"])){
            $fileName = uniqid();
            $valid_extensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["input_trans_CROQUIS"]["name"]);
            $file_extension = strtolower(end($temporary));
            $fileName = $fileName.".".$file_extension;
            if((($_FILES["input_trans_CROQUIS"]["type"] == "video/mp4") || ($_FILES["input_trans_CROQUIS"]["type"] == "video/webm") || ($_FILES["input_trans_CROQUIS"]["type"] == "video/ogv") || ($_FILES["input_trans_CROQUIS"]["type"] == "image/png") || ($_FILES["input_trans_CROQUIS"]["type"] == "image/jpg") || ($_FILES["input_trans_CROQUIS"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                $sourcePath = $_FILES['input_trans_CROQUIS']['tmp_name'];
                $targetPath = "../../../img/upload/clientes/negocio/".$fileName;
                if(move_uploaded_file($sourcePath,$targetPath)){
                    $uploadedFile = $fileName;
                    $resultadoUP = true;
                }
            }
        }
    }


    if($resultadoUP){
        $query = "UPDATE `negocio` SET `norm_tipo`='$norm_tipo',`norm_tipo_local`='$norm_tipo_local',`norm_tipo_negocio`='$norm_tipo_negocio',`trans_tipo`='$trans_tipo',`trans_placa`='$trans_placa',`trans_empresa`='$trans_empresa',`trans_direccion`='$trans_direccion',`trans_soat`='$trans_soat',`trans_soat_cad`='$trans_soat_cad',`trans_tarjeta`='$trans_tarjeta',`trans_tarjeta_cad`='$trans_tarjeta_cad',`tiempo`='$tiempo',`url_croquis`='$uploadedFile' WHERE `idnegocio`='$id';";
    }else{
        $query = "UPDATE `negocio` SET `norm_tipo`='$norm_tipo',`norm_tipo_local`='$norm_tipo_local',`norm_tipo_negocio`='$norm_tipo_negocio',`trans_tipo`='$trans_tipo',`trans_placa`='$trans_placa',`trans_empresa`='$trans_empresa',`trans_direccion`='$trans_direccion',`trans_soat`='$trans_soat',`trans_soat_cad`='$trans_soat_cad',`trans_tarjeta`='$trans_tarjeta',`trans_tarjeta_cad`='$trans_tarjeta_cad',`tiempo`='$tiempo' WHERE `idnegocio`='$id';";
        $resultadoUP = true;
    }

    
    $result = $mysqli->query($query);



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