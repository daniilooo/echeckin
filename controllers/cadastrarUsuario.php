<?php

include_once(__DIR__ . '/../model/usuario.php');
include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');

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

    
    $daoUsuario = new DaoUsuario((new Conexao())->conectar(), 1);

    $idUsuarioCadastrado = $daoUsuario->inserirUsuario($usuario);

    if($idUsuarioCadastrado > 0){
        $log = new Log(null, "Novo usuário cadastrado.\nID do usuário cadastrado: ".$idUsuarioCadastrado, (new DateTime())->format('Y-m-d H:i:s'), 1);
        $daoLog = new DaoLog((new Conexao())->conectar(), 1);
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

?>