<?php

    require_once "connect.php";
    date_default_timezone_set('America/Lima');
    
    
    $fecha_hoy = date("Y-m-d");

    $resultadoBD = false;
    $dif_dias_ori = 0;

    $query = "SELECT * FROM pagos;";
    $result = $mysqli->query($query);

    while($row = $result->fetch_array()){
        $idcredito = $row['creditos_idcredito'];
        $id_pago = $row['idpago'];
        $fecha_programada = $row['fecha_programada'];

        if($row['monto'] >= floatval($row['cuota_programada']) + floatval($row['mora'])){
            $result2 = true; 
        }else{
            $rs = $mysqli->query("SELECT DATEDIFF('$fecha_hoy', '$fecha_programada') AS dif_dias;");
            if ($row1 = $rs->fetch_array()) {
                $dif_dias = trim($row1['dif_dias']);
                $dif_dias = floatval($dif_dias);
                $dif_dias_ori = $dif_dias;
            }
    
            if($dif_dias<=0){
                $dif_dias = '';
            }

    
            $rs = $mysqli->query("SELECT frecuencia FROM creditos WHERE idcredito = $idcredito;");
            if ($row2 = $rs->fetch_array()) {
                $frecuencia = trim($row2['frecuencia']);
            }
    
            switch($frecuencia){
                case "DIARIO":  
                                if($dif_dias > 1){
                                    $dif_dias_ori = $dif_dias;
                                    $dif_dias = 1;
                                }
                                break;
                case "SEMANAL": 
                                if($dif_dias > 7){
                                    $dif_dias_ori = $dif_dias;
                                    $dif_dias = 7;
                                }
                                break;
                case "QUINCENAL":
                                if($dif_dias > 15){
                                    $dif_dias_ori = $dif_dias;
                                    $dif_dias = 15;
                                }
                                break;
                case "MENSUAL": 
                                if($dif_dias > 30){
                                    $dif_dias_ori = $dif_dias;
                                    $dif_dias = 30;
                                }
                                break;
            }

           
            $query2 = "UPDATE `pagos` SET `mora`='$dif_dias' WHERE `idpago` = '$id_pago';";
            $result2 = $mysqli->query($query2);  
        } 


        if($result2){
            if($row['monto'] < floatval($row['cuota_programada']) + floatval($row['mora'])){
                if($fecha_hoy > $row['fecha_programada']){
                    $rs = $mysqli->query("SELECT MAX(idpago) as id FROM pagos WHERE creditos_idcredito = '$idcredito';");
                    if ($row3 = $rs->fetch_array()) {
                        $maxid = trim($row3['id']);
                    }
                    $query3 = "UPDATE `pagos` SET `mora`='$dif_dias_ori' WHERE `idpago` = '$maxid';";
                    $result3 = $mysqli->query($query3);  
                }
            }else{
                $result3 = true;
            }
        }


        
    }

    



    if($result && $result2 && $result3){
        $resultadoBD = true;
    }else{   
        die("Query error " . mysqli_error($mysqli));
        $resultadoBD = false;
    }


    if($resultadoBD){
        echo '200';
    }else{
        echo '302';
    }
    
    
    

    
  







?>