<?php


session_start();

$sessionStatus = session_status();

if ($sessionStatus == PHP_SESSION_ACTIVE) {
    
    /**
     * 
     * implementar o uso de sessão para salvar o checkin.
     */

}


if(isset($_GET['idLocal'])){

    echo "<h1>Checkin realizado com sucesso.</h1>";

}

?>