<?php

    require_once "../../../connect.php";

    $data = json_decode($_POST['array'],true);
    $query = "";

    //var_dump($data);
    

    foreach ($data as $value) {
        $id =   $value['id'];
        $n_cuota = $value['n_cuota'];
        $fecha =  $value['fecha'];
        $fecha =  date("Y-m-d", strtotime($fecha));
        $cuota =  $value['cuota'];
        
        $query .= "INSERT INTO pagos(n_cuota_programada,fecha_programada,cuota_programada,creditos_idcredito) VALUES ('$n_cuota','$fecha','$cuota',(SELECT creditos_idcredito FROM desembolso WHERE iddesembolso='$id'));";
    }


    $result = $mysqli->multi_query($query);
     
    //echo $result;
    
    if($result){
        echo '200';
    }else{
        die("Query error " . mysqli_error($mysqli));
    }
    
 


?>