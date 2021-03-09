<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");
    
    $idcredito = $_POST['id'];

    $monto = $_POST['deposito_monto'];
    $idcajero = $_POST['inputCAJA-hidden'];
    $idcliente = $_POST['inputCLIENT-hidden'];
    $idcaja = $_POST['movimiento_caja'];


    $resultadoBD = false;

    $rs = $mysqli->query("SELECT cajas.capital FROM cajas WHERE idcaja = '$idcaja'");
    if ($row = $rs->fetch_array()) {
        $capital_act = trim($row['capital']);
        $capital_act = floatval($capital_act);
    }

    
 
    $saldo = $monto;
    $pagado = 0;
    


    $query_operacion = $capital_act + $monto;
    $query = "INSERT INTO movimientos(tipo,monto,concepto,autoriza,fecha_mov,tipo_comprobante,nro_comprobante,cajas_idcaja,usuarios_idusuario,creditos_idcredito) VALUES ('INGRESO','$monto','PAGO DE CUOTA DE CREDITO','CAJERO',now(),'VOUCHER','0','$idcaja','$idcajero','$idcredito');"; 
    $query .= "UPDATE `cajas` SET `capital`='$query_operacion' WHERE `idcaja` = '$idcaja';";
    for($i=0; $i<count($deudas_cuotas_res);$i++){
        $monto_calc = $deudas_cuotas_res[$i];
        $id_calc = $idpagos_array[$i];
        $fecha_calc = $fechapago_array[$i];
        if($fecha_calc){
            $query .= "UPDATE `pagos` SET `monto`='$monto_calc',`fecha`=now(), `usuarios_idusuario`='$idcajero' WHERE `idpago`='$id_calc';";
        }else{
            $query .= "UPDATE `pagos` SET `monto`='$monto_calc',`usuarios_idusuario`='$idcajero' WHERE `idpago`='$id_calc';";
        }
        
        //echo "id:".$idpagos_array[$i]." - pago:".$deudas_cuotas_res[$i]." ||| ";
    }
    $query .= "INSERT INTO voucher_pago(monto_pago,fecha_pago,creditos_idcredito,usuarios_idusuario) VALUES ('$monto',now(),'$idcredito','$idcajero');";
    //$query .= "UPDATE `pagos` SET `monto`='$monto',`fecha`=now(), `usuarios_idusuario`='$idcajero' WHERE `idpago`='$idapago';";
    
    $result = $mysqli->multi_query($query);
   


    if($result){
        echo '200';
    }else{
        die("Query error " . mysqli_error($mysqli));
    }

   
 

?>