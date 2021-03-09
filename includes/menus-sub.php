<nav class="menu_nav">
            <div class="container-fluid">
                <div class="row">
                    <div class="col" style="background: white;">
                        <center><p style="margin:8px 0px;">ADMINISTRACIÓN</p></center>
                    </div>
                    
                    <?php
                        if($menu["usuarios"]){
                            echo '
                                <a href="../usuarios.php" class="col-12">
                                    <p><i class="fas  fa-user-tie"></i> Usuarios</p>
                                </a>
                            ';
                        }
                        if($menu["clientes"]){
                            echo '
                                <a href="../clientes.php" class="col-12">
                                    <p><i class="fas  fa-users"></i> Clientes</p>
                                </a>
                            ';
                        }
                        if($menu["creditos"]){
                            echo '
                                <a href="../creditos.php" class="col-12">
                                    <p><i class="fas fa-hand-holding-usd"></i> Creditos</p>
                                </a>
                            ';
                        }
                        if($menu["cajas"]){
                            echo '
                                <a href="../caja.php" class="col-12">
                                    <p><i class="fas fa-coins"></i> Finanzas</p>
                                </a>
                            ';
                        }
                        if($menu["ahorros"]){
                            echo '
                                <a href="../ahorros.php" class="col-12">
                                    <p><i class="fas fa-piggy-bank"></i> Ahorros</p>
                                </a>
                            ';
                        }
                    
                    
                        if($menu["reportes"]){
                            echo '
                                <a href="../reportes.php" class="col-12">
                                    <p><i class="fas  fa-clipboard-list"></i> Reportes</p>
                                </a>
                            ';
                        }
                    ?>

                </div>
            </div>
</nav>

