<?php

include_once(__DIR__ . '/../model/usuario.php');
include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');

session_start();
$sessionStatus = session_status();

if(!isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}

if($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']){
    $idUsuario = $_SESSION['idUsuario'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $nome = $_POST['nome'];
        $matricula = $_POST['matricula'];
        $empresa = $_POST['empresa'];
        $cargo = $_POST['cargo'];
        $login = $_POST['login'];
        $senha = $_POST['senha'];    
        $foto = $_POST['foto'];
        $status = $_POST['status'];
    
        $usuario = new Usuario(null, $nome, $matricula, $empresa, $cargo, $login, $senha, $status);    
    
        
        $daoUsuario = new DaoUsuario((new Conexao())->conectar(), $idUsuario);
    
        $idUsuarioCadastrado = $daoUsuario->inserirUsuario($usuario);
    
        if($idUsuarioCadastrado > 0){
            $log = new Log(null, "Novo usuário cadastrado.\nID do usuário cadastrado: ".$idUsuarioCadastrado, (new DateTime())->format('Y-m-d H:i:s'), $idUsuario);
            $daoLog = new DaoLog((new Conexao())->conectar(), $idUsuario);
            $idLog = $daoLog->inserirLog($log);
        }
    
        if($idUsuarioCadastrado > 0 && $idLog > 0){
            header('Location: ../public/gerenciamentoUsuarios.php?addSucces=1');
            exit;
        } else {
            header('Location: ../public/gerenciamentoUsuarios.php?addSucces=0');
            exit;
        }

    }

} else {
    echo "<script>alert('Faça login no sistema.')</script>";
    header('Location: ../index.php');    
}


?>