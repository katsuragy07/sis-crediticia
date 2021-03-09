<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['cajas'],4,1) == 0){
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


        <br>

        <div class="container">
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
                    <h3><span class="badge badge-info">DESEMBOLSOS DE CRÉDITO</span></h3>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row justify-content-end">
                <div class="col-12" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <select class="form-control mr-sm-2" id="desembolsos_buscar_tipo">
                                <option value="NOMBRE" selected>NOMBRE</option>
                                <option value="DNI">DNI</option>
                            </select>
                            <input class="form-control mr-sm-2" id="desembolsos_buscar" type="search" style="width:360px;" placeholder="Buscar desembolsos de credito por cliente" aria-label="Search" oninput="credito.buscar_desembolso($(this).val());">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" onClick="credito.buscar_desembolso($('#desembolsos_buscar').val());"><i class="fas fa-search"></i> Buscar</button>
                        </form>
                    </nav>
                </div>
                <!--
                <div class="col-sm-3" style="padding:9px 16px;">
                    <button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add" onclick='document.getElementById("formulario-principal").reset(); $("#modal-add h4").html("Nueva Solicitud de Crédito"); $("#form-ajax-result").html(""); metodo=1;'>Añadir <i class="fas fa-plus"></i></button>
                </div>
                -->
                <div class="w-100"></div>
                <div class="col">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Asesor</th>
                            <th scope="col">Monto</th>
                        
                            <th scope="col">Estado</th>
                            <th scope="col">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="load_data_desembolsos">
                            
                        </tbody>
                    </table>

                    <div id="load_table_desembolsos"></div>

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
                                <form id="formulario-desembolso" class="formulario-modal" enctype="multipart/form-data">
                                    <h4 style="margin-bottom:18px;">DESEMBOLSO DE CRÉDITOS</h4>
                                    <hr>                           
                                    <div class="row">
                                        <div class="col-md-5">  
                                            <div class="form-group row">
                                                <label for="inputCAJA" class="col-sm-3 col-form-label">*Cajero</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="inputCAJA" name="inputCAJA" placeholder="Nombre del encargado de caja" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" id="inputCAJA-hidden" name="inputCAJA-hidden">
                                                </div>
                                            </div> 
                                            <div class="form-group row">
                                                <label for="inputADMIN" class="col-sm-3 col-form-label">*Administrador</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="inputADMIN" name="inputADMIN" placeholder="Nombre del Administrador" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" id="inputADMIN-hidden" name="inputADMIN-hidden">
                                                </div>
                                            </div>            
                                            <div class="form-group row">
                                                <label for="inputASES" class="col-sm-3 col-form-label">*Asesor</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="inputASES" name="inputASES" placeholder="Nombre del Asesor" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" id="inputASES-hidden" name="inputASES-hidden">
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
                                                <label for="movimiento_caja" class="col-sm-3 col-form-label">*Caja</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="movimiento_caja" name="movimiento_caja" placeholder="Caja" required>
                                                        <option value="" selected disabled>--Seleccionar--</option>
                                                    </select>
                                                </div> 
                                            </div>

                                            <!--
                                            <div class="form-group row">
                                                <label for="inputREFER" class="col-sm-3 col-form-label">*Participar con</label>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="SI" id="inputCONY" name="inputCONY" readonly onclick="return false;">
                                                        <label class="form-check-label" for="inputCONY">
                                                            Conyugue
                                                        </label>
                                                    </div>
                                                    <div class="w-100" style="height:7px;"></div>
                                                    <input type="text" class="form-control form-control-sm" id="inputCONY_AJAX" name="inputCONY_AJAX" placeholder="Conyugue" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" id="inputCONY_AJAX-hidden" name="inputCONY_AJAX-hidden">
                                                   
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="SI" id="inputAVAL" name="inputAVAL" readonly onclick="return false;">
                                                        <label class="form-check-label" for="inputCONY">
                                                            Aval
                                                        </label>
                                                    </div>
                                                    <div class="w-100" style="height:7px;"></div>
                                                    <input type="text" class="form-control form-control-sm" id="inputAVAL_AJAX" name="inputAVAL_AJAX" placeholder="Aval" readonly>
                                                    <input type="hidden" class="form-control form-control-sm" id="inputAVAL_AJAX-hidden" name="inputAVAL_AJAX-hidden">
                                                </div>
                                            </div>
                                            -->
                                            <br>
                                            <span class="badge badge-info" style="font-size:1em;">Credito</span>
                                            <hr style="margin-top: 6px;">

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_MONTO" class="col-sm-4 col-form-label">*Monto</label>
                                                <div class="col-sm-8">
                                                    <input type="number" step="any" class="form-control form-control-sm" id="sol_MONTO" name="sol_MONTO" placeholder="Monto del crédito" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_CUOTAS" class="col-sm-4 col-form-label">*Número de cuotas</label>
                                                <div class="col-sm-8">
                                                    <input type="number" step="any" class="form-control form-control-sm" id="sol_CUOTAS" name="sol_CUOTAS" placeholder="Número de cuotas" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_FRECUENCIA" class="col-sm-4 col-form-label">Frecuencia de pago</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="sol_FRECUENCIA" name="sol_FRECUENCIA" placeholder="Frecuencia de pago" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_INTERES" class="col-sm-4 col-form-label">*Tasa de Interés %</label>
                                                <div class="col-sm-8">
                                                    <input type="number" step="any" class="form-control form-control-sm" id="sol_INTERES" name="sol_INTERES" placeholder="% de taza interés" required oninput="solicitud_interes=$(this).val(); solicitud_calendario();" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_INICIO" class="col-sm-4 col-form-label">*Fecha de inicio</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control form-control-sm" id="sol_INICIO" name="sol_INICIO" placeholder="Fecha del primer pago" required oninput="solicitud_inicio=$(this).val(); solicitud_calendario();" readonly>
                                                </div>
                                            </div>

                                            <div class="w-100" style="height:20px;"></div>

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_CUOTAS" class="col-sm-4 col-form-label">Monto de las cuotas</label>
                                                <div class="col-sm-8">
                                                    <input type="number" step="any" class="form-control form-control-sm" id="sol_cal_CUOTAS" name="sol_cal_CUOTAS" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_INTERES" class="col-sm-4 col-form-label">Monto del interés</label>
                                                <div class="col-sm-8">
                                                    <input type="number" step="any" class="form-control form-control-sm" id="sol_cal_INTERES" name="sol_cal_INTERES" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_TOTAL" class="col-sm-4 col-form-label">Monto + Interés</label>
                                                <div class="col-sm-8">
                                                    <input type="number" step="any"class="form-control form-control-sm" id="sol_cal_TOTAL" name="sol_cal_TOTAL" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
 
                                        <div class="col-md-7">
                                            <table class="table table-sm table-striped table-bordered" style="font-size:0.9em;">
                                                <thead class="thead-dark">
                                                    <tr>
                                                    <th scope="col">N°</th>
                                                    <th scope="col">Fecha Programada</th>
                                                    <th scope="col">Cuota de pago</th>
                                                    <th scope="col">Deuda por pagar</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="load_data_modal">
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"></th><td></td><td></td><td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                                                    
                                                                

                                    <div class="w-100" style="height:8px;"></div>
                                    <div id="msg-ajax-result">
                                        
                                    </div>

                                    
                                    
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


                                <h5 style="margin:7px 4px; margin-top:18px; text-align:center; font-family:monospace; font-weight:bold;">VOUCHER DE DESEMBOLSO</h5>
                                
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


        <!-- MODAL CRONOGRAMA -->
        <!-- MODAL CRONOGRAMA -->
        <div class="modal fade bd-example-modal-sm" id="modal-cronograma"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:840px;" role="document">
                <div class="modal-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-danger" style="position:relative;float:right;padding:3px 11px;margin-top:5px;" onclick="$('#modal-cronograma').modal('hide');"><i class="fas fa-lg fa-times"></i></button>    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <hr style="margin-top:5px; margin-bottom:3px;">
                            </div>
                            <div class="col-12" id="print-cronograma" style="font-size:1em;">
                                <br>
                              
                                <div class="row">
                                    <div class="col-4">
                                        <img src="../img/logoticket.jpg">
                                    </div>
                                    <div class="col-5">
                                        <h4 style="margin-top:20px;">CALENDARIO DE PAGOS</h4>
                                    </div>
                                    <div class="col-3">
                                        <table style="font-family:arial; font-size:18px;" id="cronograma-datos01">
                                            <tr>
                                                <td> COD. CLIENTE</td>
                                                <td>:</td>
                                                <td>456</td>
                                            </tr>
                                            <tr>
                                                <td>N° CREDITO</td>
                                                <td>:</td>
                                                <td>235</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>


                                <div class="row">  
                                    <div class="col-12">
                                        <div style="display:block;position:relative;padding:25px 20px;">
                                            <table class="cronograma-letra" style="font-family:arial;float:left; width:68%;" id="cronograma-datos02"> 
                                                
                                                    <tr>
                                                        <th>CLIENTE</th>
                                                        <th class="font-weight-normal pl-2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th>FECHA DE DESEMBOLSO</th>
                                                        <th class="font-weight-normal pl-2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th>DIRECCION</th>
                                                        <th class="font-weight-normal pl-2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th>N° CEL CLIENTE</th>
                                                        <th class="font-weight-normal pl-2"></th>
                                                    </tr>
                                                
                                            </table>
                                            <table class="cronograma-letra" style="font-family:arial; float:right;margin-left:8px; width:30%;" id="cronograma-datos03">
                                            
                                                    <tr>
                                                        <th>MONTO</th>
                                                        <th class="font-weight-normal pl-2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th>INTERÉS</th>
                                                        <th class="font-weight-normal pl-2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th>PLAZO</th>
                                                        <th class="font-weight-normal pl-2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th>INSCRIPCIÓN</th>
                                                        <th class="font-weight-normal pl-2"></th>
                                                    </tr>
                                             
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                

                                <br>
                                

                                <div class="row" style="">
                                    <div class="col-12">
                                        <table class="table table-sm table-striped table-bordered text-center cronograma-letra">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col" style="width:110px">N°</th>
                                                    <th scope="col" style="width:110px">FECHA PROG.</th>
                                                    <th scope="col" style="width:110px">CUOTA</th>
                                                    <th scope="col" style="width:110px">MORA</th>
                                                    <th scope="col" style="width:140px">FECHA DE PAGO</th>
                                                    <th scope="col" style="width:150px">MONTO PAGADO</th>
                                                    <th scope="col">FIRMA</th>
                                                </tr>
                                            </thead>
                                            <tbody id="load_data_modal-cronograma">
                                                            <tr>
                                                                <th scope="row"></th>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"></th><td></td><td></td><td></td><td></td><td></td><td></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"></th><td></td><td></td><td></td><td></td><td></td><td></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"></th><td></td><td></td><td></td><td></td><td></td><td></td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"></th><td></td><td></td><td></td><td></td><td></td><td></td>
                                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                               
                                <br>


                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center cronograma-letra">
                                            SU PUNTUALIDAD ES SU MEJOR GARANTIA PARA SU PROXIMO PRESTAMO<br>
                                            RECUERDE: Que por cada dia de retraso en su credito su mora sera de S/1.00 SOL
                                        </p>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-5">
                                        <table class="cronograma-letra" style="font-family:arial;" id="cronograma-datos04">
                                           
                                                <tr>
                                                    <th>ANALISTA</th>
                                                    <th class="font-weight-normal pl-2 cronograma-letra">as dsd asd aded de dde asd</th>
                                                </tr>
                                                <tr>
                                                    <th>TELÉFONO</th>
                                                    <th class="font-weight-normal pl-2">sfsf 8446545648<br>fwef 4564654654</th>
                                                </tr>
                                            
                                        </table>
                                    </div>
                                    <div class="col-3">
                                        <img src="../img/logoticket.jpg" style="width:100%;">
                                    </div>
                                </div>
                                <div class="row cronograma-letra"style="margin-top:10px;">
                                    <div class="col-12">
                                        <p class="text-center">UBICANOS: JR. Parra de Riego N° 585 - EL TAMBO HUANCAYO</p>
                                    </div>
                                </div>
                                           
                            </div>
                            <div class="col-12">
                                <hr>
                                <center><button type="button" class="btn btn-primary" onclick="printDiv('print-cronograma')"><i class="far fa-file-alt"></i> Imprimir</button></center>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- MODAL CONTRATO -->
        <!-- MODAL CONTRATO -->
        <div class="modal fade bd-example-modal-sm" id="modal-contrato"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" style="max-width:900px;" role="document">
                <div class="modal-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-danger" style="position:relative;float:right;padding:3px 11px;margin-top:5px;" onclick="$('#modal-contrato').modal('hide');"><i class="fas fa-lg fa-times"></i></button>    
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-12">
                                <hr style="margin-top:5px; margin-bottom:3px;">
                            </div>


                            <div class="col-12" id="print-contrato">
                                <br>
                                <div class="row" id="contrato-datos01" style="font-size:14px;">
                                    <div class="col-12">
                                        <center><h4><ins>CONTRATO DE PRÉSTAMO DINERARIO</ins></h4></center>
                                        <br>
                                        <p class="text-justify">
                                            CONSTE POR EL PRESENTE DOCUMENTO, EN CONTRATO DE PRÉSTAMO DINERARIO QUE CELEBRAN DE UNA PARTE <b>ANDY PERALTA RIVEROS, CON DNI N°47726338</b> CON DOMICILIO EN EL JR. PARRA DEL RIEGO N° 585 - DISTRITO DE EL TAMBO, PROVINCIA DE HUANCAYO, DEPARTAMENTO DE JUNÍN, QUIEN PROCEDE EN CALIDAD DE PRESIDENTE DE LA ASOCIACIÓN "ACIR", EN ADELANTE DENOMINADO "EL ACREEDOR" Y DE LA OTRA PARTE <b>-----</b>; CON DOMICILIO -------, DISTRITO --------, PROVINCIA DE --------, DENOMINADO EN ADELANTE "EL DEUDOR" EN LOS TERMINOS Y CONDICIONES SIGUIENTES: 
                                        </p>
                                        <h5>1.- ANTECEDENTE Y OBJETO.-</h5>
                                        <p class="text-justify">EL ACREEDOR, ES UNA PERSONA JURÍDICA A PRESTAR SERVICIOS RELACIONADOS CON LA LEY CON GARANTÍAS MOBILIARIAS Y EL DEUDOR ES UNA PERSONA NATURAL QUE A LA FECHA NECESITA UN PRÉSTAMO DINERARIO; QUIEN DECLARA QUE EN LA FECHA EL ACREEDOR LE OTORGA EN CALIDAD DE PRÉSTAMO LA SUMA DE <b>S/. ------ 00/100 SOLES.</b> LOS MISMOS QUE GENERAN MENSUALMENTE LOS INTERESES COMPENSATORIOS Y MORATORIOS (DE SER EL CASO), COMISIONES, IMPUESTOS Y GASTOS ADMINISTRATIVOS QUE EL ACREEDOR TIENE VIGENTE PARA ESTE TIPO DE OPERACIONES QUE HAN SIDO EXPLICADAS DETALLADAMENTE AL DEUDOR Y QUE SERÁN POR TODO CONCEPTO, CONFORME SE DETALLA MAS ADELANTE.</p>

                                        <h5>2.- PLAZA Y PAGO DEL PRÉSTAMO.-</h5>
                                        <p class="text-justify">EL DEUDOR TIENE EL PLAZO MÁXIMO DE <b>------</b> CALENDARIOS PARA QUE CUMPLA CON CANCELAR EL PRÉSTAMO MATERIA DE ESTE CONTRATO, REPARTIDOS EN <b>------ PAGOS ------</b> CONTADOS A PARTIR DEL DÍA <b>----</b>, MES QUE CANCELARA EL CAPITAL MAS LOS INTERESES GENERADOS Y PACTADOS EN FORMA MENSUAL, HASTA LA CANCELACIÓN TOTAL DE LA DEUDA MAS LOS INTERESES.</p>
                                        
                                        <h5>3.- GARANTÍA.-</h5>
                                        <p class="text-justify">EL DEUDOR ACEPTA <b>FIRMAR UNA LETRA DE CAMBIO</b> PARA EL CUMPLIMIENTO DEL PAGO DEL PRÉSTAMO, INTERÉS, COMISIONES, GASTOS IMPUESTOS SEÑALADOS EN LA CLAUSULA PRIMERA, ASÍ COMO CUALQUIER OTRA OBLIGACIÓN FRENTE AL ACREEDOR, PRESENTE O FUTURA, ASÍ MISMO DECLARA SER ASESOR COMERCIAL DE EMPRESA DE JLN BUSINESS Y CONSTRUCTORES SAC. CON N° RUC 20600138881, JR. LOS MANZANOS N° 213, REF. RESTAURANT LA CANTUTA- DISTRITO DE EL TAMBO, PROVINCIA DE HUANCAYO, DEPARTAMENTO DE JUNÍN; LA DEUDA TIENE COMO FECHA DE VENCIMIENTO A <b>------</b></p>

                                        <h5>4.- INTERESES, COMISIONES Y GASTOS.-</h5> 
                                        <p class="text-justify">EL DEUDOR SE OBLIGA A PAGAR UNA TASA DE INTERÉS APLICABLE AL PRÉSTAMO CONCEDIDO DEL <b>---- % -----</b>; EL ACREEDOR COBRARA AL DEUDOR LOS INTERESES COMPENSATORIOS, MORAS O PENALIDADES (DE SER EL CASO), COMISIÓN, IMPUESTOS Y GASTOS EN LOS PORCENTAJES. EL DEUDOR RECONOCE HABER SIDO INSTRUIDO SOBRE LA FORMA DE CALCULO, OPORTUNIDAD DE COBRO Y EL MONTO DE LOS CONCEPTOS MENCIONADOS EN EL PÁRRAFO ANTERIOR, MANIFESTANDO SU ACEPTACIÓN Y CONFORMIDAD CON LOS MISMOS, QUEDA EXPRESAMENTE PACTADO QUE LA DEMORA EN PAGOS DE CUALES QUIERA DE LAS OBLIGACIONES ASUMIDAS POR EL DEUDOR DETERMINARA LAS SUMAS EN <b>EL INTERÉS MORATORIO DIARIO</b> O PENALIDADES (DE SER EL CASO) EN FORMA ADICIONAL AL INTERÉS COMPENSATORIO PACTADO.</p>

                                        <h5>5.- DE LA CESIÓN DE POSICIÓN CONTRACTUAL.-</h5> 
                                        <p class="text-justify">EL DEUDOR PRESTA SU CONFORMIDAD Y EXPRESAMENTE AUTORIZA AL ACREEDOR PARA CEDER O TRANSMITIR TOTAL O PARCIALMENTE TODOS LOS DERECHOS Y OBLIGACIONES DERIVADOS A ESTE CONTRATO EN FAVOR DE UN TERCERO NO SERA NECESARIO LA COMUNICACIÓN DE FECHA CIERTA AL DEUDOR PARA QUE LA CESIÓN SURTA EFECTOS ESTE PACTO COMPRENDE TANTO LA CESIÓN DE DERECHOS COMO LA CESIÓN DE POSICIÓN CONTRACTUAL. ASIMISMO EL ACREEDOR PODRÁ EFECTUAR O DAR EN GARANTÍA. CUALQUIER SEA LA FORMA QUE ESTA REVISTA LOS DERECHOS QUE ESTE CONTRATO CONFIERE.</p>

                                        <h5>6.- DOMICILIO Y CONVENIO ARBITRAL.-</h5> 
                                        <p class="text-justify">PARA LA VALIDEZ DE TODAS LAS COMUNICACIONES Y NOTIFICACIONES CON MOTIVO DE LA EJECUCIÓN DE ESTE CONTRATO. AMBAS PARTES SEÑALAN COMO SUS DOMICILIOS LOS INDICADOS EN LA PARTE INTRODUCTORIA DE ESTE DOCUMENTO EL CAMBIO DE DOMICILIO DE CUALQUIERA DE LAS PARTES SOLO SURTIRÁ EFECTOS DESDE LA FECHA DE COMUNICACIÓN A LA OTRA PARTE, POR CUALQUIER MEDIO ESCRITO, CON PLAZO ANTICIPACIÓN O MENOS A CINCO DÍAS. ASIMISMO, TODA LA CONTROVERSIA RELACIONADA A LA VALIDEZ, NULIDAD, INTERPRETACIÓN Y/O EJECUCIÓN DEL PRESENTE CONTRATO SERA SOMETIDO AL ARBITRAJE DE DERECHO SEGÚN Y CONFORME AL PROCEDIMIENTO PREVISTO EN EL PRESENTE CONTRATO SERA DE APLICACIÓN LA LEY DE GARANTÍA MOBILIARIA.</p>

                                        <h5>7.- DATOS PERSONALES.-</h5> 
                                        <p class="text-justify">EL DEUDOR RECONOCE QUE EN EL MARCO DE LA RELACIÓN QUE ESTE CONTRATO GENERAL A ENTREGADO AL ACREEDOR INFORMACIÓN Y/O DOCUMENTACIÓN SOBRE SU SITUACIÓN PERSONAL, FINANCIERA Y CREDITICIA, QUE PUDIERA SER CALIFICADA COMO DATOS PERSONALES CONFORME A LA LEGISLACIÓN DE LA MATERIA. LA MISMA QUE POR LA PRESENTE CLAUSULA AUTORIZA EXPRESAMENTE AL PRESTAMISTA A DAR TRATAMIENTO Y PROCESAR DE LA MANERA MAS AMPLIA PERMITIDA POR LA NORMAS PERTINENTE Y CONFORME A LOS PROCEDIMIENTOS QUE EL ACREEDOR DETERMINE EN EL MARCO DE SUS OPERACIONES HABITUALES.</p>

                                        <p class="text-justify">EN SEÑAL DE CONFORMIDAD LOS INTERVINIENTES SUSCRIBEN EL PRESENTE CONTRATO EN LA CIUDAD DE HUANCAYO A LOS  <b>------</b></p>

                                        <br><br><br>
                                    </div>
                                    <div class="col-6 text-center">
                                        <div style="border-top: 1px solid black; width:280px; float:left; position:relative; left:50%; transform:translateX(-50%);">ANDY PERALTA RIVEROS<br>DNI Nº 47726338<br><b>ACREEDOR</b></div>
                                    </div>
                                    <div class="col-6 text-center">
                                        <div style="border-top: 1px solid black; width:280px; float:left; position:relative; left:50%; transform:translateX(-50%);">SFDSFDSFDSFDSF<br>DNI Nº 456546<br><b>EL DEUDOR</b></div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <br><br><br>
                                        <div style="border-top: 1px solid black; width:280px; float:left; position:relative; left:50%; transform:translateX(-50%);">ELIANA HINOSTROZA RODRIGUEZ<br>DNI Nº 47726338<br><b>CRÉDITOS Y COBRANZAS</b></div>
                                    </div>
                                </div>              
                            </div>


                            <div class="col-12">
                                <hr>
                                <center><button type="button" class="btn btn-primary" onclick="printDiv('print-contrato')"><i class="far fa-file-alt"></i> Imprimir</button></center>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </body>
</html>