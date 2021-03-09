<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."intranet.php"); 
    }else{
        require_once("includes/rutas.php");
    }
    
    if(!$menu["usuarios"]){
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
                    <h3><span class="badge badge-info">ADMINISTRACIÓN DE USUARIOS</div></h3>
                </div>
            </div>
        </div>

    
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-9" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <select class="form-control mr-sm-2" id="usuarios_buscar_tipo">
                                <option value="NOMBRE" selected>NOMBRE</option>
                                <option value="DNI">DNI</option>
                            </select>
                            <input class="form-control mr-sm-2" id="usuarios_buscar" type="search" style="width:360px;" placeholder="Buscar Usuarios" aria-label="Search" oninput="user.buscar_usuario($(this).val());">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" onClick="user.buscar_usuario($('#usuarios_buscar').val());"><i class="fas fa-search"></i> Buscar</button>
                        </form>
                    </nav>
                </div>
                <div class="col-sm-3" style="padding:8px 16px;">
                    <button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add" onclick='btn_add("usuarios");'>Añadir <i class="fas fa-plus"></i></button>
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">DNI</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Permisos</th>
                            <th scope="col">HABILITADO</th>
                            <th scope="col">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="load_data_usuarios">
                            
                        </tbody>
                    </table>

                    <div id="load_table_usuarios"></div>

                </div>
            </div>
        </div>

        
        <!-- MODAL ADD -->
        <!-- MODAL ADD -->
        <div class="modal fade bd-example-modal-sm" id="modal-add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="container-fluid modal-body" style="padding:15px;">
                        <div class="row justify-content-center"> 
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add').modal('hide'); user.editURLimg = 0;"><i class="fas fa-lg fa-times"></i></button>
                                <form id="formulario-usuarios" class="formulario-modal" enctype="multipart/form-data">
                                    <h4 style="margin-bottom:18px;">REGISTRAR USUARIO</h4>
                                                                        
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">General</a>
                                            <a class="nav-item nav-link" id="nav-contacto-tab" data-toggle="tab" href="#nav-contacto" role="tab" aria-controls="nav-contacto" aria-selected="false">Contacto</a>   
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
                                                    <label for="inputPRIV" class="col-sm-3 col-form-label">*Privilegios/Cargo</label>
                                                    <div class="col-sm-9">
                                                        <select type="text" class="form-control" id="inputPRIV" name="inputPRIV" placeholder="Apellido Paterno" required>
                                                            <option value="" selected disabled>--Seleccionar--</option>
                                                            <option value="ADMINISTRADOR">Administrador</option>
                                                            <option value="ASESOR">Asesor</option>
                                                            <option value="CAJA">Caja</option>
                                                            <option value="ROOT">Super Admin</option>
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
                                                    <label for="inputUSER" class="col-sm-3 col-form-label">*Usuario</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputUSER" name="inputUSER" placeholder="Usuario de acceso al sistema" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputPASS" class="col-sm-3 col-form-label">*Contraseña</label>
                                                    <div class="col-sm-9">
                                                        <input type="password" class="form-control" id="inputPASS" name="inputPASS" placeholder="Contraseña" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputNAC" class="col-sm-3 col-form-label">Fecha de Nacimiento</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" class="form-control" id="inputNAC" name="inputNAC" placeholder="Fecha de nacimiento">
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
                                                    <label for="inputEMAIL" class="col-sm-3 col-form-label">Correo</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="inputEMAIL" name="inputEMAIL" placeholder="Correo Electrónico">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                 

                                    <div class="w-100" style="height:8px;"></div>
                                    <div class="modal_msg_ajax" id="msg-ajax-result"></div>
                                    
                                    
                                    <button type="submit" class="btn btn-success btn_modals"><i class="far fa-lg fa-save"></i> Guardar</button>
                                    <div class="modal-btn-cont">
                                        
                                    </div>
                                    <button type="button" class="btn btn-warning btn_modals" onclick="$('#modal-add').modal('hide'); user.editURLimg = 0;"><i class="fas fa-lg fa-ban"></i> Cancelar</button>

                                    

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </body>
</html>