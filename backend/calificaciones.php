<?php

require_once "connect.php";


$query = "
            SELECT clientes.idcliente, clientes.nombre, clientes.apellido_pat, clientes.apellido_mat, creditos.idcredito, 
            pagos.fecha_programada,
            creditos.monto_aprob, creditos.interes_aprob, creditos.frecuencia, creditos.n_cuotas_aprob, 
            creditos.monto_aprob + creditos.m_interes_aprob AS 'C+I', 
            round(sum(ifnull(monto,0)),2) AS recaudado, 
            CASE WHEN round(sum(cuota_programada) - sum(ifnull(monto,0)),2) < 0 THEN 0 ELSE round(sum(cuota_programada) - sum(ifnull(monto,0)),2)  END AS 'restante', 
            CURDATE() AS 'hoy', 
            SUM(CASE WHEN IFNULL(mora,0) > 0 THEN (CASE WHEN cuota_programada + mora - IFNULL(monto,0) > 0 THEN mora ELSE 0 END) ELSE 0 END) AS 'atraso', 
            round(sum(cuota_programada) + sum(ifnull(mora,0)) - sum(ifnull(monto,0)),2) AS 'restante_mora', 
            sum(ifnull(mora,0)) as moras FROM clientes 
                            INNER JOIN creditos ON clientes.idcliente = creditos.clientes_idcliente 
                            INNER JOIN pagos ON creditos.idcredito = pagos.creditos_idcredito
                            WHERE creditos.estado = 'DESEMBOLSADO' GROUP BY clientes.idcliente ORDER BY atraso ASC;
        ";

$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}


while($row = $result->fetch_array()){

    $idcliente = $row['idcliente'];

    if($row['atraso'] >= 0 && $row['atraso'] < 5){
        $query2 = "UPDATE `clientes` SET `calificacion`='BUENO' WHERE `idcliente` = '$idcliente';";
        $result2 = $mysqli->query($query2);  
    }

    if($row['atraso'] >= 5 && $row['atraso'] < 15){
        $query2 = "UPDATE `clientes` SET `calificacion`='REGULAR' WHERE `idcliente` = '$idcliente';";
        $result2 = $mysqli->query($query2);
    }

    if($row['atraso'] >= 15){
        $query2 = "UPDATE `clientes` SET `calificacion`='MALO' WHERE `idcliente` = '$idcliente';";
        $result2 = $mysqli->query($query2);
    }

}



if($result && $result2){
    echo '200';
}else{   
    die("Query error " . mysqli_error($mysqli));
}




?>