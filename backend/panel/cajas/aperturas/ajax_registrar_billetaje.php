<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");

    $idcaja = $_POST['idcaja']; 
    $idusuario = $_POST['idusuario'];

    $monto = $_POST['monto'];

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



    $query = "UPDATE billetaje SET cant_200='$m200',cant_100='$m100',cant_50='$m50',cant_20='$m20',cant_10='$m10',cant_5='$m5',cant_2='$m2',cant_1='$m1',cant_0_5='$m0_5',cant_0_2='$m0_2',cant_0_1='$m0_1' WHERE idbilletaje = (SELECT cajas.billetaje_idbilletaje FROM cajas WHERE idcaja = '$idcaja');";
    $query .= "UPDATE billetaje_hist SET cant_200='$m200',cant_100='$m100',cant_50='$m50',cant_20='$m20',cant_10='$m10',cant_5='$m5',cant_2='$m2',cant_1='$m1',cant_0_5='$m0_5',cant_0_2='$m0_2',cant_0_1='$m0_1' WHERE idbilletaje = (SELECT billetaje_hist_idbilletaje FROM aperturas WHERE cajas_idcaja = '$idcaja' ORDER BY fecha_apertura DESC LIMIT 1);";
    $query .= "UPDATE cajas SET `billetaje_reg`='SI' WHERE idcaja = '$idcaja';";
    
    
   
    $result = $mysqli->multi_query($query);

    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }else{
        echo '200';
    }
 

?>