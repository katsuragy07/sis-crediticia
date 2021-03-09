<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['cajas'],1,1) == 0){
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
                        <a onClick="window.location.href='../caja.php';" class="btn btn-secondary" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option2" autocomplete="off"><i class="fas fa-lg fa-arrow-alt-circle-left"></i>
                        </a>
                        <a onClick="window.location.href='../index.php';" class="btn btn-secondary active" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked><i class="fas fa-home"></i> Inicio
                        </a> 
                    </div>
                </div>
                <div class="col-8">
                    <h3><span class="badge badge-info" style="">APERTURA / CIERRE DE CAJA</span></h3>
                </div>
            </div>
        </div>

    
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-9" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <!--
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" type="search" placeholder="Buscar Caja" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                        </form>
                        -->
                    </nav>
                </div>
                <div class="col-sm-3" style="padding:9px 16px;">
                    
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark text-center">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Capital</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="load_data_aperturas">
                            
                        </tbody>
                    </table>

                    <div id="load_table_aperturas"></div>

                </div>
            </div>
        </div>

        
        
        <!-- MODAL ADD -->
        <!-- MODAL ADD -->
        <div class="modal fade bd-example-modal-sm" id="modal-add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="container-fluid" style="padding:15px;">
                        <div class="row"> 
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add').modal('hide');"><i class="fas fa-lg fa-times"></i></button>
                                <h4>Nueva Caja</h4>
                                <br>
                                <form id="formulario-apertura" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-sm-6">
                                            <label for="caja_nombre">Caja*</label>
                                            <input type="text" class="form-control" id="caja_nombre" name="caja_nombre" placeholder="Nombre de la Caja" required readonly>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="caja_resp">Responsable*</label>
                                            <input type="text" class="form-control" id="caja_resp" name="caja_resp" placeholder="Responsable de la Caja" required readonly>
                                            <input type="hidden" class="form-control" id="caja_resp-hidden" name="caja_resp-hidden" placeholder="ID responsable de la Caja" required readonly>
                                        </div>
                                        
                                        <div class="form-group col-sm-3">
                                            <label for="caja_fecha">Fecha*</label>
                                            <input type="date" class="form-control" id="caja_fecha" name="caja_fecha" placeholder="Monto de la caja" required readonly>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="caja_hora">Hora*</label>
                                            <input type="text" class="form-control" id="caja_hora" name="caja_hora" placeholder="Hora de la operación" required readonly>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="caja_capital" id="monto_tipo">Capital*</label>
                                            <input type="number" step="any" class="form-control" id="caja_capital" name="caja_capital" placeholder="Monto de la caja" required readonly>
                                        </div>

                                        <div class="w-100"><br></div>
                                        <span class="badge badge-secondary" style="font-size:1.15em;">Billetaje:</span>
                                        <span id="billet_calculado" class="badge badge-pill badge-primary" style="font-size:0.9em; margin-left:18px; margin-top:4px;">S/. </span>
                                        <span class="badge badge-pill" style="font-size:0.9em; margin-top:4px;"></span>
                                        <span id="billet_capital" class="badge badge-pill badge-success" style="font-size:0.9em; margin-left:2px; margin-top:4px;"></span>
                                        <div class="w-100"></div>
                                        
                                        <div class="col">
                                            <hr style="margin-top: 6px;">
                                        </div> 
                                        <div class="w-100"></div>


                                        <div class="form-group col-sm-4">
                                            <label for="caja_b_200"> Billetes S/. 200</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_200" name="caja_b_200"  oninput="caja.calcularBilletajeInput();">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="caja_b_100"> Billetes S/. 100</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_100" name="caja_b_100"  oninput="caja.calcularBilletajeInput();">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="caja_b_50"> Billetes S/. 50</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_50" name="caja_b_50"  oninput="caja.calcularBilletajeInput();">
                                        </div>  

                                        <div class="form-group col-sm-3">
                                            <label for="caja_b_20"> Billetes S/. 20</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_20" name="caja_b_20"  oninput="caja.calcularBilletajeInput();">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="caja_b_10"> Billetes S/. 10</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_10" name="caja_b_10"  oninput="caja.calcularBilletajeInput();">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="caja_b_5"> Monedas S/. 5</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_5" name="caja_b_5"  oninput="caja.calcularBilletajeInput();">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="caja_b_2"> Monedas S/. 2</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_2" name="caja_b_2"  oninput="caja.calcularBilletajeInput();">
                                        </div>

                                        <div class="form-group col-sm-3">
                                            <label for="caja_b_1"> Monedas S/. 1</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_1" name="caja_b_1"  oninput="caja.calcularBilletajeInput();">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="caja_b_0_5"> Monedas S/. 0.50</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_0_5" name="caja_b_0_5"  oninput="caja.calcularBilletajeInput();">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="caja_b_0_2"> Monedas S/. 0.20</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_0_2" name="caja_b_0_2"  oninput="caja.calcularBilletajeInput();">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="caja_b_0_1"> Monedas S/. 0.10</label>
                                            <input type="number" class="form-control form-control-sm caja_billetaje" id="caja_b_0_1" name="caja_b_0_1"  oninput="caja.calcularBilletajeInput();">
                                        </div>
                                       
                                      
                                      
                                        


                                    </div>

                                    <div class="w-100" style="height:8px;"></div>
                                    <div id="msg-ajax-result"></div>
                                    <div class="modal-btn-cont">
                                        
                                    </div>
                                    <button type="button" class="btn btn-warning btn-block btn_modals" onclick="$('#modal-add').modal('hide');"><i class="fas fa-lg fa-ban"></i> Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



    </body>
</html>