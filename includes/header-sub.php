

<header>
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <div class="col-sm-7">
                        <h4 class="text-white" style="padding-left:18px; text-shadow:1px 1px 1px black;">MÓDULO ADMINISTRATIVO</h4>
                    </div>
                    <div class="col-sm-5">

                        <div class="btn-group" style=" float:right; top:50%; transform: translateY(-50%);">
                            <button type="button" class="" style="background:none;border:none;outline:none;color:white;font-family:'Verdana';" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php

                                    if(isset($_SESSION['foto']) && $_SESSION['foto']!=null && $_SESSION['foto']!=''){
                                        echo '
                                        <div style="display:block; position:relative; float:right; width:40px; height:40px; margin-left:14px; border-radius:100%; overflow:hidden; transform:scale(1.14);">
                                            <img src="../img/upload/usuarios/'.$_SESSION['foto'].'" width="100%">
                                        </div>'.'
                                        <div style="position:relative;float:right;margin-top:7px;">'.
                                            strtoupper($_SESSION['user']).' ('.ucwords($_SESSION['privilegios']).')
                                        </div>
                                    ';
                                    }else{
                                        echo '
                                        <div style="display:block; position:relative; float:right; width:40px; height:40px; margin-left:14px; border-radius:100%; overflow:hidden; transform:scale(1.14);">
                                            <img src="../img/user.png" width="100%">
                                        </div>'.'
                                        <div style="position:relative;float:right;margin-top:7px;">'.
                                            strtoupper($_SESSION['user']).' ('.ucwords($_SESSION['privilegios']).')
                                        </div>
                                    ';
                                    }
                                    
                                ?>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!--
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>     
                                <div class="dropdown-divider"></div>
                                -->
                                <a class="dropdown-item" href="panel_pass.php" style="text-align: right; margin:6px 0px;">Cambiar Contraseña <i class="fas fa-key"></i></a>
                                <a class="dropdown-item" href="../backend/logout.php" style="text-align: right; margin:6px 0px;">Salir <i class="fas fa-sign-out-alt"></i></a>
                            </div>
                        </div>

                    </div>
                </div>  
            </div>
</header>