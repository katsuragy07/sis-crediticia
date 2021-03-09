<?php
    $menu;
    $accesos;
    $privilegios = $_SESSION['privilegios'];


    switch($privilegios){
        case 'ROOT':    $menu = ["usuarios"=>1,"clientes"=>1,"creditos"=>1,"ahorros"=>1,"cajas"=>1,"configuraciones"=>1,"reportes"=>1];
                        $accesos = [
                            "usuarios" => '111',
                            "clientes" => '111',
                            "creditos" => '11',
                            "ahorros" => '1111',
                            "cajas"    => '111111',
                            "configuraciones" => '1',
                            "reportes"=> '11111'
                        ];
                        break;


        case 'ADMINISTRADOR':   $menu = ["usuarios"=>0,"clientes"=>1,"creditos"=>1,"ahorros"=>1,"cajas"=>1,"configuraciones"=>1,"reportes"=>1];
                        $accesos = [
                            "usuarios" => '000',
                            "clientes" => '111',
                            "creditos" => '01',
                            "ahorros" => '1111',
                            "cajas"    => '100110',
                            "configuraciones" => '1',
                            "reportes"=> '11111'
                        ];
                        break;


        case 'ASESOR':  $menu = ["usuarios"=>0,"clientes"=>1,"creditos"=>1,"ahorros"=>0,"cajas"=>0,"configuraciones"=>0,"reportes"=>1];
                        $accesos = [
                            "usuarios" => '000',
                            "clientes" => '111',
                            "creditos" => '100',
                            "ahorros" => '0000',
                            "cajas"    => '000000',
                            "configuraciones" => '0',
                            "reportes"=> '00101'
                        ];
                        break;


        case 'CAJA':    $menu = ["usuarios"=>0,"clientes"=>0,"creditos"=>0,"ahorros"=>1,"cajas"=>1,"configuraciones"=>0,"reportes"=>1];
                        $accesos = [
                            "usuarios" => '000',
                            "clientes" => '000',
                            "creditos" => '00',
                            "ahorros" => '1111',
                            "cajas"    => '011111',
                            "configuraciones" => '0',
                            "reportes"=> '11010'
                        ];
                        break;

        default:    
                    session_destroy();
                    header('Location: '."intranet.php");
                    break;
    }




?>
