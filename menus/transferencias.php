<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['cajas'],3,1) == 0){
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
                    <h3><span class="badge badge-info" style="">TRANSFERENCIAS DE CAJA</span></h3>
                </div>
            </div>
        </div>

    
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-9" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" id="transferencias_buscar" type="date" style="width:360px;" placeholder="Buscar transferencias de caja" aria-label="Search" oninput="caja.listarTransferencias($(this).val());">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" onClick="caja.listarTransferencias($('#transferencias_buscar').val());"><i class="fas fa-search"></i> Buscar</button>
                        </form>
                    </nav>
                </div>
                <div class="col-sm-3" style="padding:9px 16px;">
                    <button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add" onclick='btn_add_transferencias();'>Añadir <i class="fas fa-plus"></i></button>
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark text-center">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Caja Origen</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Caja Destino</th>
                            <th scope="col">Concepto</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Voucher</th>
                            </tr>
                        </thead>
                        <tbody id="load_data_transferencias">
                            
                        </tbody>
                    </table>

                    <div id="load_table_transferencias"></div>

                </div>
            </div>
        </div>

        

        <!-- MODAL ADD -->
        <!-- MODAL ADD -->
        <div class="modal fade bd-example-modal-sm" id="modal-add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="container-fluid" style="padding:15px;">
                        <div class="row"> 
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add').modal('hide');"><i class="fas fa-lg fa-times"></i></button>
                                <h4>Nueva Transferencia</h4>
                                <br>
                                <form id="formulario-transferencias" enctype="multipart/form-data">
                                    <div class="form-row">
                                       
                                        <div class="form-group col-sm-6">
                                            <label for="movimiento_caja_ori"><span class="badge badge-primary">Caja Origen*</span></label>
                                            <select class="form-control" id="movimiento_caja_ori" name="movimiento_caja_ori" placeholder="Caja" required>
                                                <option value="" selected disabled>--Seleccionar--</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="movimiento_caja_des"><span class="badge badge-danger">Caja Destino*</span></label>
                                            <select class="form-control" id="movimiento_caja_des" name="movimiento_caja_des" placeholder="Caja" required>
                                                <option value="" selected disabled>--Seleccionar--</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="movimiento_monto">Monto*</label>
                                            <input type="number" step="0.01" class="form-control" id="movimiento_monto" name="movimiento_monto" placeholder="Monto del movimiento" required>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="movimiento_concepto">Concepto*</label>
                                            <input type="text" class="form-control" id="movimiento_concepto" name="movimiento_concepto" placeholder="Concepto del movimiento" required>
                                        </div>
                                        
                                        <!--
                                        <div class="form-group col-sm-12">
                                            <label for="movimiento_autoriza">Autorización</label>
                                            <input type="text" class="form-control" id="movimiento_autoriza" name="movimiento_autoriza" placeholder="Quien autoriza">
                                        </div>
                                        -->
                                        
                                        <div class="form-group col-sm-12">
                                            <label for="movimiento_autoriza">Autorización de*</label>
                                            <input list="admins-list" type="text" class="form-control" id="movimiento_autoriza" name="movimiento_autoriza" placeholder="Nombre del que autoriza" autocomplete="off" onKeyUp="caja.buscarUserTransferencias(this.value);" required>
                                            <input type="hidden" class="form-control" id="movimiento_autoriza-hidden" name="movimiento_autoriza-hidden">
                                            <datalist id="admins-list">
                                                        
                                            </datalist>
                                        </div>        

                                        <div class="form-group col-sm-6">
                                            <label for="caja_fecha">Fecha*</label>
                                            <input type="date" class="form-control" id="caja_fecha" name="caja_fecha" required readonly>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="caja_hora">Hora*</label>
                                            <input type="text" class="form-control" id="caja_hora" name="caja_hora" placeholder="Hora de la operación" required readonly>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="caja_resp">Responsable*</label>
                                            <input type="text" class="form-control" id="caja_resp" name="caja_resp" placeholder="Responsable de la Caja" required readonly>
                                            <input type="hidden" class="form-control" id="caja_resp-hidden" name="caja_resp-hidden" placeholder="ID responsable de la Caja" required readonly>
                                        </div>
                                    </div>

                                    <div class="w-100" style="height:8px;"></div>
                                    <div id="msg-ajax-result"></div>

                                    <button type="submit" class="btn btn-success btn_modals"><i class="far fa-lg fa-save"></i> Registrar</button>
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


                                <h5 style="margin:7px 4px; margin-top:18px; text-align:center; font-family:monospace; font-weight:bold;" id="voucher-titulo">VOUCHER</h5>
                                
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

                                <p class="text-center" style="font-family:monospace; font-size:14px;">Operación Completa</p>

                                <p class="text-center" style="font-family:monospace; margin-bottom:0px; font-size:14px;" id="voucher-datos02"></p>
                                <p class="text-center font-weight-bold" style="font-family:monospace; font-size:14px;">TRANSFERENCIA</p>

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