<?php

    require_once "../../../connect.php";

    $idcredito = $_GET['idcredito'];


    $query = "SELECT 	round(sum(cuota_programada),2) AS deuda_credito, 
                        round(sum(ifnull(monto,0)),2) AS pagado, 
                        round(sum(ifnull(mora,0)),2) AS deuda_moras, 
                        round(sum(cuota_programada) + sum(ifnull(mora,0)) - sum(ifnull(monto,0)),2) AS deuda_total   
                        FROM pagos WHERE creditos_idcredito = '$idcredito';";

    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'deuda_credito' => $row['deuda_credito'],
            'deuda_moras' => $row['deuda_moras'],
            'deuda_total' => $row['deuda_total'],
            'pagado' => $row['pagado']
        );
        
       
    }
    
    echo json_encode($json);





?>