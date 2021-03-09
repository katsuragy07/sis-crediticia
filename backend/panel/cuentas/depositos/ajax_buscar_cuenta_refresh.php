<?php

    require_once "../../../connect.php";

    $id = $_GET['clave'];


    $query = "
                SELECT idcuenta, idusuario, idcliente, monto, fecha_apertura, estado,
                        clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat,
                        usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                        FROM cuenta_corriente
                        INNER JOIN clientes ON clientes.idcliente = cuenta_corriente.clientes_idcliente
                        INNER JOIN usuarios ON usuarios.idusuario = cuenta_corriente.usuarios_idusuario
                        WHERE idcuenta = '$id';
            ";

    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'id' => $row['idcuenta'],
            'monto' => $row['monto'],
            'fecha' => $row['fecha_apertura'],
            'estado' => $row['estado'],

            'cli_nombre' => $row['cli_nombre'],
            'cli_apellido_pat' => $row['cli_apellido_pat'],
            'cli_apellido_mat' => $row['cli_apellido_mat'],
            'usu_nombre' => $row['usu_nombre'],
            'usu_apellido_pat' => $row['usu_apellido_pat'],
            'usu_apellido_mat' => $row['usu_apellido_mat']
        );
        
       
    }
    
    echo json_encode($json);





?>