<?php

require_once "../../../connect.php";

$id = $_GET['id'];

switch($_GET['consulta']){
    case 'buscar':  $query = "
                        SELECT * FROM movimientos_cc WHERE cuenta_corriente_idcuenta = '$id';";
                    break;

    case 'editar':  
                    $query = "
                        SELECT * FROM movimientos_cc WHERE cuenta_corriente_idcuenta = '$id';";
                    break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'id' => $row['idmovimiento'],
        'monto' => $row['monto_mov'],
        'fecha' => $row['fecha_mov'],
        
    );
    
   
}

echo json_encode($json);



?>