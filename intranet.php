<?php
    session_start();
    if(isset($_SESSION['user'])){
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
        <link rel="stylesheet" href="css/login.css">
		<script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/panel.js"></script>
        <script src="js/popper.js"></script>
	</head>
    <body>
        <div class="container">
            <div class="card card-container">
                <img id="profile-img" class="profile-img-card" src="img/logo.png" />

                <?php 
                    if(empty($_GET)){
                        echo '<p id="profile-name" class="profile-name-card">Ingrese credenciales</p>';
                    }
                    if(isset($_GET['user'])){
                        echo '<div class="alert alert-danger" role="alert" style="margin-bottom: 3px;">
                                Usuario Incorrecto!
                            </div>';
                    }
                    if(isset($_GET['pass'])){
                        echo '<div class="alert alert-warning" role="alert"  style="margin-bottom: 3px;">
                                Contraseña Incorrecta!
                            </div>';
                    }
                ?>
                
                <form method="post" accept-charset="utf-8" action="backend/val_login.php" name="loginform" autocomplete="off" role="form" class="form-signin">
                    <span id="reauth-email" class="reauth-email"></span>
                    USUARIO<input class="form-control" placeholder="Usuario" name="user_name" type="text" value="" autofocus="" required>
                    CONTRASEÑA<input class="form-control" placeholder="Contraseña" name="user_password" type="password" value="" autocomplete="off" required>
                    <button type="submit" class="btn btn-lg btn-success btn-block btn-signin" name="login" id="submit">Iniciar Sesión</button>
                </form><!-- /form -->
            </div><!-- /card-container -->
        </div><!-- /container -->

        <br>

        <!--
        <div class="container">
            <div class="row">
                <p class="col-6 footer_copy">Copyright © 2019 , VILCON SAC</p>
                <p class="col-6 footer_autor">WEB CREADA POR <a href="http://www.peru100.com/" target="blank">Perú 100</a></p>
            </div>
        </div>
        -->

    </body>
</html>