<?php

    require_once "../../../connect.php";

    $idsolicitud = $_POST['id'];
    $idasesor = $_POST['inputASES-hidden'];
    $idcliente = $_POST['inputCLIENT-hidden'];

    $idconyugue = $_POST['inputCONY_AJAX-hidden'];
    $idaval = $_POST['inputAVAL_AJAX-hidden'];

    $monto = $_POST['sol_MONTO'];
    $cuotas = $_POST['sol_CUOTAS'];
    $interes = $_POST['sol_INTERES'];
    $frecuencia = $_POST['sol_FRECUENCIA'];
    $inicio = $_POST['sol_INICIO'];
    $negocio = $_POST['sol_NEGOCIO'];

    $total_cuotas = $_POST['sol_cal_CUOTAS'];
    $total_interes = $_POST['sol_cal_INTERES'];
    $total_total = $_POST['sol_cal_TOTAL'];


    $resultadoBD = false;


    $query = "UPDATE `creditos` SET `monto_prop`='$monto',`n_cuotas`='$cuotas',`interes`='$interes',`frecuencia`='$frecuencia',`fecha_inicio`='$inicio',`m_cuotas`='$total_cuotas',`m_interes`='$total_interes',`m_total`='$total_total',`clientes_idcliente`='$idcliente',`conyugue_id`='$idconyugue',`aval_id`='$idaval' WHERE `idcredito`=(SELECT creditos_idcredito FROM solicitudes WHERE idsolicitud='$idsolicitud');";
    $query .= "UPDATE `solicitudes` SET `negocio_des`='$negocio', `fecha_mod`=now() WHERE `idsolicitud`='$idsolicitud';";
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