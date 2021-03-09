<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."intranet.php"); 
    }else{
        require_once("includes/rutas.php");
    }
    
    if(!$menu['reportes']){
        header('Location: '."index.php"); 
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
            <div class="row">
                <div class="col">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <a onClick="window.location.href='index.php';" class="btn btn-secondary" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option2" autocomplete="off"><i class="fas fa-lg fa-arrow-alt-circle-left"></i>
                        </a>
                        <a onClick="window.location.href='index.php';" class="btn btn-secondary active" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked><i class="fas fa-home"></i> Inicio
                        </a> 
                    </div>
                </div>
                <div class="col-8">
                    <h3 style="margin-left:-1px;"><span class="badge badge-info" style="margin-left:120px;">REPORTES</span></h3>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row justify-content-center">
                <?php
                   
                    if(substr($accesos['reportes'],0,1)){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-primary btn-lg menu_btn" href="menus/reporte_flujo.php" role="button"><i class="fas fa-2x fa-money-bill-wave"></i><br>FLUJO DE CAJA</a>
                            </div>
                        ';
                    }
                    if(substr($accesos['reportes'],1,1)){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-success btn-lg menu_btn" href="menus/reporte_capital.php" role="button"><i class="fas fa-2x fa-coins"></i><br>CAPITAL</a>
                            </div>
                        ';
                    }
                    if(substr($accesos['reportes'],2,1)){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-danger btn-lg menu_btn" href="menus/reporte_moras.php" role="button"><i class="fas fa-2x fa-chart-pie"></i><br>MORAS</a>
                            </div>
                        ';   
                    }
                    if(substr($accesos['reportes'],3,1)){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-info btn-lg menu_btn" href="menus/reporte_movimientos.php" role="button"><i class="fas fa-2x fa-money-bill-wave"></i><br>MOVIMIENTOS</a>
                            </div>
                        ';
                    }
                    if(substr($accesos['reportes'],4,1)){
                        echo '
                            <div class="col mt-5">
                                <a class="btn btn-secondary btn-lg menu_btn" href="menus/reporte_paga.php" role="button"><i class="fas fa-2x fa-money-bill-wave"></i><br>PAGA</a>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>


    </body>
</html>