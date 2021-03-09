<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['cajas'],0,1) == 0){
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
                    <h3><span class="badge badge-info" style="margin-left:120px;">CAJA</span></h3>
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
                    <button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add" onclick='btn_add_caja("CREAR");'>Añadir <i class="fas fa-plus"></i></button>
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Capital</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="load_data_cajas">
                            
                        </tbody>
                    </table>

                    <div id="load_table_cajas"></div>

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
                                                                    <h4>Nueva Caja</h4>
                                                                    <br>
                                                                    <form id="formulario-caja" enctype="multipart/form-data">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-sm-12">
                                                                                <label for="caja_nombre">Nombre*</label>
                                                                                <input type="text" class="form-control" id="caja_nombre" name="caja_nombre" placeholder="Nombre de la Caja" required>
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label for="caja_capital">Capital Inicial*</label>
                                                                                <input type="number" step="any" class="form-control" id="caja_capital" name="caja_capital" placeholder="Monto inicial de la caja" required>
                                                                            </div>

                                                                            <div class="form-group col-sm-12">
                                                                                <label for="caja_autor">Autorizar a*</label>
                                                                                <input list="cajeros_resp" type="text" class="form-control" id="caja_autor" name="caja_autor" placeholder="Nombre del encargado de la caja" autocomplete="off" onKeyUp="caja.buscarUserCajaResp(this.value);" required>
                                                                                <input type="hidden" class="form-control" id="caja_autor-hidden" name="caja_autor-hidden">
                                                                                <datalist id="cajeros_resp">
                                                        
                                                                                </datalist>
                                                                            </div>
                                                                        </div>
                                                                     

                                                                        <div class="w-100" style="height:8px;"></div>
                                                                        <div id="msg-ajax-result"></div>
                                                                        <button type="submit" class="btn btn-success btn-block btn_modals"><i class="far fa-lg fa-save"></i> Registrar</button>
                                                                        <div class="modal-btn-cont">
                                        
                                                                        </div>
                                                                        <button type="button" class="btn btn-warning btn-block btn_modals" onclick="$('#modal-add').modal('hide');"><i class="fas fa-lg fa-ban"></i> Cerrar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                </div>
            </div>
        </div>


        <!-- MODAL ADD EDIT -->
        <!-- MODAL ADD EDIT -->
        <div class="modal fade bd-example-modal-sm" id="modal-add-edt" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                                                        <div class="container-fluid" style="padding:15px;">
                                                            <div class="row"> 
                                                                <div class="col-md-12">
                                                                    <button type="button" class="btn btn-danger" style="position:absolute;right:13px;padding:6px 15px;" onclick="$('#modal-add-edt').modal('hide');"><i class="fas fa-lg fa-times"></i></button>
                                                                    <h4>Modificar Caja</h4>
                                                                    <br>
                                                                    <form id="formulario-caja-edt" enctype="multipart/form-data">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-sm-12">
                                                                                <label for="caja_nombre-edt">Nombre*</label>
                                                                                <input type="text" class="form-control" id="caja_nombre-edt" name="caja_nombre-edt" placeholder="Nombre de la Caja" required>
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label for="caja_capital-edt">Capital*</label>
                                                                                <input type="number" class="form-control" id="caja_capital-edt" name="caja_capital-edt" placeholder="Monto inicial de la caja" required readonly>
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label for="caja_capital-edt">Billetaje Registrado*</label>
                                                                                <select class="form-control" id="caja_hab_billetaje" name="caja_hab_billetaje" placeholder="Billetaje Habilitado" required>
                                                                                    <option value="SI" selected>SI</option>
                                                                                    <option value="NO">NO</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="form-group col-sm-12">
                                                                                <label for="caja_autor-edt">Autorizar a*</label>
                                                                                <input list="cajeros_resp-edt" type="text" class="form-control" id="caja_autor-edt" name="caja_autor-edt" placeholder="Nombre del encargado de la caja" autocomplete="off" onKeyUp="caja.buscarUserCajaRespEdit(this.value);" required>
                                                                                <input type="hidden" class="form-control" id="caja_autor-hidden-edt" name="caja_autor-hidden-edt">
                                                                                <datalist id="cajeros_resp-edt">
                                                        
                                                                                </datalist>
                                                                            </div>

                                                                        </div>

                                                                        <div class="w-100" style="height:8px;"></div>
                                                                        <div id="msg-ajax-result-edt"></div>
                                                                        <button type="submit" class="btn btn-success btn-block btn_modals"><i class="far fa-lg fa-save"></i> Actualizar</button>
                                                                        <div class="modal-btn-cont-edt">
                                        
                                                                        </div>
                                                                        <button type="button" class="btn btn-warning btn-block btn_modals" onclick="$('#modal-add-edt').modal('hide');"><i class="fas fa-lg fa-ban"></i> Cerrar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                </div>
            </div>
        </div>


    </body>
</html>