<?php

    require_once "../../../connect.php";

    $idsolicitud = $_POST['id']; 

    $rs = $mysqli->query("SELECT solicitudes.creditos_idcredito FROM solicitudes WHERE idsolicitud = '$idsolicitud';");
    if ($row = $rs->fetch_array()) {
        $idcredito = trim($row['creditos_idcredito']);
    }else{
        die("No se pudo eliminar la solicitud!. Error en la Base de Datos.");
    }

    $query1 = "DELETE FROM `solicitudes` WHERE `idsolicitud`='$idsolicitud';";
    $query2 = "DELETE FROM `creditos` WHERE `idcredito`='$idcredito';";
  
    
    $result1 = $mysqli->query($query1);
    $result2 = $mysqli->query($query2);


    if($result1 && $result2){
        echo '200';
    }else{
        die("Query error " . mysqli_error($mysqli));
    }
 

?>