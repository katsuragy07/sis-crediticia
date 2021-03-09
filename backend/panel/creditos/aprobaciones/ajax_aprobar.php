<?php

    require_once "../../../connect.php";

    $idaprobacion = $_POST['id']; 
    $operacion = $_POST['operacion'];

    $idadm = $_POST['idadm'];

    $monto_aprob = $_POST['monto_aprob'];
    $n_cuotas_aprob = $_POST['n_cuotas_aprob'];
    $interes_aprob = $_POST['interes_aprob'];

    $total_cuotas_aprob = $_POST['total_cuotas_aprob'];
    $total_interes_aprob = $_POST['total_interes_aprob'];
    $total_total_aprob = $_POST['total_total_aprob'];


    if($operacion){
        $query = "UPDATE `creditos` SET `estado`='APROBADO', `monto_aprob`='$monto_aprob', `n_cuotas_aprob`='$n_cuotas_aprob', `interes_aprob`='$interes_aprob', `m_cuotas_aprob`='$total_cuotas_aprob', `m_interes_aprob`='$total_interes_aprob', `m_total_aprob`='$total_total_aprob' WHERE `idcredito`=(SELECT creditos_idcredito FROM aprobaciones WHERE idaprobacion='$idaprobacion');";
        $query2 = "UPDATE `aprobaciones` SET `fecha_aprob` = NOW(), `usuarios_idusuario`='$idadm' WHERE `idaprobacion`='$idaprobacion';";
        $query3 = "INSERT INTO desembolso(fecha_reg,creditos_idcredito) VALUES (NOW(),(SELECT creditos_idcredito FROM aprobaciones WHERE idaprobacion='$idaprobacion'));";
    }else{
        $query = "UPDATE `creditos` SET `estado`='REGISTRADO' WHERE `idcredito`=(SELECT creditos_idcredito FROM aprobaciones WHERE idaprobacion='$idaprobacion');";
        $query2 = "DELETE FROM aprobaciones WHERE idaprobacion = '$idaprobacion';";
        $query3 = "SELECT NOW();";
    }
    
   
    $result = $mysqli->query($query);
    $result2 = $mysqli->query($query2);
    $result3 = $mysqli->query($query3);

    if($result && $result2 && $result3){
        echo '200';
    }else{
        die("Query error " . mysqli_error($mysqli));
    }
 

?>