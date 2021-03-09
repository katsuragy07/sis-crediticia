<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['ahorros'],2,1) == 0){
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
                    <h3><span class="badge badge-info" style="margin-left:70px;">DEPOSITO A CUENTA</span></h3>
                </div>
            </div>
        </div>

    
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-9" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <select class="form-control mr-sm-2" id="cuenta_buscar_tipo">
                                <option value="NOMBRE" selected>NOMBRE</option>
                                <option value="DNI">DNI</option>
                            </select>
                            <input class="form-control mr-sm-2" id="cuenta_buscar" type="search" style="width:360px;" placeholder="Buscar cuenta por cliente" aria-label="Search" oninput="cuenta.buscar_cliente_deposito($(this).val());">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" onClick="cuenta.buscar_cliente_deposito($('#cuenta_buscar').val());"><i class="fas fa-search"></i> Buscar</button>
                        </form>
                    </nav>
                </div>
                <div class="col-sm-3" style="padding:9px 16px;">
                    <!--<button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add-usuarios" onclick='document.getElementById("formulario-usuarios").reset(); $("#modal-add-usuarios h4").html("Nuevo Usuario"); $("#usuarios-ajax-result").html(""); metodo=1;'>Añadir <i class="fas fa-plus"></i></button>-->
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Monto en Cuenta</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="load_data_cuenta">
                            
                        </tbody>
                    </table>

                    <div id="load_table_cuenta"></div>

                </div>
            </div>
        </div>

        
        <!-- MODAL ADD -->
        <!-- MODAL ADD -->
        <div class="modal fade bd-example-modal-sm" id="modal-add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">


                    <div class="container-fluid modal-body" style="padding:15px;">
                        <div class="row justify-content-center"> 
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add').modal('hide');"><i class="fas fa-lg fa-times"></i></button>
                                <form id="formulario-deposito_cc" class="formulario-modal" enctype="multipart/form-data">
                                    <h4 style="margin-bottom:18px;">COBRANZA</h4>
                                    <hr>                           
                                    <div class="row">
                                        <div class="col-md-4">  
                                            <div class="form-group row">
                                                <label for="inputCAJA" class="col-sm-3 col-form-label">*Cajero</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="inputCAJA" name="inputCAJA" placeholder="Nombre del encargado de caja" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" id="inputCAJA-hidden" name="inputCAJA-hidden">
                                                </div>
                                            </div> 
                                     
                                            <div class="form-group row">
                                                <label for="inputCLIENT" class="col-sm-3 col-form-label">*Cliente</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="inputCLIENT" name="inputCLIENT" placeholder="Nombre del Cliente" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" id="inputCLIENT-hidden" name="inputCLIENT-hidden">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="movimiento_caja" class="col-sm-3 col-form-label">Caja*</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control form-control-sm" id="movimiento_caja" name="movimiento_caja" placeholder="Caja" required>
                                                        <option value="" selected disabled>--Seleccionar--</option>
                                                    </select>
                                                </div>
                                            </div>

                                           
                                            <br>
                                            <span class="badge badge-info" style="font-size:1em;">Deposito</span>
                                            <hr style="margin-top: 6px;">


                        
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="cuenta_monto" class="col-sm-5 col-form-label">*Cuenta de ahorro</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control form-control-sm" id="cuenta_monto" name="cuenta_monto" placeholder="Monto actual" required readonly>
                                                </div>
                                            </div>
                                          

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="deposito_monto" class="col-sm-5 col-form-label"><span class="badge badge-pill badge-success" style="font-size:15px;padding:5px 22px;">*MONTO A <br>DEPOSITAR</span></label>
                                                <div class="col-sm-7">
                                                    <input type="number" step="any" class="form-control" id="deposito_monto" name="deposito_monto" placeholder="Monto a depositar" min="0" autocomplete="off" required>
                                                </div>
                                            </div>
                                          
                                           

                                        </div>

                                        <div class="col-md-8">
                                            <h5>MOVIMIENTOS</h5>
                                            <table class="table table-sm table-striped table-bordered" style="font-size:0.9em;">
                                                <thead class="thead-dark text-center">
                                                    <tr>
                                                    <th scope="col">N°</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Monto</th>
                                                    <th scope="col">Voucher</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="load_data_modal" class="text-center">
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td><td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div id="load_table_modal1"></div>
                                            
                                        </div>
                                    </div>

                                                                    
                                                                

                                    <div class="w-100" style="height:8px;"></div>
                                    <div id="msg-ajax-result">
                                        
                                    </div>

                                    
                                    <button type="submit" class="btn btn-success btn_modals"><i class="fas fa-lg fa-coins"></i> Depositar</button>
                                    <div class="modal-btn-cont">
                                        
                                    </div>
                                    <button type="button" class="btn btn-warning btn_modals" onclick="$('#modal-add').modal('hide');"><i class="fas fa-lg fa-ban"></i> Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <!-- MODAL TICKET -->
        <!-- MODAL TICKET -->
        <div class="modal fade bd-example-modal-sm" id="modal-ticket"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document" style="max-width:400px;">
                <div class="modal-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-danger" style="position:absolute;right:5px;top:3.5px;padding:3px 11px; z-index:1000;" onclick="$('#modal-ticket').modal('hide');"><i class="fas fa-lg fa-times"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" id="print-voucher">

                                <br>
                                <center><img src="../img/logoticket.jpg"></center>


                                <h5 style="margin:7px 4px; margin-top:18px; text-align:center; font-family:monospace; font-weight:bold;">VOUCHER DE PAGO</h5>
                                
                                <hr style="margin-top:5px; max-width:320px;">
                            
                                

                                

                                <table style="font-family:monospace; font-size:14px; margin:auto;" id="voucher-datos01">
                                    <tr>
                                        <td>FECHA:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>DIRECCION:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>CREDITO:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>FECHA:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>DNI:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>NOMBRES:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>APELLIDOS:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>DESEMBOLSO:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>MONTO:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>N° CUOTAS:</td>
                                        <td>:</td>
                                        <td>00000 00</td>
                                    </tr>
                                    <tr>
                                        <td>ASESOR:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                    <tr>
                                        <td>VENTANILLA:</td>
                                        <td>:</td>
                                        <td>0000000000</td>
                                    </tr>
                                </table>

                               
                                <hr style="max-width:280px;">

                                <p class="text-center" style="font-family:monospace; font-size:14px;">Recibí conforme</p>

                                <p class="text-center" style="font-family:monospace; margin-bottom:0px; font-size:14px;" id="voucher-datos02"></p>
                                <p class="text-center font-weight-bold" style="font-family:monospace; font-size:14px;">CLIENTE</p>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <center><button type="button" class="btn btn-primary" onclick="printDiv('print-voucher')"><i class="far fa-file-alt"></i> Imprimir</button></center>
                                <br>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </body>
</html>