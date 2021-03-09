<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."../intranet.php"); 
    }else{
        require_once("../includes/rutas.php");
    }
    

    if(substr($accesos['configuraciones'],0,1) == 0){
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
		<link rel="shortcut icon" href="../img/favicon/favicon-32x32.png">
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
            require_once("../includes/header.php");
        ?>
        <?php
            require_once("../includes/menus-sub.php");
        ?>


        <br>

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <a onClick="window.location.href='../configuraciones.php';" class="btn btn-secondary" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option2" autocomplete="off"><i class="fas fa-lg fa-arrow-alt-circle-left"></i>
                        </a>
                        <a onClick="window.location.href='../index.php';" class="btn btn-secondary active" style="color:white; cursor:pointer;">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked><i class="fas fa-home"></i> Inicio
                        </a> 
                    </div>
                </div>
            </div>
        </div>

    
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-9" style="padding:4px 0px;">
                    <nav class="navbar navbar-light">
                        <form class="form-inline">
                            <input class="form-control mr-sm-2" type="search" placeholder="Buscar Solicitud" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                        </form>
                    </nav>
                </div>
                <div class="col-sm-3" style="padding:9px 16px;">
                    <button type="button" class="btn btn-block btn-success" style="float:right;" data-toggle="modal" data-target="#modal-add-usuarios" onclick='document.getElementById("formulario-usuarios").reset(); $("#modal-add-usuarios h4").html("Nuevo Usuario"); $("#usuarios-ajax-result").html(""); metodo=1;'>Añadir <i class="fas fa-plus"></i></button>
                </div>
                <div class="w-100"></div>
                <div class="col">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Permisos</th>
                            <th scope="col">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody id="load_data">
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>
                                    <div class="col text-center"> 
                                        <button style="width:110px;" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</button>
                                        <button style="width:110px;" type="button" class="btn btn-danger"><i class="fas fa-times-circle"></i> Eliminar</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>
                                    <div class="col text-center"> 
                                        <button style="width:110px;" type="button" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</button>
                                        <button style="width:110px;" type="button" class="btn btn-danger"><i class="fas fa-times-circle"></i> Eliminar</button>
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
        <div class="modal fade bd-example-modal-sm" id="modal-add-usuarios" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                                                        <div class="container-fluid" style="padding:15px;">
                                                            <div class="row"> 
                                                                <div class="col-md-12">
                                                                    <h4>Nuevo Usuario</h4>
                                                                    <br>
                                                                    <form id="formulario-usuario" enctype="multipart/form-data">
                                                                        <div class="form-row">
                                                                            <div class="form-group col-sm-12">
                                                                                <label for="inputNombreServicio">Nombre*</label>
                                                                                <input type="text" class="form-control" id="inputNombreServicio" name="inputNombreServicio" placeholder="Nombre del Servicio" required>
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label for="inputCategoriaServicio">Categoría*</label>
                                                                                <input type="text" class="form-control" id="inputCategoriaServicio" name="inputCategoriaServicio" placeholder="Categoría del Servicio" required>
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label for="inputDescripcionServicio">Descripción</label>
                                                                                <textarea class="form-control" id="inputDescripcionServicio" name="inputDescripcionServicio" placeholder="Descripcion del Servicio"></textarea>
                                                                            </div>
                                                                            <div class="form-group col-sm-12">
                                                                                <label for="inputURLServicio">Subir Imagen: Max 15M</label><br>
                                                                                <input type="file"  id="inputURLServicio" name="inputURLServicio">  
                                                                            </div>
                                                                            <div class="w-100" style="height:8px;"></div> 
                                                                        </div>

                                                                        <div class="w-100" style="height:8px;"></div>
                                                                        <div id="usuario-ajax-result"></div>
                                                                        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                                                        <button type="button" class="btn btn-secondary btn-block" onclick="$('#modal-add-usuarios').modal('hide'); editURLimg = 0;">Cerrar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                </div>
            </div>
        </div>


    </body>
</html>