<?php

include_once(__DIR__ . '/../model/login.php');
include_once(__DIR__ . '/../DAO/DaoLogin.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $login = new Login($login, $senha);

    $daoLogin = new DaoLogin((new Conexao())->conectar());
    
    if($daoLogin->login($login)){    
        $daoLogin = new DaoLogin((new Conexao())->conectar());

        session_start();
        $_SESSION['idUsuario'] = $daoLogin->retornarUsuario($login);
        header('Location: ../public/index2.php?isLogin=0');
        
        exit;
    } else {
        header('Location: ../index.php?isLogin=0');
        exit;
    }

}

?>