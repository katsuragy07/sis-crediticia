<?php
session_start();
require_once "../../connect.php";

$iduser = $_SESSION['id'];
$privilegios = $_SESSION['privilegios'];

$clave = $_GET['fecha'];
$caja = $_GET['caja'];


if($clave==0 || $clave==null || $clave==""){
    $clave = date("Y-m-d");
}
                


$query = "SELECT * FROM billetaje_hist WHERE idbilletaje = (SELECT billetaje_hist_idbilletaje FROM aperturas WHERE (fecha_cierre LIKE '$clave%') AND cajas_idcaja='$caja' ORDER BY fecha_cierre DESC LIMIT 1);"; 

                    



$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'm200' => $row['cant_200']+0,
        'm100' => $row['cant_100']+0,
        'm50' => $row['cant_50']+0,
        'm20' => $row['cant_20']+0,
        'm10' => $row['cant_10']+0,
        'm5' => $row['cant_5']+0,
        'm2' => $row['cant_2']+0,
        'm1' => $row['cant_1']+0,
        'm0_5' => $row['cant_0_5']+0,
        'm0_2' => $row['cant_0_2']+0,
        'm0_1' => $row['cant_0_1']+0,

        't200' => $row['cant_200']*200,
        't100' => $row['cant_100']*100,
        't50' => $row['cant_50']*50,
        't20' => $row['cant_20']*20,
        't10' => $row['cant_10']*10,
        't5' => $row['cant_5']*5,
        't2' => $row['cant_2']*2,
        't1' => $row['cant_1']*1,
        't0_5' => $row['cant_0_5']*0.5,
        't0_2' => $row['cant_0_2']*0.2,
        't0_1' => $row['cant_0_1']*0.1,

        't_billetes' => $row['cant_200']*200 + $row['cant_100']*100 +$row['cant_50']*50 + $row['cant_20']*20 + $row['cant_10']*10,
        't_monedas' => $row['cant_5']*5 + $row['cant_2']*2 +$row['cant_1']*1 + $row['cant_0_5']*0.5 + $row['cant_0_2']*0.2 + $row['cant_0_1']*0.1
    );
    
   
}

echo json_encode($json);



?>