<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['reportes'],0,1) == 0){
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
                    <h3><span class="badge badge-info" style="">FLUJOS DE CAJA</span></h3>
                </div>
            </div>
        </div>

    
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-10" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" id="reporte_fecha" type="date" style="width:360px;" placeholder="Flujo de caja por fecha" aria-label="Search" oninput="reporte.listarFlujo($(this).val(),$('#reportes_cajas').val());">
                            <select class="form-control mr-sm-2" id="reportes_cajas" name="reportes_cajas" placeholder="Caja" required>
                                <option value="" selected disabled>--Seleccionar--</option>
                            </select>
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" onClick="reporte.listarFlujo($('#reporte_fecha').val(),$('#reportes_cajas').val());"><i class="fas fa-search"></i> Buscar</button>
                        </form>
                    </nav>
                </div>
                <div class="col-sm-2" style="padding:9px 16px;">
                    <button type="button" class="btn btn-block btn-success" style="float:right;" onclick="printDiv('print-flujo-caja')"><i class="fas fa-file-alt"></i> Imprimir</button>
                </div>
                <div class="w-100"></div>
                <div class="col-12" id="print-flujo-caja" style="background: rgba(255,255,255,0.7);margin-top:15px;margin-bottom:20px;">
                    <div class="row justify-content-center" id="load_data_reporte" >
                        <br>
                        <div class="col-11" id="load_ingreso">
                            <br>
                            <center><h2>FECHA DEL REPORTE</h2></center>
                            <br>
                            <h5>COBRO DE CUOTAS</h5>
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark text-center table_titulo">
                                    <th scope="col" colspan="6"><h5>COBRO DE CUOTAS</h5></th>
                                </thead>
                                <thead class="thead-dark">
                                        <th scope="col">COD</th>
                                        <th scope="col">CLIENTE</th>
                                        <th scope="col">ASESOR</th>
                                        <th scope="col">DETALLE</th>
                                        <th scope="col">MODO</th>
                                        <th scope="col">MONTO</th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-11" id="load_egreso"></div>
                        <div class="col-11" id="load_ingreso_otros"></div>
                        <div class="col-11" id="load_egreso_otros"></div>
                        <div class="col-8" id="load_billetaje"></div>
                        <div class="col-7" id="load_detalles"></div>
                        <div class="col-6" id="load_cierre"></div>
                        <div class="col-8" id="load_hora"></div>
                    </div>
                    <div id="loader_reporte"></div>
                </div>








                <div class="w-100"></div>



                <div class="col" id="print-flujo-caja" style="display:none;">
                    <div style="padding:15px;">
                        <center><img src="../img/logoticket.jpg"></center>
                        <center><h5 style="margin-top:30px; font-size:1.5em;" class="cotizacion-letra">REPORTE DE FLUJO DE CAJA</h5></center>
                        <h4 id="reporte_fechas" style="margin-top:24px; font-size:1.2em;" class="cotizacion-letra"></h4>
                        

                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Caja</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Concepto</th>
                                <th scope="col">Detalle de movimiento</th>
                                <th scope="col">Fecha</th>
                        
                                </tr>
                            </thead>
                            <tbody id="load_data_flujo2">
                                
                            </tbody>
                        </table>
                        <div id="load_table_flujo"></div>
                    </div>
                </div>



            </div>
        </div>

     


    </body>
</html>