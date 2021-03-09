<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."intranet.php"); 
    }else{
        require_once("includes/rutas.php");
    }
    


?>

<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Rapidito tu solución financiera</title>
		<link rel="shortcut icon" href="img/logo.png">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-grid.css">
        <link rel="stylesheet" href="css/panel.css">
		<script src="js/jquery.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/panel.js"></script>
        <script src="js/font-awesome.js"></script>
	</head>
    <body>


        <?php
            require_once("includes/header.php");
        ?>
        <?php
            require_once("includes/menus.php");
        ?>


        <br>


        <div class="container-fluid">
            <div class="row justify-content-center">

                <?php
                    if($menu["usuarios"]){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-primary btn-lg menu_btn" href="usuarios.php" role="button"><i class="fas fa-2x fa-user-tie"></i><br>USUARIOS</a>
                            </div>
                        ';
                    }
                    if($menu["clientes"]){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-primary btn-lg menu_btn" href="clientes.php" role="button"><i class="fas fa-2x fa-users"></i><br>CLIENTES</a>
                            </div>
                        ';
                    }
                    if($menu["creditos"]){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-primary btn-lg menu_btn" href="creditos.php" role="button"><i class="fas fa-2x fa-hand-holding-usd"></i><br>CREDITOS</a>
                            </div>
                        ';
                    }
                    if($menu["ahorros"]){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-primary btn-lg menu_btn" href="ahorros.php" role="button"><i class="fas fa-2x fa-piggy-bank"></i><br>AHORROS</a>
                            </div>
                        ';
                    }
                    if($menu["cajas"]){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-primary btn-lg menu_btn" href="caja.php" role="button"><i class="fas fa-2x fa-coins"></i><br>FINANZAS</a>
                            </div>
                        ';
                    }
                    if($menu["configuraciones"]){
                        /*
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-primary btn-lg menu_btn" href="configuraciones.php" role="button"><i class="fas fa-2x fa-cogs"></i><br>CONFIGURACIONES</a>
                            </div>
                        ';
                        */
                    }
                    if($menu["reportes"]){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-primary btn-lg menu_btn" href="reportes.php" role="button"><i class="fas fa-2x fa-clipboard"></i><br>REPORTES</a>
                            </div>
                        ';
                    }
                ?>
                
                
                
                
                <!--
                <div class="col mt-5">
                    <a class="btn btn-primary btn-lg menu_btn" href="reportes.php" role="button"><i class="far fa-2x fa-clipboard"></i><br>REPORTES</a>
                </div>
                -->
                

            </div>
        </div>


    </body>
</html>