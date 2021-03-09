<?php
    date_default_timezone_set("America/Lima");


    

    $fecha = $_GET['fecha'];
    $frecuencia = $_GET['frecuencia'];
    $cuotas = $_GET['cuotas'];
    $tiempoContado = strtotime($fecha);


    $json[] = array(
        "cuota" => date('d-m-Y',$tiempoContado)
    );


    function esFestivo($time) {
        global $dias_saltados;
        global $dias_festivos;

        $w = date("w",$time); // dia de la semana en formato 0-6
        if(in_array($w, $dias_saltados)) return true;
        $j = date("j",$time); // dia en formato 1 - 31
        $n = date("n",$time); // mes en formato 1 - 12
        $y = date("Y",$time); // año en formato XXXX
        if(isset($dias_festivos[$y]) && isset($dias_festivos[$y][$n]) && in_array($j,$dias_festivos[$y][$n])) return true;

        return false;
    }


    for($i = 0; $i < $cuotas-1; $i++){

        // Guardamos en una variable los dias festivos en varios arrays con formato
        // $dias_festivos[año][mes] = [dias festivos];
        $dias_festivos = array(
            "2019"=>array(12 => [24,25]),
            "2020"=>array(1 => [1]),
        );

        if($frecuencia==1){
            $dias_saltados = array(0); // 0: domingo, 1: lunes... 6:sabado
        }else{
            $dias_saltados = array(); // 0: domingo, 1: lunes... 6:sabado
        }
        



        // dias a sumar
        $dias = $dias_origin = $frecuencia;

        // dias que el programa ha contado
        $dias_contados = 0;

        // timestamp actual
        //$time = time();
        $time = $tiempoContado;
        
        // duracion (en segundos) que tiene un día
        $dia_time = 3600*24; //3600 segundos en una hora * 24 horas que tiene un dia.


        while($dias != 0) {
            $dias_contados++;
            $tiempoContado = $time+($dia_time*$dias_contados); // Sacamos el timestamp en la que estamos ahora mismo comprobando
            
            if(esFestivo($tiempoContado) == false){
                $dias--;
            }else{
                if($frecuencia!=1){
                    $dias--;
                } 
            }

        }

        /*
        echo "El programa ha recorrido ".$dias_contados." (ha saltado ".($dias_contados-$dias_origin).") hasta llegar la fecha que deseabas:".PHP_EOL
            .date("D, d/m/Y",$tiempoContado);
        echo PHP_EOL;
        */

        $tiempoContadoRES = $tiempoContado;

        while(esFestivo($tiempoContadoRES)) {
            $tiempoContadoRES = strtotime ( '+1 day' , ($tiempoContadoRES)) ;  
        }

        
        
        $json[] = array(
            "cuota" => date('d-m-Y',$tiempoContadoRES),
        );


    }


    //date('d-m-Y',$tiempoContado)


    //echo date('d-m-Y',$mod_date);
    echo json_encode($json);



?>
