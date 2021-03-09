<?php

    require_once "../../../connect.php";
  
    $idcuenta = $_POST['idcuenta'];
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
    }else{
        die("600");
    }


    $query_operacion = $capital_act - $monto_final;
    if($query_operacion >= 0){
        $query = "UPDATE `cuenta_pf` SET `estado` = 'VENCIDO', `fecha_retiro` = now() WHERE `idcuenta`='$idcuenta';";
        $query .= "INSERT INTO movimientos(tipo,monto,concepto,autoriza,fecha_mov,tipo_comprobante,nro_comprobante,cajas_idcaja,usuarios_idusuario) VALUES ('EGRESO','$monto_final','RETIRO DE CUENTA A PLAZO FIJO','CAJERO',now(),'VOUCHER','$idcuenta','$idcaja','$iduser');"; 
        $query .= "UPDATE `cajas` SET `capital`='$query_operacion' WHERE `idcaja` = '$idcaja';";
    }else{
        die("600");
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