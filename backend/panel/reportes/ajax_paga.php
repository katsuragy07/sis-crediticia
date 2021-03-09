<?php
session_start();
require_once "../../connect.php";

$iduser = $_SESSION['id'];
$privilegios = $_SESSION['privilegios'];

$inicio = $_GET['inicio'];


if($inicio==null || $inicio == ""){
    $inicio = date("Y-m-d");
}



switch($_GET['consulta']){ 
    case 'buscar':
                    if($privilegios=="ROOT" || $privilegios=="ADMINISTRADOR"){
                        $query = "
                        SELECT *,solicitudes.usuarios_idusuario AS idasesor,
                            clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat, 
                            usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                            FROM pagos
                            INNER JOIN creditos ON pagos.creditos_idcredito = creditos.idcredito
                            INNER JOIN solicitudes ON creditos.idcredito = solicitudes.creditos_idcredito
                            INNER JOIN clientes ON creditos.clientes_idcliente = clientes.idcliente
                            INNER JOIN usuarios ON solicitudes.usuarios_idusuario = usuarios.idusuario
                            WHERE fecha_programada = '$inicio';
                        "; break;
                    }else{
                        $query = "
                        SELECT *,solicitudes.usuarios_idusuario AS idasesor,
                            clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat, 
                            usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                            FROM pagos
                            INNER JOIN creditos ON pagos.creditos_idcredito = creditos.idcredito
                            INNER JOIN solicitudes ON creditos.idcredito = solicitudes.creditos_idcredito
                            INNER JOIN clientes ON creditos.clientes_idcliente = clientes.idcliente
                            INNER JOIN usuarios ON solicitudes.usuarios_idusuario = usuarios.idusuario
                            WHERE fecha_programada = '$inicio' AND solicitudes.usuarios_idusuario = '$iduser';
                        "; break;
                    }
                    

    case 'editar': 
                $id = $_GET['id'];
                $query = "
                            SELECT * FROM cajas WHERE cajas.idcaja='$id';
                            "; break;
}


$result = $mysqli->query($query);


if(!$result){
    die("Query error " . mysqli_error($mysqli));
}

$json = array();

while($row = $result->fetch_array()){
    
    $json[] = array(
        'idpago' => $row['idpago'],
        'privilegios' => $privilegios,

        'cuota_programada' => $row['cuota_programada'],
        'mora' => $row['mora'],
        'monto' => $row['monto'],

        'cli_nombre' => $row['cli_nombre'],
        'cli_apellido_pat' => $row['cli_apellido_pat'],
        'cli_apellido_mat' => $row['cli_apellido_mat'],
        'usu_nombre' => $row['usu_nombre'],
        'usu_apellido_pat' => $row['usu_apellido_pat'],
        'usu_apellido_mat' => $row['usu_apellido_mat'],
    );
    
   
}

echo json_encode($json);



?>