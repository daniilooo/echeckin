<?php

include_once(__DIR__ . '/../DAO/DaoLog.php');
include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoUsuario.php');

session_start();
$sessionStatus = session_status();

if(!isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}

if($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']){
    $idUsuario = $_SESSION['idUsuario'];

    $conexao = new Conexao();    
    
    if(isset($_GET['idUsuario'])){
        
        $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuario);       
        

        if($daoUsuario->resetarSenha($_GET['idUsuario']) > 0){
            $log = new Log(null, "Senha do usuário resetada.\nID do usuario: ".$_GET['idUsuario'], (new DateTime())->format('Y-m-d H:i:s'), $idUsuario);
            $daoLog = new DaoLog($conexao->conectar(), $idUsuario);
            
            if($daoLog->inserirLog($log) > 0){
                header('Location: ../public/gerenciamentoUsuarios.php?resSucces=1');
                exit;
            } else {
                header('Location: ../public/gerenciamentoUsuarios.php?resSucces=0');
                exit;
            }            
        }
    }
}

?>