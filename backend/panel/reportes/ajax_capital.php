<?php
session_start();
require_once "../../connect.php";

$iduser = $_SESSION['id'];
$privilegios = $_SESSION['privilegios'];

$caja = $_GET['caja'];


                
if($privilegios=="ROOT" || $privilegios=="ADMINISTRADOR"){
    if($caja=="TODOS"){
        $query = "SELECT * FROM cajas;"; 
    }else{
        $query = "SELECT * FROM cajas WHERE idcaja = '$caja';"; 
    } 
}else{
    if($caja=="TODOS"){
        $query = "SELECT * FROM cajas WHERE usuarios_idusuario = '$iduser';"; 
    }else{
        $query = "SELECT * FROM cajas WHERE idcaja = '$caja';"; 
    }
}
                    

$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'idcaja' => $row['idcaja'],
        'nombre' => $row['nombre'],
        'capital' => $row['capital'],
        'estado' => $row['estado'],
        'billetaje_reg' => $row['billetaje_reg'],
        'fecha_creacion' => $row['fecha_creacion']
    );
    
   
}

echo json_encode($json);



?>