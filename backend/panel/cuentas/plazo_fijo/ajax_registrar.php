<?php

    require_once "../../../connect.php";
  

    $iduser = $_POST['iduser'];
    $idcliente = $_POST['inputCLIENT-hidden'];
    $idcaja = $_POST['movimiento_caja'];

    $monto_inicio = $_POST['pf_MONTO_INI'];
    $monto_final = $_POST['pf_MONTO_FIN'];
    $fecha_inicio = $_POST['pf_FECHA_INI'];
    $fecha_fin = $_POST['pf_FECHA_FIN'];
    $interes = $_POST['pf_INTERES'];

    
    function saltoLinea($str) { 
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str); 
    }  
    //Modo de uso 
  
    

    $resultadoBD = false;

    $rs = $mysqli->query("SELECT cajas.capital FROM cajas WHERE idcaja = '$idcaja'");
    if ($row = $rs->fetch_array()) {
        $capital_act = trim($row['capital']);
        $capital_act = floatval($capital_act);
    }


    $query = "INSERT INTO cuenta_pf(monto_inicio,monto_fin,fecha_inicio,fecha_fin,interes,estado,clientes_idcliente,usuarios_idusuario) VALUES('$monto_inicio','$monto_final',now(),'$fecha_fin','$interes','HABILITADO','$idcliente','$iduser');";
    $result = $mysqli->query($query);

    if($result){
        $query_operacion = $capital_act + $monto_inicio;
        $query2 = "INSERT INTO movimientos(tipo,monto,concepto,autoriza,fecha_mov,tipo_comprobante,nro_comprobante,cajas_idcaja,usuarios_idusuario) VALUES ('INGRESO','$monto_inicio','DEPOSITO A PLAZO FIJO','CAJERO',now(),'VOUCHER',(SELECT MAX(idcuenta) FROM cuenta_pf),'$idcaja','$iduser');"; 
        $query2 .= "UPDATE `cajas` SET `capital`='$query_operacion' WHERE `idcaja` = '$idcaja';";
        $result2 = $mysqli->multi_query($query2);
    }
    
    

    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        if($result2){
            $resultadoBD = true;
        }
    }


    if($resultadoBD){
        echo '200';
    }else{
        echo '302';
    }
  
    








?>