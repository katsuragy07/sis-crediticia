<?php

    require_once "../../../connect.php";

    $idpago = $_GET['idpago'];


    $query = "SELECT * FROM pagos WHERE pagos.idpago = '$idpago';";

    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }

    $cuota_fecha_pagada;

    $json = array();
    while($row = $result->fetch_array()){

        if($row['fecha']!="" && $row['fecha']!=null && $row['fecha']!='0000-00-00 00:00:00'){
            $cuota_fecha_pagada = $row['fecha'];
        }

        $json[] = array(
            'idpago' => $row['idpago'],
            'n_cuota_programada' => $row['n_cuota_programada'],
            'fecha_programada' => date("d-m-Y",strtotime($row['fecha_programada'])),
            'cuota_programada' => $row['cuota_programada'],
            'monto' => $row['monto'],
            'fecha' => $cuota_fecha_pagada,
            'mora' => $row['mora']
        );
        
       
    }
    
    echo json_encode($json);





?>