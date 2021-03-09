<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");
    
    $idcredito = $_POST['id'];

    $monto = $_POST['pago_monto'];
    $idcajero = $_POST['inputCAJA-hidden'];
    $idcliente = $_POST['inputCLIENT-hidden'];
    $idcaja = $_POST['movimiento_caja'];


    $resultadoBD = false;

    $rs = $mysqli->query("SELECT cajas.capital FROM cajas WHERE idcaja = '$idcaja'");
    if ($row = $rs->fetch_array()) {
        $capital_act = trim($row['capital']);
        $capital_act = floatval($capital_act);
    }

    $idpagos_array = array();
    $fechapago_array = array();
    $deudas_cuotas = array();
    $deudas_cuotas_res = array();
    $rs = $mysqli->query("SELECT * FROM pagos WHERE creditos_idcredito = '$idcredito'");
 
    $saldo = $monto;
    $pagado = 0;
    
    
    while($row = $rs->fetch_array()){
        array_push($idpagos_array, $row['idpago']);
        $fechaoperacion = 1;
        $monto_cuota = floatval(trim($row['cuota_programada']));
        $monto_mora = floatval(trim($row['mora']));
        $monto_pagado = floatval(trim($row['monto']));
        $monto_deuda = floatval($monto_cuota) + floatval($monto_mora) - floatval($monto_pagado);

        if($saldo>0){
            if($monto_deuda>0){
                if($monto_deuda >= $saldo){
                    $pagado = $saldo + $monto_pagado;
                    $saldo = "";
                }else{
                    $pagado = $monto_deuda + $monto_pagado;
                    $saldo = $saldo - $monto_deuda;
                }
            }else{
                $pagado = $monto_pagado;
                $fechaoperacion = 0;
            }
        }else{
            $pagado = $monto_pagado;
            $fechaoperacion = 0;
        }

        //array_push($deudas_cuotas, $monto_deuda);
        array_push($fechapago_array, $fechaoperacion);
        array_push($deudas_cuotas_res, $pagado);
    }

    //print_r($deudas_cuotas_res);


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
    $query .= "INSERT INTO voucher_pago(monto_pago,tipo_vp,fecha_pago,creditos_idcredito,usuarios_idusuario) VALUES ('$monto','PAGO',now(),'$idcredito','$idcajero');";
    //$query .= "UPDATE `pagos` SET `monto`='$monto',`fecha`=now(), `usuarios_idusuario`='$idcajero' WHERE `idpago`='$idapago';";
    
    $result = $mysqli->multi_query($query);
   


    if($result){
        echo '200';
    }else{
        die("Query error " . mysqli_error($mysqli));
    }

   
 

?>