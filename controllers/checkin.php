<?php

include_once(__DIR__ . '/../DAO/DaoCheckin.php');
include_once(__DIR__ . '/../DAO/DaoUsuario.php');

session_start();
$sessionStatus = session_status();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

if ($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']) {
    
    $idUsuario = $_SESSION['idUsuario'];
    $conexao = new Conexao();
    $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuario);

    if(isset($_GET['idLocal'])){
        $idLocal = $_GET['idLocal'];
        $checkin = new Checkin(null, $idLocal, $idUsuario, (new DateTime())->format('Y-m-d H:i:s'));
        $daoCheckin = new DaoCheckin($conexao->conectar(), $idUsuario);

        $idCheckin = $daoCheckin->inserirCheckin($checkin);

        if($idCheckin > 0){
            echo "<script>alert('Checkin realizado com sucesso.')</script>";
            header("Location: ../public/realizarCheckin.php");
            exit;
        } else {
            echo "<script>alert('Não foi possível realizar o checkin, contate o administrador do sistema.')</script>";
            header("Location: ../public/realizarCheckin.php");
            exit;
        }
    }       

} else {
    echo "<script>alert('Para utilizar o sistema eCheckin é necessário fazer login.');</script>";
    exit;
}


?>