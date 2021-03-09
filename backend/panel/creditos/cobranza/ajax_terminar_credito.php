<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");
    

    $idcredito = $_POST['id'];


    $rs = $mysqli->query("SELECT sum(monto) AS pagado, sum(cuota_programada) + sum(ifnull(mora,0)) AS deuda_total FROM pagos WHERE creditos_idcredito = '$idcredito' GROUP BY creditos_idcredito;");
    if ($row = $rs->fetch_array()) {
        $pagado = trim($row['pagado']);
        $pagado = floatval($pagado);
        $deuda_total = trim($row['deuda_total']);
        $deuda_total = floatval($deuda_total);
    }
 

    if($pagado >= $deuda_total){
        $query = "UPDATE creditos SET `estado`='FINALIZADO' WHERE idcredito='$idcredito';"; 
        $result = $mysqli->multi_query($query);
        $msg = "finalizado";
    }else{
        $msg = "deuda";
        $result = true;
    }
   


    if($result){
        echo $msg;
    }else{
        die("Query error " . mysqli_error($mysqli));
    }

   
 

?>