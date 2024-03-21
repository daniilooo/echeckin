<?php

include_once(__DIR__ . '/../model/login.php');
include_once(__DIR__ . '/../DAO/DaoLogin.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
    
    if(isset($_POST['cliente'])){
        $cliente = true;
    } else {
        $cliente = false;
    }
    
    if ($cliente) {
        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $login = new Login($login, $senha);

        $daoLogin = new DaoLogin((new Conexao())->conectar());

        if ($daoLogin->login($login)) {
            $daoLogin = new DaoLogin((new Conexao())->conectar());

            session_start();
            $_SESSION['idUsuario'] = $daoLogin->retornarUsuario($login);
            $_SESSION['login'] = true;
            header('Location: ../cliente/index2.php');
            exit;

        } else {
            header('Location: ../cliente/index2.php');
            exit;
        }

    } else {
        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $login = new Login($login, $senha);

        $daoLogin = new DaoLogin((new Conexao())->conectar());

        if ($daoLogin->login($login)) {
            $daoLogin = new DaoLogin((new Conexao())->conectar());           

            session_start();
            $_SESSION['idUsuario'] = $daoLogin->retornarUsuario($login);
            $_SESSION['login'] = true;
            header('Location: ../public/index2.php');
            exit;

        } else {
            header('Location: ../index.php?isLogin=0');
            exit;
        }
    }

}



?>