<?php
    date_default_timezone_set("America/Lima");


    

    $json[] = array(
        "fecha" => date('Y-m-d'),
        "hora" => date('H:i:s')
    );



    //echo date('d-m-Y',$mod_date);
    echo json_encode($json);


?>
