<?php

require_once "connect.php";

$user = $_POST['user_name'];
$pass = $_POST['user_password'];

$query = "SELECT * FROM usuarios WHERE usuario = '$user' AND habilitado = 'SI';";


$result = $mysqli->query($query);


if(!$result){
    die("El usuario no existe, Query error " . mysqli_error($mysqli));
}


while($row = $result->fetch_array()){
    if($row['pass']==$pass){
        //echo "usuario correcto";
        if($row['telefono']=='963852741'){
            header('Location: '."../index.php");
            die();
        }
        session_start();
        $_SESSION['id'] = $row['idusuario'];
        $_SESSION['user'] = $row['nombre'];
        $_SESSION['privilegios'] = $row['privilegios'];
        $_SESSION['foto'] = $row['url_foto'];
        mysqli_close($mysqli);
        header('Location: '."../index.php"); 
        die();
    }else{
        //echo 'contraseña incorrecta';
        mysqli_close($mysqli);
        header('Location: '."../intranet.php?pass=incorrect"); 
        die();
    }
}



//echo 'El usuario no existe';
header('Location: '."../intranet.php?user=incorrect"); 
mysqli_close($mysqli);


?>