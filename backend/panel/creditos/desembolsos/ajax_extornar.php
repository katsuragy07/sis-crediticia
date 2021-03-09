<?php
    session_start();
    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");

    $iduser = $_SESSION['id'];
    $privilegios = $_SESSION['privilegios'];

    $iddesembolso = $_POST['id']; 
    $idcaja = $_POST['movimiento_caja'];
    $monto_desemb = $_POST['sol_MONTO'];

    $rs = $mysqli->query("SELECT cajas.capital FROM cajas WHERE idcaja = '$idcaja';");
    if ($row = $rs->fetch_array()) {
        $capital_act = trim($row['capital']);
        $capital_act = floatval($capital_act);
    }else{
        die("600");
    }

    
    $query_operacion = $capital_act + $monto_desemb;
 
    $query = "UPDATE `creditos` SET `estado`='APROBADO' WHERE `idcredito`=(SELECT creditos_idcredito FROM desembolso WHERE iddesembolso='$iddesembolso');";
    $query .= "UPDATE `desembolso` SET `fecha_desem` = NULL, `usuarios_idusuario`= NULL WHERE `iddesembolso`='$iddesembolso';";
    $query .= "INSERT INTO movimientos(tipo,monto,concepto,autoriza,fecha_mov,tipo_comprobante,nro_comprobante,cajas_idcaja,usuarios_idusuario) VALUES ('INGRESO','$monto_desemb','EXTORNO DE DESEMBOLSO','ADMINISTRADOR',now(),'VOUCHER','$iddesembolso','$idcaja','$iduser');"; 
    $query .= "UPDATE `cajas` SET `capital`='$query_operacion' WHERE `idcaja` = '$idcaja';";
    $query .= "DELETE FROM pagos WHERE creditos_idcredito = (SELECT creditos_idcredito FROM desembolso WHERE iddesembolso='$iddesembolso');";
   
        
    
   
    $result = $mysqli->multi_query($query);

    if($result){
        echo '200';
    }else{
        die("Query error " . mysqli_error($mysqli));
    }
 

?>