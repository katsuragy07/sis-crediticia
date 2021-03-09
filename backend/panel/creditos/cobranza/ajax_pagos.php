<?php

    require_once "../../../connect.php";

    $idcredito = $_GET['idcredito'];


    $query = "SELECT * FROM voucher_pago WHERE creditos_idcredito = '$idcredito';";

    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'id' => $row['idvoucher'],
            'monto' => $row['monto_pago'],
            'fecha' => date("d-m-Y H:i:s",strtotime($row['fecha_pago']))
        );
        
       
    }
    
    echo json_encode($json);





?>