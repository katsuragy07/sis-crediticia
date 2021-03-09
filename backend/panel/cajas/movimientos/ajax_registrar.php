<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");

    $idcaja = $_POST['movimiento_caja'];
    $idcajero = $_POST['caja_resp-hidden'];
    $movimiento_tipo = $_POST['movimiento_tipo'];
    $movimiento_monto = floatval($_POST['movimiento_monto']);
    $movimiento_concepto = $_POST['movimiento_concepto'];
    $movimiento_autoriza = $_POST['movimiento_autoriza'];

    $tipo_comprobante = $_POST['movimiento_tipo_comprobante'];
    $nro_comprobante = $_POST['movimiento_nro_comprobante'];
    $detalle = $_POST['movimiento_detalle'];

    
    $resultadoBD = false;
    $rs = $mysqli->query("SELECT cajas.capital FROM cajas WHERE idcaja = '$idcaja'");
    if ($row = $rs->fetch_array()) {
        $capital_act = trim($row['capital']);
        $capital_act = floatval($capital_act);
    }

    if($movimiento_tipo=="INGRESO"){
        $query_operacion = $capital_act + $movimiento_monto;
        $query = "INSERT INTO movimientos(tipo,monto,concepto,autoriza,fecha_mov,tipo_comprobante,nro_comprobante,detalle,cajas_idcaja,usuarios_idusuario) VALUES ('$movimiento_tipo','$movimiento_monto','$movimiento_concepto','$movimiento_autoriza',now(),'$tipo_comprobante','$nro_comprobante','$detalle','$idcaja','$idcajero');"; 
        $query .= "UPDATE `cajas` SET `capital`='$query_operacion' WHERE `idcaja` = '$idcaja';";
    }else{
        $query_operacion = $capital_act - $movimiento_monto;
        if($query_operacion >= 0){
            $query = "INSERT INTO movimientos(tipo,monto,concepto,autoriza,fecha_mov,tipo_comprobante,nro_comprobante,detalle,cajas_idcaja,usuarios_idusuario) VALUES ('$movimiento_tipo','$movimiento_monto','$movimiento_concepto','$movimiento_autoriza',now(),'$tipo_comprobante','$nro_comprobante','$detalle','$idcaja','$idcajero');"; 
            $query .= "UPDATE `cajas` SET `capital`='$query_operacion' WHERE `idcaja` = '$idcaja';";
        }else{
            die("600");
        }

        
    }
    
    $result = $mysqli->multi_query($query);

    
    if($result){
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