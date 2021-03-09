<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");

    $idcaja = $_POST['idcaja']; 
    $idusuario = $_POST['idusuario'];
    $operacion = $_POST['operacion'];

    $monto = $_POST['monto'];

    /*
    $m200 = $_POST['m200'];
    $m100 = $_POST['m100'];
    $m50 = $_POST['m50'];
    $m20 = $_POST['m20'];
    $m10 = $_POST['m10'];
    $m5 = $_POST['m5'];
    $m2 = $_POST['m2'];
    $m1 = $_POST['m1'];
    $m0_5 = $_POST['m0_5'];
    $m0_2 = $_POST['m0_2'];
    $m0_1 = $_POST['m0_1'];
    */


    if($operacion){
        $query0 = "INSERT INTO billetaje_hist(idbilletaje) VALUES (NULL);";
        $result0 = $mysqli->query($query0);

        $query = "UPDATE `cajas` SET `estado`='ABIERTO', `capital`='$monto', `billetaje_reg`='NO' WHERE `idcaja`='$idcaja';";
        $query .= "INSERT INTO aperturas(fecha_apertura,monto_apertura,cajas_idcaja,usuarios_idusuario,billetaje_hist_idbilletaje) VALUES (now(),'$monto','$idcaja','$idusuario',(SELECT MAX(idbilletaje) FROM billetaje_hist));";
    }else{
        $query = "UPDATE `cajas` SET `estado`='CERRADO', `capital`='$monto' WHERE `idcaja`='$idcaja';";
        $query .= "UPDATE `aperturas` SET `fecha_cierre` = now(), `monto_cierre`='$monto' WHERE `idapertura` = (SELECT idapertura FROM (SELECT * FROM aperturas WHERE cajas_idcaja = '$idcaja' ORDER BY idapertura DESC LIMIT 1) as x);";
        //$query .= "UPDATE billetaje SET cant_200='$m200',cant_100='$m100',cant_50='$m50',cant_20='$m20',cant_10='$m10',cant_5='$m5',cant_2='$m2',cant_1='$m1',cant_0_5='$m0_5',cant_0_2='$m0_2',cant_0_1='$m0_1' WHERE idbilletaje = (SELECT cajas.billetaje_idbilletaje FROM cajas WHERE idcaja = '$idcaja');";
    }
    
   
    $result = $mysqli->multi_query($query);

    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        echo '200';
    }
 

?>