<?php

    require_once "../../../connect.php";

    $idsolicitud = $_POST['id']; 
    $operacion = $_POST['operacion'];

    $idasesor = $_POST['inputASES_hidden'];
    $idcliente = $_POST['inputCLIENT_hidden'];

    $idconyugue = $_POST['inputCONY_AJAX_hidden'];
    $idaval = $_POST['inputAVAL_AJAX_hidden'];

    $monto = $_POST['sol_MONTO'];
    $cuotas = $_POST['sol_CUOTAS'];
    $interes = $_POST['sol_INTERES'];
    $frecuencia = $_POST['sol_FRECUENCIA'];
    $inicio = $_POST['sol_INICIO'];
    $negocio = $_POST['sol_NEGOCIO'];

    $total_cuotas = $_POST['sol_cal_CUOTAS'];
    $total_interes = $_POST['sol_cal_INTERES'];
    $total_total = $_POST['sol_cal_TOTAL'];


    if($operacion){
        $query = "UPDATE `creditos` SET `estado`='PREAPROBADO', `monto_prop`='$monto',`n_cuotas`='$cuotas',`interes`='$interes',`frecuencia`='$frecuencia',`fecha_inicio`='$inicio',`m_cuotas`='$total_cuotas',`m_interes`='$total_interes',`m_total`='$total_total',`clientes_idcliente`='$idcliente',`conyugue_id`='$idconyugue',`aval_id`='$idaval' WHERE `idcredito`=(SELECT creditos_idcredito FROM solicitudes WHERE idsolicitud='$idsolicitud');";
        $query2 = "UPDATE `solicitudes` SET `negocio_des`='$negocio', `fecha_pre` = NOW() WHERE `idsolicitud`='$idsolicitud';";
        $query3 = "INSERT INTO aprobaciones(fecha_reg,creditos_idcredito) VALUES (NOW(),(SELECT creditos_idcredito FROM solicitudes WHERE idsolicitud='$idsolicitud'));";
    }else{
        $query = "UPDATE `creditos` SET `estado`='PREAPROBADO' WHERE `idcredito`=(SELECT creditos_idcredito FROM solicitudes WHERE idsolicitud='$idsolicitud');";
    }
    
   
    $result = $mysqli->query($query);
    $result2 = $mysqli->query($query2);
    $result3 = $mysqli->query($query3);

    if($result && $result && $result){
        echo '200';
    }else{
        die("Query error " . mysqli_error($mysqli));
    }
 

?>