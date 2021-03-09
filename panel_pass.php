<?php


    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: '."intranet.php"); 
    }
    


?>

<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Panel de administración - Password</title>
		<link rel="shortcut icon" href="img/favicon/favicon-32x32.png">
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



        <br>



        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a class="btn btn-warning" href="index.php" role="button"><i class="fas fa-arrow-left"></i> Volver al Panel</a>
                </div>
            </div>

            <br><br>

            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="card text-center">
                        <div class="card-header">
                            <h5>CAMBIAR CONTRASEÑA</h5>
                        </div>
                        <div class="card-body">     
                            <form id="formulario-pass" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label for="inputPass01">Nueva Contraseña*</label>
                                        <input type="password" class="form-control" id="inputPass01" name="inputPass01" placeholder="Escriba la nueva contraseña" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="inputPass02">Repetir la Nueva Contraseña*</label>
                                        <input type="password" class="form-control" id="inputPass02" name="inputPass02" placeholder="Repite la contraseña" required>
                                    </div>
                                    <div class="w-100" style="height:8px;"></div>       
                                </div>
                                <div class="w-100" style="height:8px;"></div>
                                <button type="submit" class="btn btn-primary btn-block" id="btnpasssave" data-id="<?php echo $_SESSION['id'];?>"><i class="far fa-save"></i> Guardar</button>
                                <button type="reset" class="btn btn-secondary btn-block"><i class="fas fa-archive"></i> Reset</button>             
                            </form>
                        </div>
                        <div class="card-footer text-muted">
                            <div id="pass-ajax-result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <br><br><br><br>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <p class="col-6 footer_copy">Copyright © 2019 , VILCON SAC</p>
                <p class="col-6 footer_autor">WEB CREADA POR <a href="http://www.peru100.com/" target="blank">Perú 100</a></p>
            </div>
        </div>




    </body>
</html>