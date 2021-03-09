<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['creditos'],2,1) == 0){
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
                        <a onClick="window.location.href='../creditos.php';" class="btn btn-secondary" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option2" autocomplete="off"><i class="fas fa-lg fa-arrow-alt-circle-left"></i>
                        </a>
                        <a onClick="window.location.href='../index.php';" class="btn btn-secondary active" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked><i class="fas fa-home"></i> Inicio
                        </a> 
                    </div>
                </div>
                <div class="col-8">
                    <h3><span class="badge badge-info">DESEMBOLSOS DE CRÉDITO</div></h3>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-12" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" type="search" placeholder="Buscar Solicitud" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
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
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <div class="col text-center"> 
                                        <button style="width:155px;" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add" onclick='document.getElementById("formulario-principal").reset(); $("#modal-add h4").html("Desembolso de Créditos"); $("#form-ajax-result").html(""); metodo=1;'><i class="fas fa-lg fa-coins"></i> Desembolsar</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <div class="col text-center"> 
                                        <!--<button style="width:155px;" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add" onclick='document.getElementById("formulario-principal").reset(); $("#modal-add h4").html("Desembolso de Créditos"); $("#form-ajax-result").html(""); metodo=1;'><i class="fas fa-lg fa-coins"></i> Desembolsar</button>-->
                                        <button style="width:110px;" type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-ticket" onclick=''><i class="fas fa-lg fa-ticket-alt"></i> Ticket</button>
                                        <button style="width:138px;" type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-cronograma" onclick=''><i class="far fa-lg fa-calendar-alt"></i> Cronograma</button>
                                        <button style="width:120px;" type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-contrato" onclick=''><i class="far fa-lg fa-calendar-alt"></i> Contrato</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                                                <label for="inputCAJA" class="col-sm-3 col-form-label">*Caja</label>
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
                                                <label for="inputREFER" class="col-sm-3 col-form-label">*Participar con</label>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="SI" id="inputCONY" name="inputCONY" readonly onclick="return false;">
                                                        <label class="form-check-label" for="inputCONY">
                                                            Conyugue
                                                        </label>
                                                    </div>
                                                    <div class="w-100" style="height:7px;"></div>
                                                    <input list="conyugue" type="text" class="form-control form-control-sm" id="inputCONY_AJAX" name="inputCONY_AJAX" placeholder="Conyugue" disabled>
                                                    <datalist id="conyugue">
                                                        <option value="Azul"></option>
                                                        <option value="Amarillo"></option>
                                                        <option value="Burdeos"></option>
                                                    </datalist>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="SI" id="inputCONY" name="inputCONY" readonly onclick="return false;">
                                                        <label class="form-check-label" for="inputCONY">
                                                            Aval
                                                        </label>
                                                    </div>
                                                    <div class="w-100" style="height:7px;"></div>
                                                    <input list="aval" type="text" class="form-control form-control-sm" id="inputAVAL_AJAX" name="inputAVAL_AJAX" placeholder="Aval" disabled>
                                                    <datalist id="aval">
                                                        <option value="Azul"></option>
                                                        <option value="Amarillo"></option>
                                                        <option value="Burdeos"></option>
                                                    </datalist>
                                                </div>
                                            </div>

                                            <br>
                                            <span class="badge badge-info" style="font-size:1em;">Credito</span>
                                            <hr style="margin-top: 6px;">

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_MONTO" class="col-sm-4 col-form-label">*Monto</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control form-control-sm" id="sol_MONTO" name="sol_MONTO" placeholder="Monto del crédito" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_CUOTAS" class="col-sm-4 col-form-label">*Número de cuotas</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control form-control-sm" id="sol_CUOTAS" name="sol_CUOTAS" placeholder="Número de cuotas" required readonly>
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
                                                    <input type="number" class="form-control form-control-sm" id="sol_INTERES" name="sol_INTERES" placeholder="% de taza interés" required oninput="solicitud_interes=$(this).val(); solicitud_calendario();" readonly>
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
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_CUOTAS" name="sol_cal_CUOTAS" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_INTERES" class="col-sm-4 col-form-label">Monto del interés</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_INTERES" name="sol_cal_INTERES" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_TOTAL" class="col-sm-4 col-form-label">Monto + Interés</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_TOTAL" name="sol_cal_TOTAL" placeholder="" readonly>
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
                                <h5 style="margin:7px 4px; margin-top:8px;">Voucher</h5>
                                <button type="button" class="btn btn-danger" style="position:absolute;right:5px;top:3.5px;padding:3px 11px;" onclick="$('#modal-ticket').modal('hide');"><i class="fas fa-lg fa-times"></i></button>
                                <hr style="margin-top:5px;">
                            
                                <center><img src="../img/logoticket.jpg"></center>

                                <br>

                                <table style="font-family:monospace; font-size:14px; margin:auto;">
                                    <tr>
                                        <td>RUC:</td>
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
                                        <td>00000 00000 0000000000</td>
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

                               
                                <hr>

                                <p class="text-center">Recibi conforme</p>

                                <p class="text-center" style="margin-bottom:0px;">SDSDF SFSD F, Adsd</p>
                                <p class="text-center font-weight-bold">ASESOR</p>

                                <center><button type="button" class="btn btn-primary" onclick="printDiv('modal-ticket')">Imprimir</button></center>
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
            <div class="modal-dialog modal-lg" style="max-width:800px;" role="document">
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
                            <div class="col-12" id="print-cronograma">
                                <br>
                              
                                <div class="row">
                                    <div class="col-4">
                                        <img src="../img/logoticket.jpg">
                                    </div>
                                    <div class="col-5">
                                        <h4 style="margin-top:20px;">CALENDARIO DE PAGOS</h4>
                                    </div>
                                    <div class="col-3">
                                        <table style="font-family:arial; font-size:14px;">
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
                                            <table style="font-family:arial; font-size:14px;float:left; width:68%;">
                                                <tbody>
                                                    <tr>
                                                        <th>CLIENTE</th>
                                                        <th class="font-weight-normal pl-2">as dsd asd asd dsdsd asd ded de dde asd sad</th>
                                                    </tr>
                                                    <tr>
                                                        <th>FECHA DE DESEMBOLSO</th>
                                                        <th class="font-weight-normal pl-2">asdsd asd asasd de asdsad</th>
                                                    </tr>
                                                    <tr>
                                                        <th>DIRECCION</th>
                                                        <th class="font-weight-normal pl-2">asdsd asd asasd de asdsad</th>
                                                    </tr>
                                                    <tr>
                                                        <th>N° CEL CLIENTE</th>
                                                        <th class="font-weight-normal pl-2">asdsd asd asasd de asdsad</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table style="font-family:arial; font-size:14px;float:right;margin-left:8px; width:30%;">
                                                <tbody>
                                                    <tr>
                                                        <th>MONTO</th>
                                                        <th class="font-weight-normal pl-2">asd sdsd sdd sdd</th>
                                                    </tr>
                                                    <tr>
                                                        <th>INTERÉS</th>
                                                        <th class="font-weight-normal pl-2">asdsd asd</th>
                                                    </tr>
                                                    <tr>
                                                        <th>PLAZO</th>
                                                        <th class="font-weight-normal pl-2">asdsd asd</th>
                                                    </tr>
                                                    <tr>
                                                        <th>INSCRIPCIÓN</th>
                                                        <th class="font-weight-normal pl-2">asdsd asd</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                

                                <br>
                                

                                <div class="row" style="">
                                    <div class="col-12">
                                        <table class="table table-sm table-striped table-bordered" style="font-size:0.9em;">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">N° CUOTA</th>
                                                    <th scope="col">FECHA PROG.</th>
                                                    <th scope="col">CUOTA</th>
                                                    <th scope="col">FECHA DE PAGO</th>
                                                    <th scope="col">MONTO PAGADO</th>
                                                    <th scope="col">MORA</th>
                                                    <th scope="col">FIRMA</th>
                                                </tr>
                                            </thead>
                                            <tbody id="load_data_modal-cronograma">
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
                                        <p class="text-center">
                                            SU PUNTUALIDAD ES SU MEJOR GARANTIA PARA SU PROXIMO PRESTAMO<br>
                                            RECUERDE: Que por cada dia de retraso en su credito su mora sera de S/1.00 SOL
                                        </p>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-5">
                                        <table style="font-family:arial; font-size:14px;">
                                            <tbody>
                                                <tr>
                                                    <th>ANALISTA</th>
                                                    <th class="font-weight-normal pl-2">as dsd asd aded de dde asd</th>
                                                </tr>
                                                <tr>
                                                    <th>TELÉFONOS</th>
                                                    <th class="font-weight-normal pl-2">sfsf 8446545648<br>fwef 4564654654</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-3">
                                        <img src="../img/logoticket.jpg" style="width:100%;">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-12">
                                        <p class="text-center">UBICANOS: JR. Parra de Riego N° 585 - EL TAMBO HUANCAYO</p>
                                    </div>
                                </div>
                                           
                            </div>
                            <div class="col-12">
                                <hr>
                                <center><button type="button" class="btn btn-primary" onclick="printDiv('print-cronograma')">Imprimir</button></center>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </body>
</html>