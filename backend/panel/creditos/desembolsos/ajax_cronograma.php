<?php

    require_once "../../../connect.php";

    $iddesembolso = $_GET['iddesembolso'];


    $query = "SELECT * FROM pagos WHERE pagos.creditos_idcredito = (SELECT creditos_idcredito FROM desembolso WHERE iddesembolso = '$iddesembolso');";

    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }

    $cuota_fecha_pagada;
    $json = array();
    while($row = $result->fetch_array()){
    
        if($row['fecha']!="" && $row['fecha']!=null && $row['fecha']!='0000-00-00 00:00:00'){
            $cuota_fecha_pagada = date("d-m-Y H:i:s",strtotime($row['fecha']));
        }else{
            $cuota_fecha_pagada = "";
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