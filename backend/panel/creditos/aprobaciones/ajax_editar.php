<?php

    require_once "../../../connect.php";

    $idaprobacion = $_POST['id'];

    $idadm = $_POST['inputADMIN-hidden'];
    

    $monto_aprob = $_POST['sol_MONTO_APRO'];
    $cuotas_aprob = $_POST['sol_CUOTAS_APRO'];
    $interes_aprob = $_POST['sol_INTERES_APRO'];
  

    $total_cuotas_aprob = $_POST['sol_cal_CUOTAS_APRO'];
    $total_interes_aprob = $_POST['sol_cal_INTERES_APRO'];
    $total_total_aprob = $_POST['sol_cal_TOTAL_APRO'];


    $resultadoBD = false;


    $query = "UPDATE `creditos` SET `monto_aprob`='$monto_aprob',`n_cuotas_aprob`='$cuotas_aprob',`interes_aprob`='$interes_aprob',`m_cuotas_aprob`='$total_cuotas_aprob',`m_interes_aprob`='$total_interes_aprob',`m_total_aprob`='$total_total_aprob' WHERE `idcredito`=(SELECT creditos_idcredito FROM aprobaciones WHERE idaprobacion='$idaprobacion');";
    $query2 = "UPDATE `aprobaciones` SET `usuarios_idusuario` = '$idadm' WHERE idaprobacion = '$idaprobacion';";
    $result = $mysqli->query($query);
    $result2 = $mysqli->query($query2);

    if($result && $result2){
        $resultadoBD = true;
    }else{
        die("Query error " . mysqli_error($mysqli));
    }
    


    if($resultadoBD){
        echo '200';
    }else{
        echo '302';
    }



?>