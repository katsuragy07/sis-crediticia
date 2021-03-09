<?php

require_once "../../../connect.php";

switch($_GET['consulta']){
    case 'buscar': $query = "
                                    SELECT idaprobacion, idcliente, us_ases.idusuario as idases, us_adm.idusuario as idadm, idcredito, idsolicitud, conyugue.idconyugue AS idconyugue, aval.idconyugue AS idaval, clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat, 
                                    us_ases.nombre AS usu_ases_nombre, us_ases.apellido_pat AS usu_ases_apellido_pat, us_ases.apellido_mat AS usu_ases_apellido_mat, 
                                    us_adm.nombre AS usu_adm_nombre, us_adm.apellido_pat AS usu_adm_apellido_pat, us_adm.apellido_mat AS usu_adm_apellido_mat,
                                    conyugue.nombre AS con_nombre, conyugue.apellido_pat AS con_apellido_pat, conyugue.apellido_mat AS con_apellido_mat, aval.nombre AS ava_nombre, aval.apellido_pat AS ava_apellido_pat, aval.apellido_mat AS ava_apellido_mat, monto_prop, monto_aprob, n_cuotas, n_cuotas_aprob, interes, interes_aprob, frecuencia, fecha_inicio, m_cuotas, m_cuotas_aprob, m_interes, m_interes_aprob, m_total, m_total_aprob, fecha_pre, ifnull(fecha_aprob,0) AS fecha_aprob, negocio_des, estado
                                                    FROM aprobaciones
                                                    INNER JOIN creditos ON aprobaciones.creditos_idcredito = creditos.idcredito
                                                    INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
                                                    INNER JOIN clientes ON clientes.idcliente = creditos.clientes_idcliente 
                                                    INNER JOIN usuarios us_ases ON us_ases.idusuario = solicitudes.usuarios_idusuario
                                                    LEFT JOIN usuarios us_adm ON us_adm.idusuario = aprobaciones.usuarios_idusuario 
                                                    LEFT JOIN conyugue ON conyugue.idconyugue = creditos.conyugue_id
                                                    LEFT JOIN aval ON aval.idconyugue = creditos.aval_id
                                                    WHERE creditos.estado = 'PREAPROBADO' OR creditos.estado = 'APROBADO';
                            "; break;

    case 'editar': $id = $_GET['id'];
                   $query = "
                                SELECT idaprobacion, idcliente, us_ases.idusuario as idases, us_adm.idusuario as idadm, idcredito, idsolicitud, conyugue.idconyugue AS idconyugue, aval.idconyugue AS idaval, clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat, 
                                us_ases.nombre AS usu_ases_nombre, us_ases.apellido_pat AS usu_ases_apellido_pat, us_ases.apellido_mat AS usu_ases_apellido_mat, 
                                us_adm.nombre AS usu_adm_nombre, us_adm.apellido_pat AS usu_adm_apellido_pat, us_adm.apellido_mat AS usu_adm_apellido_mat,
                                conyugue.nombre AS con_nombre, conyugue.apellido_pat AS con_apellido_pat, conyugue.apellido_mat AS con_apellido_mat, aval.nombre AS ava_nombre, aval.apellido_pat AS ava_apellido_pat, aval.apellido_mat AS ava_apellido_mat, monto_prop, monto_aprob, n_cuotas, n_cuotas_aprob, interes, interes_aprob, frecuencia, fecha_inicio, m_cuotas, m_cuotas_aprob, m_interes, m_interes_aprob, m_total, m_total_aprob, fecha_pre, ifnull(fecha_aprob,0) AS fecha_aprob, negocio_des, estado
                                                   FROM aprobaciones
                                                   INNER JOIN creditos ON aprobaciones.creditos_idcredito = creditos.idcredito
                                                   INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
                                                   INNER JOIN clientes ON clientes.idcliente = creditos.clientes_idcliente 
                                                   INNER JOIN usuarios us_ases ON us_ases.idusuario = solicitudes.usuarios_idusuario
                                                   LEFT JOIN usuarios us_adm ON us_adm.idusuario = aprobaciones.usuarios_idusuario 
                                                   LEFT JOIN conyugue ON conyugue.idconyugue = creditos.conyugue_id
                                                   LEFT JOIN aval ON aval.idconyugue = creditos.aval_id
                                                   WHERE aprobaciones.idaprobacion = '$id';
                            "; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    if($row['fecha_aprob']!=0){
        $fecha_aprobacion = date("d-m-Y",strtotime($row['fecha_aprob']));
    }else{
        $fecha_aprobacion = null;
    }

    $json[] = array(
        'idaprobacion' => $row['idaprobacion'],
        'idcredito' => $row['idcredito'],
        'idsolicitud' => $row['idsolicitud'],
        'idcliente' => $row['idcliente'],
        'idases' => $row['idases'],
        'idadm' => $row['idadm'],
        'idconyugue' => $row['idconyugue'],
        'idaval' => $row['idaval'],

        'cli_nombre' => $row['cli_nombre'],
        'cli_apellido_pat' => $row['cli_apellido_pat'],
        'cli_apellido_mat' => $row['cli_apellido_mat'],
        'usu_ases_nombre' => $row['usu_ases_nombre'],
        'usu_ases_apellido_pat' => $row['usu_ases_apellido_pat'],
        'usu_ases_apellido_mat' => $row['usu_ases_apellido_mat'],
        'usu_adm_nombre' => $row['usu_adm_nombre'],
        'usu_adm_apellido_pat' => $row['usu_adm_apellido_pat'],
        'usu_adm_apellido_mat' => $row['usu_adm_apellido_mat'],

        'con_nombre' => $row['con_nombre'],
        'con_apellido_pat' => $row['con_apellido_pat'],
        'con_apellido_mat' => $row['con_apellido_mat'],
        'ava_nombre' => $row['ava_nombre'],
        'ava_apellido_pat' => $row['ava_apellido_pat'],
        'ava_apellido_mat' => $row['ava_apellido_mat'],

     
        'monto_prop' => $row['monto_prop'],
        'monto_aprob' => $row['monto_aprob'],
        'n_cuotas' => $row['n_cuotas'],
        'n_cuotas_aprob' => $row['n_cuotas_aprob'],
        'interes' => $row['interes'],
        'interes_aprob' => $row['interes_aprob'],
        'frecuencia' => $row['frecuencia'],
        'fecha_inicio' => $row['fecha_inicio'],
        'fecha_preaprob' => date("d-m-Y",strtotime($row['fecha_pre'])),
        'fecha_aprob' => $fecha_aprobacion,
        'm_cuotas' => $row['m_cuotas'],
        'm_cuotas_aprob' => $row['m_cuotas_aprob'],
        'm_interes' => $row['m_interes'],
        'm_interes_aprob' => $row['m_interes_aprob'],
        'm_total' => $row['m_total'],
        'm_total_aprob' => $row['m_total_aprob'],
        'negocio' => $row['negocio_des'],
        'estado' => $row['estado']
    );
    
   
}

echo json_encode($json);



?>