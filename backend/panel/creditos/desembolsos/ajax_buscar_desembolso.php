<?php
    session_start();
    require_once "../../../connect.php";

    date_default_timezone_set('America/Lima');
    
    $iduser = $_SESSION['id'];
    $privilegios = $_SESSION['privilegios'];

    $clave = $_GET['clave'];
    $tipo = $_GET['tipo'];


    if($tipo=="DNI"){
            $query = "
                SELECT iddesembolso, idcliente, us_ases.idusuario as idases, us_adm.idusuario as idadm, us_caja.idusuario as idcaja, idcredito, idsolicitud, conyugue.idconyugue AS idconyugue, aval.idconyugue AS idaval, clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat, 
                us_ases.nombre AS usu_ases_nombre, us_ases.apellido_pat AS usu_ases_apellido_pat, us_ases.apellido_mat AS usu_ases_apellido_mat, 
                us_adm.nombre AS usu_adm_nombre, us_adm.apellido_pat AS usu_adm_apellido_pat, us_adm.apellido_mat AS usu_adm_apellido_mat,
                us_caja.nombre AS usu_caja_nombre, us_caja.apellido_pat AS usu_caja_apellido_pat, us_caja.apellido_mat AS usu_caja_apellido_mat,
                conyugue.nombre AS con_nombre, conyugue.apellido_pat AS con_apellido_pat, conyugue.apellido_mat AS con_apellido_mat, aval.nombre AS ava_nombre, aval.apellido_pat AS ava_apellido_pat, aval.apellido_mat AS ava_apellido_mat, monto_prop, monto_aprob, n_cuotas, n_cuotas_aprob, interes, interes_aprob, frecuencia, fecha_inicio, fecha_desem, m_cuotas, m_cuotas_aprob, m_interes, m_interes_aprob, m_total, m_total_aprob, estado
                                FROM aprobaciones
                                INNER JOIN creditos ON aprobaciones.creditos_idcredito = creditos.idcredito
                                INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
                                INNER JOIN desembolso ON desembolso.creditos_idcredito = creditos.idcredito
                                INNER JOIN clientes ON clientes.idcliente = creditos.clientes_idcliente 
                                INNER JOIN usuarios us_ases ON us_ases.idusuario = solicitudes.usuarios_idusuario
                                LEFT JOIN usuarios us_adm ON us_adm.idusuario = aprobaciones.usuarios_idusuario 
                                LEFT JOIN usuarios us_caja ON us_caja.idusuario = desembolso.usuarios_idusuario
                                LEFT JOIN conyugue ON conyugue.idconyugue = creditos.conyugue_id
                                LEFT JOIN aval ON aval.idconyugue = creditos.aval_id
                                WHERE (creditos.estado = 'APROBADO' OR creditos.estado = 'DESEMBOLSADO' OR creditos.estado = 'FINALIZADO') AND clientes.dni LIKE '$clave%' ORDER BY iddesembolso DESC;
            ";
    }else{
            $query = "
                SELECT iddesembolso, idcliente, us_ases.idusuario as idases, us_adm.idusuario as idadm, us_caja.idusuario as idcaja, idcredito, idsolicitud, conyugue.idconyugue AS idconyugue, aval.idconyugue AS idaval, clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat, 
                us_ases.nombre AS usu_ases_nombre, us_ases.apellido_pat AS usu_ases_apellido_pat, us_ases.apellido_mat AS usu_ases_apellido_mat, 
                us_adm.nombre AS usu_adm_nombre, us_adm.apellido_pat AS usu_adm_apellido_pat, us_adm.apellido_mat AS usu_adm_apellido_mat,
                us_caja.nombre AS usu_caja_nombre, us_caja.apellido_pat AS usu_caja_apellido_pat, us_caja.apellido_mat AS usu_caja_apellido_mat,
                conyugue.nombre AS con_nombre, conyugue.apellido_pat AS con_apellido_pat, conyugue.apellido_mat AS con_apellido_mat, aval.nombre AS ava_nombre, aval.apellido_pat AS ava_apellido_pat, aval.apellido_mat AS ava_apellido_mat, monto_prop, monto_aprob, n_cuotas, n_cuotas_aprob, interes, interes_aprob, frecuencia, fecha_inicio, fecha_desem, m_cuotas, m_cuotas_aprob, m_interes, m_interes_aprob, m_total, m_total_aprob, estado
                                FROM aprobaciones
                                INNER JOIN creditos ON aprobaciones.creditos_idcredito = creditos.idcredito
                                INNER JOIN solicitudes ON solicitudes.creditos_idcredito = creditos.idcredito
                                INNER JOIN desembolso ON desembolso.creditos_idcredito = creditos.idcredito
                                INNER JOIN clientes ON clientes.idcliente = creditos.clientes_idcliente 
                                INNER JOIN usuarios us_ases ON us_ases.idusuario = solicitudes.usuarios_idusuario
                                LEFT JOIN usuarios us_adm ON us_adm.idusuario = aprobaciones.usuarios_idusuario 
                                LEFT JOIN usuarios us_caja ON us_caja.idusuario = desembolso.usuarios_idusuario
                                LEFT JOIN conyugue ON conyugue.idconyugue = creditos.conyugue_id
                                LEFT JOIN aval ON aval.idconyugue = creditos.aval_id
                                WHERE (creditos.estado = 'APROBADO' OR creditos.estado = 'DESEMBOLSADO' OR creditos.estado = 'FINALIZADO') AND concat(clientes.nombre,' ',clientes.apellido_pat,' ',clientes.apellido_mat) LIKE '%$clave%' ORDER BY iddesembolso DESC;
            ";
    }
    
    

    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }

    $fecha = date('d-m-Y');
    $json = array();
    
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'hoy' => $fecha,
            'iddesembolso' => $row['iddesembolso'],
            'idcredito' => $row['idcredito'],
            'idsolicitud' => $row['idsolicitud'],
            'idcliente' => $row['idcliente'],
            'idases' => $row['idases'],
            'idadm' => $row['idadm'],
            'idcaja' => $row['idcaja'],
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
            'usu_caja_nombre' => $row['usu_caja_nombre'],
            'usu_caja_apellido_pat' => $row['usu_caja_apellido_pat'],
            'usu_caja_apellido_mat' => $row['usu_caja_apellido_mat'],

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
            'fecha_desem' => date("d-m-Y",strtotime($row['fecha_desem'])),
            'fecha_inicio' => $row['fecha_inicio'],
            'm_cuotas' => $row['m_cuotas'],
            'm_cuotas_aprob' => $row['m_cuotas_aprob'],
            'm_interes' => $row['m_interes'],
            'm_interes_aprob' => $row['m_interes_aprob'],
            'm_total' => $row['m_total'],
            'm_total_aprob' => $row['m_total_aprob'],
            'estado' => $row['estado'],
            'user_privilegios' => $privilegios
        );
        
       
    }
    
    echo json_encode($json);





?>