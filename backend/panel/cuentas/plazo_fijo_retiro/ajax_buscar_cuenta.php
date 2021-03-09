<?php

    require_once "../../../connect.php";

    $clave = $_GET['clave'];
    $tipo = $_GET['tipo'];

    if($tipo=="DNI"){
        $query = "
                    SELECT idcuenta, idusuario, idcliente, monto_inicio, monto_fin, fecha_inicio, fecha_fin, interes, estado,
                        clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat,
                        usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                        FROM cuenta_pf
                        INNER JOIN clientes ON clientes.idcliente = cuenta_pf.clientes_idcliente
                        INNER JOIN usuarios ON usuarios.idusuario = cuenta_pf.usuarios_idusuario 
                        WHERE clientes.dni LIKE '$clave%' ORDER BY idcuenta DESC;
        ";
    }else{
        $query = "
                    SELECT idcuenta, idusuario, idcliente, monto_inicio, monto_fin, fecha_inicio, fecha_fin, interes, estado,
                        clientes.nombre AS cli_nombre, clientes.apellido_pat AS cli_apellido_pat, clientes.apellido_mat AS cli_apellido_mat,
                        usuarios.nombre AS usu_nombre, usuarios.apellido_pat AS usu_apellido_pat, usuarios.apellido_mat AS usu_apellido_mat
                        FROM cuenta_pf
                        INNER JOIN clientes ON clientes.idcliente = cuenta_pf.clientes_idcliente
                        INNER JOIN usuarios ON usuarios.idusuario = cuenta_pf.usuarios_idusuario 
                        WHERE concat(clientes.nombre,' ',clientes.apellido_pat,' ',clientes.apellido_mat) LIKE '%$clave%' ORDER BY idcuenta DESC;
        ";
    }
    

    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'id' => $row['idcuenta'],
            'monto_inicio' => $row['monto_inicio'],
            'monto_fin' => $row['monto_fin'],
            'fecha_inicio' => date("d-m-Y",strtotime($row['fecha_inicio'])),
            'fecha_fin' => date("d-m-Y",strtotime($row['fecha_fin'])),
            'interes' => $row['interes'],
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