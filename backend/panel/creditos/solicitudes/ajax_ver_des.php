<?php
session_start();
require_once "../../../connect.php";

$iduser = $_SESSION['id'];
$privilegios = $_SESSION['privilegios'];

switch($_GET['consulta']){
    case 'buscar': 
                    if($privilegios=="ROOT"){
                        $query = "
                                SELECT idcliente, idusuario, idcredito, idsolicitud, conyugue.idconyugue AS idconyugue, aval.idconyugue AS idaval, clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat, usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat, conyugue.nombre AS con_nombre, conyugue.apellido_pat AS con_apellido_pat, conyugue.apellido_mat AS con_apellido_mat, aval.nombre AS ava_nombre, aval.apellido_pat AS ava_apellido_pat, aval.apellido_mat AS ava_apellido_mat, monto_prop, monto_aprob, n_cuotas, n_cuotas_aprob, interes, interes_aprob, frecuencia, fecha_inicio, m_cuotas, m_cuotas_aprob, m_interes, m_interes_aprob, m_total, m_total_aprob, ifnull(fecha_pre,0) AS fecha_pre, negocio_des, estado
                                FROM solicitudes 
                                INNER JOIN creditos ON solicitudes.creditos_idcredito = creditos.idcredito 
                                INNER JOIN clientes ON clientes.idcliente = creditos.clientes_idcliente 
                                INNER JOIN usuarios ON usuarios.idusuario = solicitudes.usuarios_idusuario
                                LEFT JOIN conyugue ON conyugue.idconyugue = creditos.conyugue_id
                                LEFT JOIN aval ON aval.idconyugue = creditos.aval_id ORDER BY solicitudes.idsolicitud DESC;
                            "; break;
                    }else{
                        $query = "
                                SELECT idcliente, idusuario, idcredito, idsolicitud, conyugue.idconyugue AS idconyugue, aval.idconyugue AS idaval, clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat, usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat, conyugue.nombre AS con_nombre, conyugue.apellido_pat AS con_apellido_pat, conyugue.apellido_mat AS con_apellido_mat, aval.nombre AS ava_nombre, aval.apellido_pat AS ava_apellido_pat, aval.apellido_mat AS ava_apellido_mat, monto_prop, monto_aprob, n_cuotas, n_cuotas_aprob, interes, interes_aprob, frecuencia, fecha_inicio, m_cuotas, m_cuotas_aprob, m_interes, m_interes_aprob, m_total, m_total_aprob, ifnull(fecha_pre,0) AS fecha_pre, negocio_des,estado
                                FROM solicitudes 
                                INNER JOIN creditos ON solicitudes.creditos_idcredito = creditos.idcredito 
                                INNER JOIN clientes ON clientes.idcliente = creditos.clientes_idcliente 
                                INNER JOIN usuarios ON usuarios.idusuario = solicitudes.usuarios_idusuario
                                LEFT JOIN conyugue ON conyugue.idconyugue = creditos.conyugue_id
                                LEFT JOIN aval ON aval.idconyugue = creditos.aval_id
                                WHERE solicitudes.usuarios_idusuario = '$iduser' ORDER BY solicitudes.idsolicitud DESC;
                            "; break;
                    }
                    

    case 'editar': $id = $_GET['id'];
                   $query = "
                                SELECT idcliente, idusuario, idcredito, idsolicitud, conyugue.idconyugue AS idconyugue, aval.idconyugue AS idaval, clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat, usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat, conyugue.nombre AS con_nombre, conyugue.apellido_pat AS con_apellido_pat, conyugue.apellido_mat AS con_apellido_mat, aval.nombre AS ava_nombre, aval.apellido_pat AS ava_apellido_pat, aval.apellido_mat AS ava_apellido_mat, monto_prop, monto_aprob, n_cuotas, n_cuotas_aprob, interes, interes_aprob, frecuencia, fecha_inicio, m_cuotas, m_cuotas_aprob, m_interes, m_interes_aprob, m_total, m_total_aprob, ifnull(fecha_pre,0) AS fecha_pre, negocio_des, estado
                                FROM solicitudes 
                                INNER JOIN creditos ON solicitudes.creditos_idcredito = creditos.idcredito 
                                INNER JOIN clientes ON clientes.idcliente = creditos.clientes_idcliente 
                                INNER JOIN usuarios ON usuarios.idusuario = solicitudes.usuarios_idusuario
                                LEFT JOIN conyugue ON conyugue.idconyugue = creditos.conyugue_id
								LEFT JOIN aval ON aval.idconyugue = creditos.aval_id
                                WHERE solicitudes.idsolicitud='$id';
                            "; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();
$fecha_preaprobacion;

while($row = $result->fetch_array()){
    
    if($row['fecha_pre']!=0){
        $fecha_preaprobacion = date("Y-m-d",strtotime($row['fecha_pre']));
    }else{
        $fecha_preaprobacion = null;
    }

    $json[] = array(
        'idcredito' => $row['idcredito'],
        'idsolicitud' => $row['idsolicitud'],
        'idcliente' => $row['idcliente'],
        'idusuario' => $row['idusuario'],
        'idconyugue' => $row['idconyugue'],
        'idaval' => $row['idaval'],

        'cli_nombre' => $row['cli_nombre'],
        'cli_apellido_pat' => $row['cli_apellido_pat'],
        'cli_apellido_mat' => $row['cli_apellido_mat'],
        'usu_nombre' => $row['usu_nombre'],
        'usu_apellido_pat' => $row['usu_apellido_pat'],
        'usu_apellido_mat' => $row['usu_apellido_mat'],

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
        'fecha_preaprob' => $fecha_preaprobacion,
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