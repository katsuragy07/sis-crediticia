<?php

    require_once "../../connect.php";

    $clave = $_GET['clave'];
    $tipo = $_GET['tipo'];

    if($tipo=="DNI"){
        $query = "SELECT * FROM usuarios WHERE doc_nro LIKE '$clave%';";
    }else{
        $query = "SELECT * FROM usuarios WHERE concat(nombre,' ',apellido_pat,' ',apellido_mat) LIKE '%$clave%';";
    }
    

    $result = $mysqli->query($query);


    if(!$result){
        die("Query error " . mysqli_error($mysqli));
    }


    $json = array();
    while($row = $result->fetch_array()){
    
        $json[] = array(
            'id' => $row['idusuario'],
            'privilegios' => $row['privilegios'],
            'apellido_pat' => $row['apellido_pat'],
            'apellido_mat' => $row['apellido_mat'],
            'nombre' => $row['nombre'],
            'doc_nro' => $row['doc_nro'],
            'usuario' => $row['usuario'],
            'pass' => $row['pass'],
            'nacimiento' => $row['nacimiento'],
            'grado' => $row['grado'],
            'estado_civil' => $row['estado_civil'],
            'lugar_nacimiento' => $row['lugar_nacimiento'],
            'comentarios' => $row['comentarios'],
            'telefono' => $row['telefono'],
            'direccion' => $row['direccion'],
            'referencia' => $row['referencia'],
            'distrito' => $row['distrito'],
            'provincia' => $row['provincia'],
            'correo' => $row['correo'],
            'url_foto' => $row['url_foto'],
            'habilitado' => $row['habilitado']
        );
        
       
    }
    
    echo json_encode($json);





?>