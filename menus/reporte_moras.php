<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['reportes'],2,1) == 0){
        header('Location: '."../index.php"); 
    }
?>

<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Rapidito tu solución financiera</title>
		<link rel="shortcut icon" href="../img/logo.png">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/bootstrap-grid.css">
        <link rel="stylesheet" href="../css/panel.css">
		<script src="../js/jquery.js"></script>
        <script src="../js/popper.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="../js/panel.js"></script>
        <script src="../js/font-awesome.js"></script>
	</head>
    <body>


        <?php
            require_once("../includes/header-sub.php");
        ?>
        <?php
            require_once("../includes/menus-sub.php");
        ?>


        <br>


        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <a onClick="window.location.href='../reportes.php';" class="btn btn-secondary" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option2" autocomplete="off"><i class="fas fa-lg fa-arrow-alt-circle-left"></i>
                        </a>
                        <a onClick="window.location.href='../index.php';" class="btn btn-secondary active" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked><i class="fas fa-home"></i> Inicio
                        </a> 
                    </div>
                </div>
                <div class="col-8">
                    <h3><span class="badge badge-info" style="">REPORTE DE MORAS</span></h3>
                </div>
            </div>
        </div>

    
        <div class="container-fluid">
            <div class="row justify-content-end" style="padding:15px;">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-10" style="padding:4px 0px;">
                            <nav class="navbar navbar-light">
                                <form class="form-inline">
                                    <select class="form-control mr-sm-2" id="mora_buscar_tipo">
                                        <option value="CLIENTE" selected>CLIENTES</option>
                                        <option value="ASESOR">ASESOR</option>
                                    </select>
                                    <input class="form-control mr-sm-2" id="reporte_mora" type="text" style="width:360px;" placeholder="Buscar mora por cliente/asesor" aria-label="Search" oninput="reporte.listarMoras($(this).val());">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="button" onClick="reporte.listarMoras($('#reporte_mora').val());"><i class="fas fa-search"></i> Buscar</button>
                                </form>
                            </nav>
                        </div>
                        <div class="col-sm-2" style="padding:9px 16px;">
                            <button type="button" class="btn btn-block btn-success" style="float:right;" onclick="printDivH('print-reporte-mora')"><i class="fas fa-file-alt"></i> Imprimir</button>
                        </div>
                    </div>
                </div>
                <div class="w-100"></div>
                <div class="col-12" id="print-reporte-mora" style="background: rgba(255,255,255,0.7);margin-top:15px;margin-bottom:20px;">
                    <div class="row justify-content-center" id="load_data_reporte_mora" >
                        <br>
                        <div class="col-12" style="padding:3px 20px;">
                            <br>
                            <center><h2>INFORME DE MOROSIDAD</h2></center>
                            <br>
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark text-center">
                                        <th scope="col">SOCIO N°</th>
                                        <th scope="col">N°</th>
                                        <th scope="col">PRESTAMISTA</th>
                                        <th scope="col">ASESOR</th>
                                        <th scope="col">F. DESEMBOLSO</th>
                                        <!--<th scope="col">F. DE CANCELACIÓN</th>-->
                                        <th scope="col">PRESTAMO</th>
                                        <th scope="col">%</th>
                                        <th scope="col">PERIODO</th>
                                        <th scope="col">C + I</th>
                                        <th scope="col">RECAUDADO</th>
                                        <th scope="col">RESTANTE</th>
                                        <th scope="col">HASTA EL DÍA</th>
                                        <th scope="col">DIAS DE ATRASO</th>
                                        <th scope="col">DEUDA RESTANTE + MORA</th>
                                </thead>
                                <tbody id="load_moras">
                                    
                                </tbody>
                            </table>
                        </div>
                
                    </div>
                    <div id="loader_reporte"></div>
                </div>








                <div class="w-100"></div>




            </div>
        </div>

     


    </body>
</html>