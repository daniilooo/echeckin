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

    

}

?>