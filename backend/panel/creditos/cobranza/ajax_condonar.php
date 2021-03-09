<?php

    require_once "../../../connect.php";
    date_default_timezone_set("America/Lima");
    
    $idcredito = $_POST['id'];

    $monto = $_POST['pago_monto-c'];
    $idcajero = $_POST['inputCAJA-hidden-c'];
    $idcliente = $_POST['inputCLIENT-hidden-c'];


    $resultadoBD = false;

  

    $query = "UPDATE creditos SET `estado`='FINALIZADO' WHERE idcredito='$idcredito';";
    $query .= "UPDATE clientes SET `observaciones` = CONCAT(observaciones, '- Condonacion de deuda de: S/. $monto','\n') WHERE idcliente='$idcliente';";
    $query .= "INSERT INTO voucher_pago(monto_pago,tipo_vp,fecha_pago,creditos_idcredito,usuarios_idusuario) VALUES ('$monto','CONDONACION',now(),'$idcredito','$idcajero');";
    
    
    $result = $mysqli->multi_query($query);
   


    if($result){
        echo '200';
    }else{
        die("Query error " . mysqli_error($mysqli));
    }

   
 

?>