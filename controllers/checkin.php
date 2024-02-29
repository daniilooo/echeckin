<?php


session_start();

$sessionStatus = session_status();

if ($sessionStatus == PHP_SESSION_DISABLED) {
    echo "Sessões estão desabilitadas.";
} elseif ($sessionStatus == PHP_SESSION_NONE) {
    echo "Sessão está habilitada, mas nenhuma sessão existe.";
} elseif ($sessionStatus == PHP_SESSION_ACTIVE) {
    echo "Sessão está habilitada e uma sessão existe.";
}


if(isset($_GET['idLocal'])){

    echo "<h1>Checkin realizado com sucesso.</h1>";

}

?>