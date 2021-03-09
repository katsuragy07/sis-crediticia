<?php
session_start();
require_once "../../connect.php";

$iduser = $_SESSION['id'];
$privilegios = $_SESSION['privilegios'];

$tipo = $_GET['tipo'];
$clave = $_GET['clave'];

if($tipo=="CLIENTE"){
    if($privilegios=="ASESOR"){
        $query = "
            SELECT clientes.idcliente, clientes.nombre, clientes.apellido_pat, clientes.apellido_mat, creditos.idcredito, 
            usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat,
            desembolso.fecha_desem, pagos.fecha_programada,
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
                            INNER JOIN desembolso ON desembolso.creditos_idcredito = creditos.idcredito
                            INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
                            INNER JOIN usuarios ON solicitudes.usuarios_idusuario = usuarios.idusuario
                            WHERE solicitudes.usuarios_idusuario = '$iduser' AND creditos.estado = 'DESEMBOLSADO' AND concat(clientes.nombre,' ',clientes.apellido_pat,' ',clientes.apellido_mat) LIKE '%$clave%' GROUP BY creditos.idcredito ORDER BY atraso ASC;
        ";
    }else{
        $query = "
            SELECT clientes.idcliente, clientes.nombre, clientes.apellido_pat, clientes.apellido_mat, creditos.idcredito, 
            usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat,
            desembolso.fecha_desem, pagos.fecha_programada,
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
                            INNER JOIN desembolso ON desembolso.creditos_idcredito = creditos.idcredito
                            INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
                            INNER JOIN usuarios ON solicitudes.usuarios_idusuario = usuarios.idusuario
                            WHERE creditos.estado = 'DESEMBOLSADO' AND concat(clientes.nombre,' ',clientes.apellido_pat,' ',clientes.apellido_mat) LIKE '%$clave%' GROUP BY creditos.idcredito ORDER BY atraso ASC;
        ";
    }
}else{
    if($privilegios=="ASESOR"){
        $query = "
            SELECT clientes.idcliente, clientes.nombre, clientes.apellido_pat, clientes.apellido_mat, creditos.idcredito, 
            usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat,
            desembolso.fecha_desem, pagos.fecha_programada,
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
                            INNER JOIN desembolso ON desembolso.creditos_idcredito = creditos.idcredito
                            INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
                            INNER JOIN usuarios ON solicitudes.usuarios_idusuario = usuarios.idusuario
                            WHERE solicitudes.usuarios_idusuario = '$iduser' AND creditos.estado = 'DESEMBOLSADO' AND concat(usuarios.nombre,' ',usuarios.apellido_pat,' ',usuarios.apellido_mat) LIKE '%$clave%' GROUP BY creditos.idcredito ORDER BY atraso ASC;
        ";
    }else{
        $query = "
            SELECT clientes.idcliente, clientes.nombre, clientes.apellido_pat, clientes.apellido_mat, creditos.idcredito, 
            usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat,
            desembolso.fecha_desem, pagos.fecha_programada,
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
                            INNER JOIN desembolso ON desembolso.creditos_idcredito = creditos.idcredito
                            INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
                            INNER JOIN usuarios ON solicitudes.usuarios_idusuario = usuarios.idusuario
                            WHERE creditos.estado = 'DESEMBOLSADO' AND concat(usuarios.nombre,' ',usuarios.apellido_pat,' ',usuarios.apellido_mat) LIKE '%$clave%' GROUP BY creditos.idcredito ORDER BY atraso ASC;
        ";
    }
}


                
             



$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'idcliente' => $row['idcliente'],
        'idcredito' => $row['idcredito'],
        'nombre' => $row['nombre'],
        'apellido_pat' => $row['apellido_pat'],
        'apellido_mat' => $row['apellido_mat'],

        'usu_nombre' => $row['usu_nombre'],
        'usu_apellido_pat' => $row['usu_apellido_pat'],
        'usu_apellido_mat' => $row['usu_apellido_mat'],

        'fecha_desem' => date("d-m-Y",strtotime($row['fecha_desem'])),
        'monto' => $row['monto_aprob'],
        'interes' => $row['interes_aprob'],
        'frecuencia' => $row['frecuencia'],
        'n_cuotas' => $row['n_cuotas_aprob'],
        'capital_interes' => $row['C+I'],
        'recaudado' => $row['recaudado'],
        'restante' => $row['restante'],
        'hoy' => date("d-m-Y",strtotime($row['hoy'])),
        'atraso' => $row['atraso'],
        'restante_mora' => $row['restante_mora'],
        'moras' => $row['moras']
    );
    
   
}

echo json_encode($json);



?>