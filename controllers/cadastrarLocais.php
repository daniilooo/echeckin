<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoLocal.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');


session_start();
$sessionStatus = session_status();

if(!isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}

if($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']){
    $idUsuario = $_SESSION['idUsuario'];

    $conexao = new Conexao();
    $daoLocal = new DaoLocal($conexao->conectar(), $idUsuario);
    $daoLog = new DaoLog($conexao->conectar(), $idUsuario);
    $daoErro = new DaoErro($conexao->conectar());


    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $empresa = $_POST['empresa'];
        $tipoLocal = $_POST['tipoLocal'];
        $descLocal = $_POST['descLocal'];
        $status = $_POST['status'];
    
        $local = new Local(null, $empresa, $tipoLocal, $descLocal, $status);
        $idLocal = $daoLocal->inserirLocal($local);

        if($idLocal > 0){
            $log = new Log(null, "Novo local cadastrado.\nID do novo local: ".$idLocal, (new DateTime())->format('Y-m-d H:i:s'), $idUsuario);
            $idLog = $daoLog->inserirLog($log);

            if($idLog > 0){
                header("Location: ../public/gerenciarLocais.php?addSucces=1");
                exit;
            } else {
                header("Location: ../public/gerenciarLocais.php?addSucces=0");
            }

        }
        
        
        
    }

}



?>