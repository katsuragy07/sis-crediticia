<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['reportes'],1,1) == 0){
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
                    <h3><span class="badge badge-info" style="">CAPITAL DISPONIBLE</span></h3>
                </div>
            </div>
        </div>

    
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-10" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <label><span class="badge badge-primary" style="margin:10px; font-size:18px;">CAJA: </span></label>
                            <select class="form-control mr-sm-3" id="reportes_capital" name="reportes_capital" placeholder="Caja" required>
                                <option value="TODOS" selected disabled>--Todos--</option>
                            </select>
                            <button class="btn btn-success my-2 my-sm-0" type="button" onClick="reporte.listarCapital($('#reportes_capital').val());"><i class="fas fa-search"></i> Buscar</button>
                        </form>
                    </nav>
                </div>
                <div class="col-sm-2" style="padding:9px 16px;">
                    <button type="button" class="btn btn-block btn-success" style="float:right;" onclick="printDiv('print-flujo-caja')"><i class="fas fa-file-alt"></i> Imprimir</button>
                </div>
                <div class="w-100"></div>
                <div class="col-12" id="print-flujo-caja" style="background: rgba(255,255,255,0.7);margin-top:15px;margin-bottom:20px;">
                    <div class="row justify-content-center" id="load_data_reporte_cap" >
                        <br>
                        <div class="col-10" id="load_capital">
                            <br>
                            <center><h2 style="text-transform: uppercase;">REPORTE DE CAPITAL</h2></center>
                            <br>
                            
                        </div>
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