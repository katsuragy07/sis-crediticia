<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");

    $idcaja_ori = $_POST['movimiento_caja_ori'];
    $idcaja_des = $_POST['movimiento_caja_des'];
    $idcajero = $_POST['caja_resp-hidden'];
    $idautoriza = $_POST['movimiento_autoriza-hidden'];
    
    $movimiento_monto = floatval($_POST['movimiento_monto']);
    $movimiento_concepto = $_POST['movimiento_concepto'];
    //$movimiento_autoriza = $_POST['movimiento_autoriza'];


    
    $resultadoBD = false;
    $rs = $mysqli->query("SELECT cajas.capital FROM cajas WHERE idcaja = '$idcaja_ori'");
    if($row = $rs->fetch_array()) {
        $capital_act_ori = trim($row['capital']);
        $capital_act_ori = floatval($capital_act_ori);
    }else{
        die("No se puede acceder a la Caja de Origen");
    }

    $rs2 = $mysqli->query("SELECT cajas.capital FROM cajas WHERE idcaja = '$idcaja_des'");
    if($row = $rs2->fetch_array()) {
        $capital_act_des = trim($row['capital']);
        $capital_act_des = floatval($capital_act_des);
    }else{
        die("No se puede acceder a la Caja de Destino");
    }

  
    $capital_res_ori = $capital_act_ori - $movimiento_monto;
    $capital_res_des = $capital_act_des + $movimiento_monto;


    if($capital_res_ori >= 0){
        $query = "INSERT INTO transferencias(tipo,monto,concepto,fecha_mov,usuarios_idusuario,usuarios_idusuario1,cajas_idcaja,cajas_idcaja1) VALUES ('TRANSFERENCIA','$movimiento_monto','$movimiento_concepto',now(),'$idcajero','$idautoriza','$idcaja_ori','$idcaja_des');"; 
        $query .= "UPDATE `cajas` SET `capital`='$capital_res_ori' WHERE `idcaja` = '$idcaja_ori';";
        $query .= "UPDATE `cajas` SET `capital`='$capital_res_des' WHERE `idcaja` = '$idcaja_des';";
    }else{
        die("600");
    }
        
    
    
    $result = $mysqli->multi_query($query);

    
    if($result){
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