<?php

include_once(__DIR__ . '/../DAO/DaoLocal.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');
include_once(__DIR__ . '/../DAO/DaoErro.php');

session_start();
$sessionStatus = session_status();

if(!isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}

if($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']){

    $idUsuario = $_SESSION['idUsuario'];
    $conexao = new Conexao();
    $daoLocal = new DaoLocal($conexao->conectar(), $idUsuario);

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $idLocal = $_POST['idLocal'];
        $empresa = $_POST['empresa'];
        $tipoLocal = $_POST['tipoLocal'];
        $descLocal = $_POST['descLocal'];
        $status = $_POST['status'];

        $local = new Local($idLocal, $empresa, $tipoLocal, $descLocal, $status);

        echo $local;

        if($daoLocal->alterarLocal($local) > 0){
            $log = new Log(null, "Alteração de local.\nID do local alterado: ".$idLocal, (new DateTime())->format('Y-m-d H:i:s'), $idUsuario);
            $daoLog = new DaoLog($conexao->conectar(), $idUsuario);
            
            if($daoLog->inserirLog($log) > 0){
                header("Location: ../public/gerenciarLocais.php?altSucces=1");
                exit;
            } else {
                header("Location: ../public/gerenciarLocais.php?altSucces=0");
                exit;
            }
        }
        
    }

}

?>