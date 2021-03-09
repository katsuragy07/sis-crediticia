<?php

require_once "../../connect.php";

switch($_GET['consulta']){
    case 'buscar': $query = 'SELECT clientes_idcliente, estado FROM creditos ORDER BY clientes_idcliente;'; break;
    case 'editar': $id = $_GET['id'];
                   $query = "SELECT clientes_idcliente, estado FROM creditos WHERE idcliente='$id' ORDER BY clientes_idcliente;"; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'id' => $row['clientes_idcliente'],
        'estado' => $row['estado'] 
    );
    
   
}

echo json_encode($json);



?>