<?php

    require_once "../../../connect.php";
    
    $idasesor = $_POST['inputASES-hidden'];
    $idcliente = $_POST['inputCLIENT-hidden'];

    $idconyugue = $_POST['inputCONY_AJAX-hidden'];
    $idaval = $_POST['inputAVAL_AJAX-hidden'];

    $monto = $_POST['sol_MONTO'];
    $cuotas = $_POST['sol_CUOTAS'];
    $interes = $_POST['sol_INTERES'];
    $frecuencia = $_POST['sol_FRECUENCIA'];
    $inicio = $_POST['sol_INICIO'];

    $total_cuotas = $_POST['sol_cal_CUOTAS'];
    $total_interes = $_POST['sol_cal_INTERES'];
    $total_total = $_POST['sol_cal_TOTAL'];
    

    $resultadoBD = false;

    
    $query = "INSERT INTO creditos(monto_prop,n_cuotas,interes,frecuencia,fecha_inicio,m_cuotas,m_interes,m_total,estado,fecha_reg,clientes_idcliente,conyugue_id,aval_id) VALUES ('$monto','$cuotas','$interes','$frecuencia','$inicio','$total_cuotas','$total_interes','$total_total','REGISTRADO', NOW(),'$idcliente','$idconyugue','$idaval');"; 
    $result = $mysqli->query($query);

    

    
    $rs = $mysqli->query("SELECT MAX(idcredito) AS id FROM creditos");
    if ($row = $rs->fetch_array()) {
        $id = trim($row['id']);
    }


    $query2 = "INSERT INTO solicitudes(fecha_reg,usuarios_idusuario,creditos_idcredito) VALUES (NOW(),'$idasesor','$id')";
    $result2 = $mysqli->query($query2);



    if($result && $result2){
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