<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['creditos'],1,1) == 0){
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
                    <h3><span class="badge badge-info">APROVACIONES DE CRÉDITO</div></h3>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-12" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <select class="form-control mr-sm-2" id="aprobaciones_buscar_tipo">
                                <option value="NOMBRE" selected>NOMBRE</option>
                                <option value="DNI">DNI</option>
                            </select>
                            <input class="form-control mr-sm-2" id="aprobaciones_buscar" type="search" style="width:360px;" placeholder="Buscar aprobaciones de credito por cliente" aria-label="Search" oninput="credito.buscar_aprobacion($(this).val());">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" onClick="credito.buscar_aprobacion($('#aprobaciones_buscar').val());"><i class="fas fa-search"></i> Buscar</button>
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
                        <thead class="thead-dark text-center">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">N° Cred</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Asesor</th>
                            <th scope="col">Monto Propuesto</th>
                            <th scope="col">Monto Aprobado</th>
                            <th scope="col">Fecha prea-probación</th>
                            <th scope="col">Fecha aprobación</th>
                            
                            <th scope="col">Estado</th>
                            <th scope="col">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="load_data_aprobaciones">
                            
                        </tbody>
                    </table>

                    <div id="load_table_aprobaciones"></div>

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
                                <form id="formulario-aprobacion" class="formulario-modal" enctype="multipart/form-data">
                                    <h4 style="margin-bottom:18px;">APROBAR/DESAPROBAR SOLICITUD DE CRÉDITO</h4>
                                    <hr>                           
                                    <div class="row">
                                        <div class="col-lg-5">        
                                            <div class="form-group row">
                                                <label for="inputADMIN" class="col-sm-3 col-form-label">*Administrador</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="inputADMIN" name="inputADMIN" placeholder="Nombre del Administrador" readonly>
                                                    <input type="hidden" name="inputADMIN-hidden" id="inputADMIN-hidden">
                                                </div>
                                            </div>         
                                            <div class="form-group row">
                                                <label for="inputASES" class="col-sm-3 col-form-label">*Asesor</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="inputASES" name="inputASES" placeholder="Nombre del Asesor" readonly>
                                                    <input type="hidden" name="inputASES-hidden" id="inputASES-hidden">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputCLIENT" class="col-sm-3 col-form-label">*Cliente</label>
                                                <div class="col-sm-9">
                                                    <input list="clientes" type="text" class="form-control form-control-sm" id="inputCLIENT" name="inputCLIENT" placeholder="Nombre del Cliente" autocomplete="off" readonly>
                                                    <input type="hidden" name="inputCLIENT-hidden" id="inputCLIENT-hidden">
                                                    <datalist id="clientes">
                                                        
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputREFER" class="col-sm-3 col-form-label">*Participar con</label>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="SI" id="inputCONY" name="inputCONY" disabled>
                                                        <label class="form-check-label" for="inputCONY">
                                                            Conyugue
                                                        </label>
                                                    </div>
                                                    <div class="w-100" style="height:7px;"></div>
                                                    <input list="conyugue-list-ajax" type="text" class="form-control form-control-sm" id="inputCONY_AJAX" name="inputCONY_AJAX" placeholder="Conyugue" readonly autocomplete="off" readonly>
                                                    <input type="hidden" name="inputCONY_AJAX-hidden" id="inputCONY_AJAX-hidden">
                                                    <datalist id="conyugue-list-ajax">
                                                       
                                                    </datalist>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="SI" id="inputAVAL" name="inputAVAL" disabled>
                                                        <label class="form-check-label" for="inputAVAL">
                                                            Aval
                                                        </label>
                                                    </div>
                                                    <div class="w-100" style="height:7px;"></div>
                                                    <input list="aval-list-ajax" type="text" class="form-control form-control-sm" id="inputAVAL_AJAX" name="inputAVAL_AJAX" placeholder="Aval" readonly autocomplete="off" readonly>
                                                    <input type="hidden" name="inputAVAL_AJAX-hidden" id="inputAVAL_AJAX-hidden">
                                                    <datalist id="aval-list-ajax">
                                                       
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_NEGOCIO" class="col-sm-3 col-form-label">Negocio</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control form-control-sm" id="sol_NEGOCIO" name="sol_NEGOCIO" placeholder="" rows="5" readonly></textarea>
                                                </div>
                                            </div>

                                            <br>
                                            <span class="badge badge-info" style="font-size:1em;">Credito</span>
                                            <hr style="margin-top: 6px;">

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-5 text-center"><span class="badge badge-secondary">Propuesto</span></div>
                                                <div class="col-sm-3 text-center"><span class="badge badge-success">Aprobado</span></div>
                                            </div>

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_MONTO" class="col-sm-4 col-form-label">*Monto Propuesto</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_MONTO" name="sol_MONTO" placeholder="Monto del crédito" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_MONTO_APRO" name="sol_MONTO_APRO" placeholder="Pendiente..."  required oninput="solicitud_monto=$(this).val(); solicitud_calendario_adm();">
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_CUOTAS" class="col-sm-4 col-form-label">*Número de cuotas</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_CUOTAS" name="sol_CUOTAS" placeholder="Número de cuotas" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_CUOTAS_APRO" name="sol_CUOTAS_APRO" placeholder="Pendiente..." required oninput="solicitud_cuotas=$(this).val(); solicitud_calendario_adm();">
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_INTERES" class="col-sm-4 col-form-label">*Tasa de Interés %</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_INTERES" name="sol_INTERES" placeholder="% de taza interés"  readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_INTERES_APRO" name="sol_INTERES_APRO" placeholder="Pendiente..." required oninput="solicitud_interes=$(this).val(); solicitud_calendario_adm();">
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_FRECUENCIA" class="col-sm-4 col-form-label">*Frecuencia</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="sol_FRECUENCIA" name="sol_FRECUENCIA" disabled>
                                                        <option value="" disabled selected>--Seleccionar--</option>
                                                        <option value="DIARIO">Diario</option>
                                                        <option value="SEMANAL">Semanal</option>
                                                        <option value="QUINCENAL">Quincenal</option>
                                                        <option value="MENSUAL">Mensual</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_INICIO" class="col-sm-4 col-form-label">*Fecha de inicio</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control form-control-sm" id="sol_INICIO" name="sol_INICIO" placeholder="Fecha del primer pago" readonly>
                                                </div>
                                            </div>

                                            <div class="w-100" style="height:20px;"></div>

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_CUOTAS" class="col-sm-4 col-form-label">Monto de las cuotas</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_CUOTAS" name="sol_cal_CUOTAS" placeholder="" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_CUOTAS_APRO" name="sol_cal_CUOTAS_APRO" placeholder="Pendiente..." required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_INTERES" class="col-sm-4 col-form-label">Monto del interés</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_INTERES" name="sol_cal_INTERES" placeholder="" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_INTERES_APRO" name="sol_cal_INTERES_APRO" placeholder="Pendiente..." required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_TOTAL" class="col-sm-4 col-form-label">Monto + Interés</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_TOTAL" name="sol_cal_TOTAL" placeholder="" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_TOTAL_APRO" name="sol_cal_TOTAL_APRO" placeholder="Pendiente..." required readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-7">
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
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                                                    
                                                                  

                                    <div class="w-100" style="height:8px;"></div>
                                    <div id="msg-ajax-result">
                                        
                                    </div>

                                    <button type="submit" class="btn btn-success btn_modals"><i class="far fa-lg fa-save"></i> Guardar</button>
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



        <!-- MODAL ADD view -->
        <!-- MODAL ADD view -->
        <div class="modal fade bd-example-modal-sm" id="modal-add-view" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">


                    <div class="container-fluid modal-body" style="padding:15px;">
                        <div class="row justify-content-center"> 
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add-view').modal('hide');"><i class="fas fa-lg fa-times"></i></button>
                                <form id="formulario-aprobacion-view" class="formulario-modal" enctype="multipart/form-data">
                                    <h4 style="margin-bottom:18px;">APROBAR/DESAPROBAR SOLICITUD DE CRÉDITO</h4>
                                    <hr>                           
                                    <div class="row">
                                        <div class="col-lg-5">        
                                            <div class="form-group row">
                                                <label for="inputADMIN-w" class="col-sm-3 col-form-label">*Administrador</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="inputADMIN-w" name="inputADMIN-w" placeholder="Nombre del Administrador" readonly>
                                                    <input type="hidden" name="inputADMIN-hidden-w" id="inputADMIN-hidden-w">
                                                </div>
                                            </div>         
                                            <div class="form-group row">
                                                <label for="inputASES-w" class="col-sm-3 col-form-label">*Asesor</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control-sm" id="inputASES-w" name="inputASES-w" placeholder="Nombre del Asesor" readonly>
                                                    <input type="hidden" name="inputASES-hidden-w" id="inputASES-hidden-w">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputCLIENT-w" class="col-sm-3 col-form-label">*Cliente</label>
                                                <div class="col-sm-9">
                                                    <input list="clientes" type="text" class="form-control form-control-sm" id="inputCLIENT-w" name="inputCLIENT-w" placeholder="Nombre del Cliente" autocomplete="off" readonly>
                                                    <input type="hidden" name="inputCLIENT-hidden-w" id="inputCLIENT-hidden-w">
                                                    <datalist id="clientes">
                                                        
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputREFER-w" class="col-sm-3 col-form-label">*Participar con</label>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="SI" id="inputCONY-w" name="inputCONY-w" disabled>
                                                        <label class="form-check-label" for="inputCONY-w">
                                                            Conyugue
                                                        </label>
                                                    </div>
                                                    <div class="w-100" style="height:7px;"></div>
                                                    <input list="conyugue-list-ajax" type="text" class="form-control form-control-sm" id="inputCONY_AJAX-w" name="inputCONY_AJAX-w" placeholder="Conyugue" readonly autocomplete="off" readonly>
                                                    <input type="hidden" name="inputCONY_AJAX-hidden-w" id="inputCONY_AJAX-hidden-w">
                                                    <datalist id="conyugue-list-ajax">
                                                       
                                                    </datalist>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="SI" id="inputAVAL-w" name="inputAVAL-w" disabled>
                                                        <label class="form-check-label" for="inputAVAL-w">
                                                            Aval
                                                        </label>
                                                    </div>
                                                    <div class="w-100" style="height:7px;"></div>
                                                    <input list="aval-list-ajax" type="text" class="form-control form-control-sm" id="inputAVAL_AJAX-w" name="inputAVAL_AJAX-w" placeholder="Aval" readonly autocomplete="off" readonly>
                                                    <input type="hidden" name="inputAVAL_AJAX-hidden-w" id="inputAVAL_AJAX-hidden-w">
                                                    <datalist id="aval-list-ajax">
                                                       
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_NEGOCIO-w" class="col-sm-3 col-form-label">Negocio</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control form-control-sm" id="sol_NEGOCIO-w" name="sol_NEGOCIO-w" placeholder="" rows="5" readonly></textarea>
                                                </div>
                                            </div>

                                            <br>
                                            <span class="badge badge-info" style="font-size:1em;">Credito</span>
                                            <hr style="margin-top: 6px;">

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-5 text-center"><span class="badge badge-secondary">Propuesto</span></div>
                                                <div class="col-sm-3 text-center"><span class="badge badge-success">Aprobado</span></div>
                                            </div>

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_MONTO-w" class="col-sm-4 col-form-label">*Monto Propuesto</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_MONTO-w" name="sol_MONTO-w" placeholder="Monto del crédito" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_MONTO_APRO-w" name="sol_MONTO_APRO-w" placeholder="Pendiente..."  readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_CUOTAS-w" class="col-sm-4 col-form-label">*Número de cuotas</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_CUOTAS-w" name="sol_CUOTAS-w" placeholder="Número de cuotas" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_CUOTAS_APRO-w" name="sol_CUOTAS_APRO-w" placeholder="Pendiente..." readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_INTERES-w" class="col-sm-4 col-form-label">*Tasa de Interés %</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_INTERES-w" name="sol_INTERES-w" placeholder="% de taza interés"  readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_INTERES_APRO-w" name="sol_INTERES_APRO-w" placeholder="Pendiente..." readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_FRECUENCIA-w" class="col-sm-4 col-form-label">*Frecuencia</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm" id="sol_FRECUENCIA-w" name="sol_FRECUENCIA-w" disabled>
                                                        <option value="" disabled selected>--Seleccionar--</option>
                                                        <option value="DIARIO">Diario</option>
                                                        <option value="SEMANAL">Semanal</option>
                                                        <option value="QUINCENAL">Quincenal</option>
                                                        <option value="MENSUAL">Mensual</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_INICIO-w" class="col-sm-4 col-form-label">*Fecha de inicio</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control form-control-sm" id="sol_INICIO-w" name="sol_INICIO-w" placeholder="Fecha del primer pago" readonly>
                                                </div>
                                            </div>

                                            <div class="w-100" style="height:20px;"></div>

                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_CUOTAS-w" class="col-sm-4 col-form-label">Monto de las cuotas</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_CUOTAS-w" name="sol_cal_CUOTAS-w" placeholder="" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_CUOTAS_APRO-w" name="sol_cal_CUOTAS_APRO-w" placeholder="Pendiente..." required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_INTERES-w" class="col-sm-4 col-form-label">Monto del interés</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_INTERES-w" name="sol_cal_INTERES-w" placeholder="" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_INTERES_APRO-w" name="sol_cal_INTERES_APRO-w" placeholder="Pendiente..." required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="margin-bottom:0.5em;">
                                                <label for="sol_cal_TOTAL-w" class="col-sm-4 col-form-label">Monto + Interés</label>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_TOTAL-w" name="sol_cal_TOTAL-w" placeholder="" readonly>
                                                </div>
                                                <div class="col-sm-3" style="padding:0px 1px;">
                                                    <input type="number" class="form-control form-control-sm" id="sol_cal_TOTAL_APRO-w" name="sol_cal_TOTAL_APRO-w" placeholder="Pendiente..." required readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-7">
                                            <table class="table table-sm table-striped table-bordered" style="font-size:0.9em;">
                                                <thead class="thead-dark">
                                                    <tr>
                                                    <th scope="col">N°</th>
                                                    <th scope="col">Fecha Programada</th>
                                                    <th scope="col">Cuota de pago</th>
                                                    <th scope="col">Deuda por pagar</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="load_data_modal-w">
                                                    <tr>
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" style="height:25px;"></th><td></td><td></td><td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                                                    
                                                                  

                                    <div class="w-100" style="height:8px;"></div>
                                    <div id="msg-ajax-result-w">
                                        
                                    </div>

                                   
                                    <div class="modal-btn-cont">
                                        
                                    </div>
                                    <button type="button" class="btn btn-warning btn_modals" onclick="$('#modal-add-view').modal('hide');"><i class="fas fa-lg fa-ban"></i> Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </body>
</html>