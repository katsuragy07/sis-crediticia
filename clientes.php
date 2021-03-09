<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."intranet.php"); 
    }else{
        require_once("includes/rutas.php");
    }
    
    if(!$menu["clientes"]){
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
                    <h3><span class="badge badge-info">ADMINISTRACIÓN DE CLIENTES</div></h3>
                </div>
            </div>
        </div>

    
        <div class="container-fluid">
            <div class="row justify-content-end">

                <div class="col-9" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <select class="form-control mr-sm-2" id="clientes_buscar_tipo">
                                <option value="NOMBRE" selected>NOMBRE</option>
                                <option value="DNI">DNI</option>
                            </select>
                            <input class="form-control mr-sm-2" id="clientes_buscar" type="search" style="width:360px;" placeholder="Buscar Clientes" aria-label="Search" oninput="cliente.buscar_cliente($(this).val());">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" onClick="cliente.buscar_cliente($('#clientes_buscar').val());"><i class="fas fa-search"></i> Buscar</button>
                        </form>
                    </nav>
                </div>

                <div class="col-sm-3" style="padding:8px 16px;">
                    <button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add" onclick='btn_add("clientes");'>Añadir <i class="fas fa-plus"></i></button>
                </div>

                <div class="w-100"></div>

                <div class="col">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark text-center">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">DNI</th>
                            <th scope="col">CLIENTE</th>
                            <th scope="col">DIRECCIÓN</th>
                            <th scope="col">TELÉFONO</th>
                            <th scope="col">CALIFICACIÓN</th>
                            <th scope="col">CRÉDITOS ACTIVOS</th>
                            <th scope="col">HABILITADO</th>
                            <th scope="col">OPERACIONES</th>
                            </tr>
                        </thead>
                        <tbody id="load_data_clientes">
                                    
                        </tbody>
                    </table>

                    <div id="load_table_clientes"></div>

                </div>
                
            </div>
        </div>

        
        <!-- MODAL ADD -->
        <!-- MODAL ADD -->
        <div class="modal fade bd-example-modal-sm" id="modal-add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">


                    <div class="container-fluid modal-body" style="padding:15px;">
                        <div class="row justify-content-center"> 
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add').modal('hide'); cliente.editURLimg = 0; cliente.editURLimg2 = 0;"><i class="fas fa-lg fa-times"></i></button>
                                <form id="formulario-clientes" class="formulario-modal" enctype="multipart/form-data">
                                    <h4 style="margin-bottom:18px;">REGISTRAR CLIENTE</h4>
                                                                        
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">General</a>
                                            <a class="nav-item nav-link" id="nav-contacto-tab" data-toggle="tab" href="#nav-contacto" role="tab" aria-controls="nav-contacto" aria-selected="false">Contacto</a>   
                                            <a class="nav-item nav-link" id="nav-conyugue-tab" data-toggle="tab" href="#nav-conyugue" role="tab" aria-controls="nav-conyugue" aria-selected="false">Conyugue/Aval</a>
                                            <a class="nav-item nav-link" id="nav-negocio-tab" data-toggle="tab" href="#nav-negocio" role="tab" aria-controls="nav-negocio" aria-selected="false" >Negocio</a>
                                        </div>
                                    </nav>
                                    <div class="row justify-content-center">   
                                        <div class="tab-content row justify-content-center col-12" id="nav-tabContent">


                                            <div class="col-9 tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
                                                <br>
                                                <div class="row justify-content-center">
                                                    <div class="col-12">
                                                        <div class="modal_foto_perfil" id="load_foto_modal">
                                                            <img src="img/user.png" width="100%">
                                                        </div>
                                                        <center>
                                                            <input type="file" class="" id="inputIMG" name="inputIMG">
                                                        </center>                                                                                            
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="form-group row">
                                                    <label for="inputINS" class="col-sm-3 col-form-label">*Inscripcion pagada</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" id="inputINS" name="inputINS" placeholder="Inscripción" required>
                                                            <option value="SI" selected>Si</option>
                                                            <option value="NO">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputAP" class="col-sm-3 col-form-label">*Apellido Paterno</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputAP" name="inputAP" placeholder="Apellido Paterno" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputAM" class="col-sm-3 col-form-label">*Apellido Materno</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputAM" name="inputAM" placeholder="Apellido Materno" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputNOM" class="col-sm-3 col-form-label">*Nombres</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputNOM" name="inputNOM" placeholder="Nombres" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputDNI" class="col-sm-3 col-form-label">*DNI</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputDNI" name="inputDNI" placeholder="Número de DNI" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputOCUPACION_TIPO" class="col-sm-3 col-form-label">*Ocupación</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" id="inputOCUPACION_TIPO" name="inputOCUPACION_TIPO" placeholder="Tipo de ocupación" required>
                                                            <option value="" disabled selected>--Seleccionar--</option>
                                                            <option value="ESTUDIANTE">Estudiante</option>
                                                            <option value="EMPLEADO">Empleado</option>
                                                            <option value="DESEMPLEADO">Desempleado</option>
                                                            <option value="EMPRESARIO">Empresario</option>
                                                            <option value="INDEPENDIENTE">Independiente</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputOCUPACION_DES" class="col-sm-3 col-form-label">Ocupacion (Descripción)</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputOCUPACION_DES" name="inputOCUPACION_DES" placeholder="Ocupación Descripción">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputNAC" class="col-sm-3 col-form-label">Fecha de Nacimiento</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" class="form-control" id="inputNAC" name="inputNAC" placeholder="Fecha de nacimiento">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputNH" class="col-sm-3 col-form-label">N° de hijos</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" id="inputNH" name="inputNH" placeholder="Hijos dependientes">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputGRADO" class="col-sm-3 col-form-label">Grado Institucional</label>
                                                    <div class="col-sm-9">
                                                        <select type="text" class="form-control" id="inputGRADO" name="inputGRADO" placeholder="Grado Institucional">
                                                            <option value="" selected>--Seleccionar--</option>
                                                            <option value="NONE">Sin educación formal</option>
                                                            <option value="INICIAL">Educación Inicial</option>
                                                            <option value="PRIMARIA">Educación Primaria</option>
                                                            <option value="SECUNDARIA">Educación Secundaria</option>
                                                            <option value="TECNICA">Educación Técnica</option>
                                                            <option value="SUPERIOR">Educación Superior</option>
                                                            <option value="UNIVERSITARIA">Educación Universitaria</option>
                                                            <option value="BACHILLER">Grado de Bachiller</option>
                                                            <option value="TITULO">Titulado</option>
                                                            <option value="MAESTRIA">Grado de Maestría</option>
                                                            <option value="DOCTORADO">Grado de Doctor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEC" class="col-sm-3 col-form-label">Estado Civil</label>
                                                    <div class="col-sm-9">
                                                        <select type="text" class="form-control" id="inputEC" name="inputEC" placeholder="Estado civil">
                                                            <option value="" selected>--Seleccionar--</option>
                                                            <option value="SOLTERO">Soltero/a</option>
                                                            <option value="CASADO">Casado/a</option>
                                                            <option value="CONVIVIENTE">Conviviente/a</option>
                                                            <option value="DIVORCIADO">Divorciado/a</option>
                                                            <option value="VIUDO">Viudo/a</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputLN" class="col-sm-3 col-form-label">Lugar de Nacimiento</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputLN" name="inputLN" placeholder="Lugar de Nacimiento">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputCOM" class="col-sm-3 col-form-label">Comentarios</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" id="inputCOM" name="inputCOM" placeholder="Comentarios" rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputOBS" class="col-sm-3 col-form-label">Observaciones</label>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" id="inputOBS" name="inputOBS" placeholder="Observaciones" rows="4" readonly></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-9 tab-pane fade" id="nav-contacto" role="tabpanel" aria-labelledby="nav-contacto-tab">
                                                <br>
                                                <div class="form-group row">
                                                    <label for="inputTEL" class="col-sm-3 col-form-label">*Teléfono</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputTEL" name="inputTEL" placeholder="Número telefónico" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputDIR" class="col-sm-3 col-form-label">*Dirección</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputDIR" name="inputDIR" placeholder="Dirección" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputREF" class="col-sm-3 col-form-label">Referencia</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputREF" name="inputREF" placeholder="Referencia">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputDIS" class="col-sm-3 col-form-label">*Distrito</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputDIS" name="inputDIS" placeholder="Distrito" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputPROV" class="col-sm-3 col-form-label">*Provincia</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputPROV" name="inputPROV" placeholder="Provincia" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputDOM" class="col-sm-3 col-form-label">Tipo de Domicilio</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" id="inputDOM" name="inputDOM" placeholder="Tipo de Domicilio">
                                                            <option value="" selected>--Seleccionar--</option>
                                                            <option value="PROPIA">Propia</option>
                                                            <option value="FAMILIAR">Familiar</option>
                                                            <option value="ALQUILADA">Alquilada</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputTR" class="col-sm-3 col-form-label">Tiempo de residencia</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputTR" name="inputTR" placeholder="Tiempo de residencia">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputTR" class="col-sm-3 col-form-label">Croquis del domicilio</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="" id="inputCROQ" name="inputCROQ">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12 tab-pane fade" id="nav-conyugue" role="tabpanel" aria-labelledby="nav-conyugue-tab">
                                                <br>
                                                <table class="table table-striped table-bordered">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">DNI</th>
                                                        <th scope="col">NOMBRES</th>
                                                        <th scope="col">RELACIÓN</th>
                                                        <th scope="col"><button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add-conyugue" onclick='btn_add("conyugue");'>Añadir <i class="fas fa-plus"></i></button></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load_data_conyugue">
                                                        
                                                    </tbody>
                                                </table>
                                                <hr>
                                            </div>


                                            <div class="col-12 tab-pane fade" id="nav-negocio" role="tabpanel" aria-labelledby="nav-negocio-tab">
                                                <br>
                                                <h5>Negocio</h5>
                                                <table class="table table-striped table-bordered">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">TIPO</th>
                                                        <th scope="col">SECTOR</th>
                                                        <th scope="col"><button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add-negocio" onclick='btn_add("negocio");'>Añadir <i class="fas fa-plus"></i></button></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load_data_negocio_normal">
                                                       
                                                    </tbody>
                                                </table>
                                                <br>
                                                <h5>Transporte</h5>
                                                <table class="table table-striped table-bordered">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">TIPO</th>
                                                        <th scope="col">EMPRESA</th>
                                                        <th scope="col"><button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add-transporte" onclick='btn_add("transporte");'>Añadir <i class="fas fa-plus"></i></button></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load_data_negocio_transporte">
                                                       
                                                    </tbody>
                                                </table>
                                                <br>
                                                <h5>Creditos de Consumo</h5>
                                                <table class="table table-striped table-bordered">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">DEDICACIÓN</th>
                                                        <th scope="col">INGRESO MENSUAL</th>
                                                        <th scope="col">LUGAR DE TRABAJO</th>
                                                        <th scope="col"><button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add-consumo" onclick='btn_add("consumo");'>Añadir <i class="fas fa-plus"></i></button></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load_data_credito_consumo">
                                                        
                                                    </tbody>
                                                </table>
                                                <hr>
                                            </div>


                                        </div>
                                    </div>

                                                                    
                                                                  

                                    <div class="w-100" style="height:8px;"></div>
                                    <div id="msg-ajax-result"></div>

                                    <button type="submit" class="btn btn-success btn_modals"><i class="far fa-lg fa-save"></i> Guardar</button>
                                    <div class="modal-btn-cont">
                                        
                                    </div>
                                    <button type="button" class="btn btn-warning btn_modals" onclick="$('#modal-add').modal('hide'); cliente.editURLimg = 0; cliente.editURLimg2 = 0;"><i class="fas fa-lg fa-ban"></i> Cancelar</button>

                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>



        <!-- MODAL ADD CONYUGUE -->
        <!-- MODAL ADD CONYUGUE -->
        <div class="modal fade bd-example-modal-sm" id="modal-add-conyugue" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="container-fluid" style="padding:15px;">
                        <div class="row justify-content-center"> 
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add-conyugue').modal('hide');"><i class="fas fa-lg fa-times"></i></button>
                                <form id="formulario-conyugue" class="formulario-modal" enctype="multipart/form-data">
                                    <h4 style="margin-bottom:18px;">REGISTRAR CONYUGUE</h4>
                                    <br>
                                    <div class="form-group row">
                                        <label for="input_con_AP" class="col-sm-3 col-form-label">*Apellido Paterno</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" class="form-control" id="input_con_IDCLI" name="input_con_IDCLI">
                                            <input type="text" class="form-control" id="input_con_AP" name="input_con_AP" placeholder="Apellido Paterno" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_AM" class="col-sm-3 col-form-label">*Apellido Materno</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="input_con_AM" name="input_con_AM" placeholder="Apellido Materno" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_NOM" class="col-sm-3 col-form-label">*Nombres</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="input_con_NOM" name="input_con_NOM" placeholder="Nombres" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_DNI" class="col-sm-3 col-form-label">*DNI</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="input_con_DNI" name="input_con_DNI" placeholder="DNI" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_SEXO" class="col-sm-3 col-form-label">*Género</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="input_con_SEXO" name="input_con_SEXO" placeholder="Género" required>
                                                <option value="" disabled selected>--Seleccionar--</option>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_FN" class="col-sm-3 col-form-label">Fecha de Nacimiento</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="input_con_FN" name="input_con_FN" placeholder="Fecha de Nacimiento">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_DIR" class="col-sm-3 col-form-label">*Dirección</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="input_con_DIR" name="input_con_DIR" placeholder="Dirección" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_REF" class="col-sm-3 col-form-label">Referencia</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="input_con_REF" name="input_con_REF" placeholder="Referencia de Dirección">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_OCUP" class="col-sm-3 col-form-label">*Ocupación</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="input_con_OCUP" name="input_con_OCUP" placeholder="Ocupación" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_DIRT" class="col-sm-3 col-form-label">*Dirección del centro de trabajo</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="input_con_DIRT" name="input_con_DIRT" placeholder="Dirección del centro de trabajo" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_PT" class="col-sm-3 col-form-label">*Parentesco con el titular</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="input_con_PT" name="input_con_PT" placeholder="Parentesco" required>
                                                <option value="" disabled selected>--Seleccionar--</option>
                                                <option value="MADRE">Madre</option>
                                                <option value="PADRE">Padre</option>
                                                <option value="ESPOSO">Esposo(a)</option>
                                                <option value="HIJO">Hijo(a)</option>
                                                <option value="ABUELO">Abuelo(a)</option>
                                                <option value="NIETO">Nieto(a)</option>
                                                <option value="HERMANO">Hermano(a)</option>
                                                <option value="PRIMO">Primo(a)</option>
                                                <option value="TIO">Tio(a)</option>
                                                <option value="SOBRINO">Sobrino(a)</option>
                                                <option value="CONOCIDO">Conocido(a)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="input_con_DIRT" class="col-sm-3 col-form-label">*Conyugue/Aval</label>
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="input_con_CA" id="input_con_CA1" value="CONYUGUE" checked>
                                                <label class="form-check-label" for="input_con_CA1">Conyugue</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="input_con_CA" id="input_con_CA2" value="AVAL">
                                                <label class="form-check-label" for="input_con_CA2">Aval</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-100" style="height:8px;"></div>
                                    <div id="conyugue-ajax-result"></div>

                                    <button type="submit" class="btn btn-success btn_modals"><i class="far fa-lg fa-save"></i> Guardar</button>
                                    <div class="modal-btn-cont-2">
                                        
                                    </div>
                                    <button type="button" class="btn btn-warning btn_modals" onclick="$('#modal-add-conyugue').modal('hide');"><i class="fas fa-lg fa-ban"></i> Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- MODAL ADD NEGOCIO NORMAL -->
        <!-- MODAL ADD NEGOCIO NORMAL -->
        <div class="modal fade bd-example-modal-sm" id="modal-add-negocio" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
    
                        <div class="container-fluid" style="padding:15px;">
                            <div class="row justify-content-center"> 
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add-negocio').modal('hide'); editURLimgNEG = 0;"><i class="fas fa-lg fa-times"></i></button>
                                    <form id="formulario-negocio" class="formulario-modal" enctype="multipart/form-data">
                                        <h4 style="margin-bottom:18px;">REGISTRAR NEGOCIO</h4>
                                        <br>
                                        <div class="form-group row">
                                            <label for="input_neg_TIPO" class="col-sm-3 col-form-label">*Tipo</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="input_neg_TIPO" name="input_neg_TIPO" placeholder="Tipo" required>
                                                    <option value="" disabled selected>--Seleccionar--</option>
                                                    <option value="AMBULANTE">Ambulante</option>
                                                    <option value="MERCADO">Puesto Mercado</option>
                                                    <option value="ESTABLECIMIENTO">Establecimiento</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_neg_TIPOLOC" class="col-sm-3 col-form-label">*Tipo de Local</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="input_neg_TIPOLOC" name="input_neg_TIPOLOC" placeholder="Tipo de Local" required>
                                                    <option value="" disabled selected>--Seleccionar--</option>
                                                    <option value="ALQUILADO">Alquilado</option>
                                                    <option value="PROPIO">Propio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_neg_SECTOR" class="col-sm-3 col-form-label">*Sector</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="input_neg_SECTOR" name="input_neg_SECTOR" placeholder="Sector" required>
                                                    <option value="" disabled selected>--Seleccionar--</option>
                                                    <option value="COMERCIO">Comercio</option>
                                                    <option value="SERVICIOS">Servicios</option>
                                                    <option value="PRODUCCION">Producción</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_neg_TIEMPO" class="col-sm-3 col-form-label">Tiempo de actividad</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_neg_TIEMPO" name="input_neg_TIEMPO" placeholder="Tiempo de actividad">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_neg_CROQUIS" class="col-sm-3 col-form-label">Croquis del negocio</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="" id="input_neg_CROQUIS" name="input_neg_CROQUIS" placeholder="Croquis del Negocio">
                                            </div>
                                        </div>
                                    
                                       
    
                                        <div class="w-100" style="height:8px;"></div>
                                        <div id="negocio-ajax-result"></div>
    
                                        <button type="submit" class="btn btn-success btn_modals"><i class="far fa-lg fa-save"></i> Guardar</button>
                                        <div class="modal-btn-cont-2">
                                        
                                        </div>
                                        <button type="button" class="btn btn-warning btn_modals" onclick="$('#modal-add-negocio').modal('hide'); editURLimgNEG = 0;"><i class="fas fa-lg fa-ban"></i> Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
        </div>

        <!-- MODAL ADD NEGOCIO TRANSPORTE -->
        <!-- MODAL ADD NEGOCIO TRANSPORTE -->
        <div class="modal fade bd-example-modal-sm" id="modal-add-transporte" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
    
                        <div class="container-fluid" style="padding:15px;">
                            <div class="row justify-content-center"> 
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add-transporte').modal('hide'); editURLimgNEG = 0;"><i class="fas fa-lg fa-times"></i></button>
                                    <form id="formulario-transporte" class="formulario-modal" enctype="multipart/form-data">
                                        <h4 style="margin-bottom:18px;">REGISTRAR NEGOCIO</h4>
                                        <br>
                                        <div class="form-group row">
                                            <label for="input_trans_TIPO" class="col-sm-3 col-form-label">*Tipo</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="input_trans_TIPO" name="input_trans_TIPO" placeholder="Tipo" required>
                                                    <option value="" disabled selected>--Seleccionar--</option>
                                                    <option value="INFORMAL">Informal</option>
                                                    <option value="FORMAL">Formal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_trans_PLACA" class="col-sm-3 col-form-label">Placa de Unidad</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_trans_PLACA" name="input_trans_PLACA" placeholder="Placa de Unidad">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_trans_EMP" class="col-sm-3 col-form-label">*Empresa</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_trans_EMP" name="input_trans_EMP" placeholder="Empresa" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_trans_DIR" class="col-sm-3 col-form-label">Dirección de la Empresa</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_trans_DIR" name="input_trans_DIR" placeholder="Dirección de la Empresa">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_trans_SOAT" class="col-sm-3 col-form-label">*SOAT<br>(Caducidad)</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="input_trans_SOAT" name="input_trans_SOAT" placeholder="Soat" required>
                                                    <option value="" disabled selected>--Seleccionar--</option>
                                                    <option value="SI">Si</option>
                                                    <option value="NO">No</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="date" class="form-control" id="input_trans_SOAT_CAD" name="input_trans_SOAT_CAD" placeholder="Fecha de caducidad" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_trans_TARJETA" class="col-sm-3 col-form-label">*Tarjeta de circulación<br>(Caducidad)</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="input_trans_TARJETA" name="input_trans_TARJETA" placeholder="Tarjeta de circulación" required>
                                                    <option value="" disabled selected>--Seleccionar--</option>
                                                    <option value="SI">Si</option>
                                                    <option value="NO">No</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="date" class="form-control" id="input_trans_TARJETA_CAD" name="input_trans_TARJETA_CAD" placeholder="Fecha de caducidad" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="input_trans_TIEMPO" class="col-sm-3 col-form-label">Tiempo de actividad</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_trans_TIEMPO" name="input_trans_TIEMPO" placeholder="Tiempo de actividad">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_trans_CROQUIS" class="col-sm-3 col-form-label">Croquis del negocio</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="" id="input_trans_CROQUIS" name="input_trans_CROQUIS" placeholder="Croquis del Negocio">
                                            </div>
                                        </div>
                                    
                                       
    
                                        <div class="w-100" style="height:8px;"></div>
                                        <div id="transporte-ajax-result"></div>
    
                                        <button type="submit" class="btn btn-success btn_modals"><i class="far fa-lg fa-save"></i> Guardar</button>
                                        <div class="modal-btn-cont-2">
                                        
                                        </div>
                                        <button type="button" class="btn btn-warning btn_modals" onclick="$('#modal-add-transporte').modal('hide'); editURLimgNEG = 0;"><i class="fas fa-lg fa-ban"></i> Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
        </div>

        <!-- MODAL ADD CREDITO CONSUMO -->
        <!-- MODAL ADD CREDITO CONSUMO -->
        <div class="modal fade bd-example-modal-sm" id="modal-add-consumo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
    
                        <div class="container-fluid" style="padding:15px;">
                            <div class="row justify-content-center"> 
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add-consumo').modal('hide');"><i class="fas fa-lg fa-times"></i></button>
                                    <form id="formulario-consumo" class="formulario-modal" enctype="multipart/form-data">
                                        <h4 style="margin-bottom:18px;">REGISTRAR CRÉDITO DE CONSUMO</h4>
                                        <br>
                                        <div class="form-group row">
                                            <label for="input_cons_DEDICA" class="col-sm-3 col-form-label">*Dedicación</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_cons_DEDICA" name="input_cons_DEDICA" placeholder="A qué se dedica" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_cons_TIEMPO" class="col-sm-3 col-form-label">*Años</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_cons_TIEMPO" name="input_cons_TIEMPO" placeholder="Años de ocupación" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_cons_INGRESO" class="col-sm-3 col-form-label">*Ingreso mensual</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_cons_INGRESO" name="input_cons_INGRESO" placeholder="Cuanto persigue mensualmente" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_cons_TRABAJO" class="col-sm-3 col-form-label">*Lugar de trabajo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_cons_TRABAJO" name="input_cons_TRABAJO" placeholder="Lugar de trabajo" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="input_cons_PROFESION" class="col-sm-3 col-form-label">*Profesión</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="input_cons_PROFESION" name="input_cons_PROFESION" placeholder="Profesión" required>
                                            </div>
                                        </div>
                                    
                                       
    
                                        <div class="w-100" style="height:8px;"></div>
                                        <div id="consumo-ajax-result"></div>
    
                                        <button type="submit" class="btn btn-success btn_modals"><i class="far fa-lg fa-save"></i> Guardar</button>
                                        <div class="modal-btn-cont-2">
                                        
                                        </div>
                                        <button type="button" class="btn btn-warning btn_modals" onclick="$('#modal-add-consumo').modal('hide');"><i class="fas fa-lg fa-ban"></i> Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
        </div>

    </body>
</html>