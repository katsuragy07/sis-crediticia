<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");

    $iddesembolso = $_POST['id']; 
    $operacion = $_POST['operacion'];
    $idcajero = $_POST['idcaja'];
    $idcaja = $_POST['movimiento_caja'];
    $idcliente = $_POST['idcliente'];

    $monto_desemb = $_POST['sol_MONTO'];


    if($operacion){
        $rs = $mysqli->query("SELECT cajas.capital FROM cajas WHERE idcaja = '$idcaja'");
        if ($row = $rs->fetch_array()) {
            $capital_act = trim($row['capital']);
            $capital_act = floatval($capital_act);
        }else{
            die("600");
        }
    }
    

    $rs2 = $mysqli->query("SELECT count(*) AS nrocredito FROM creditos INNER JOIN clientes ON clientes.idcliente = creditos.clientes_idcliente WHERE clientes.idcliente = '$idcliente';");
    if ($row2 = $rs2->fetch_array()) {
        $nrocredito = trim($row2['nrocredito']);

    }else{
        die("Los sentimos hubo un problema en la Base de Datos!");
    }



    if($operacion){
        $query_operacion = $capital_act - $monto_desemb;
        if($query_operacion >= 0){
            $query = "UPDATE `creditos` SET `nro_credito`='$nrocredito', `estado`='DESEMBOLSADO' WHERE `idcredito`=(SELECT creditos_idcredito FROM desembolso WHERE iddesembolso='$iddesembolso');";
            $query .= "UPDATE `desembolso` SET `fecha_desem` = NOW(), `usuarios_idusuario`='$idcajero' WHERE `iddesembolso`='$iddesembolso';";
            $query .= "INSERT INTO movimientos(tipo,monto,concepto,autoriza,fecha_mov,tipo_comprobante,nro_comprobante,cajas_idcaja,usuarios_idusuario,creditos_idcredito) VALUES ('EGRESO','$monto_desemb','DESEMBOLSO DE CREDITO','ADMINISTRADOR',now(),'VOUCHER','$iddesembolso','$idcaja','$idcajero',(SELECT creditos_idcredito FROM desembolso WHERE iddesembolso='$iddesembolso'));"; 
            $query .= "UPDATE `cajas` SET `capital`='$query_operacion' WHERE `idcaja` = '$idcaja';";
        }else{
            die("600");
        }   
    }else{
        $query = "UPDATE `creditos` SET `nro_credito`='', `estado`='PREAPROBADO' WHERE `idcredito`=(SELECT creditos_idcredito FROM desembolso WHERE iddesembolso='$iddesembolso');";
        $query .= "DELETE FROM desembolso WHERE iddesembolso = '$iddesembolso';";
    }
    
   
    $result = $mysqli->multi_query($query);

    if($result){
        echo '200';
    }else{
        die("Query error " . mysqli_error($mysqli));
    }
 

?>