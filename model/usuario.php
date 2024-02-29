<?php

class Usuario{

    private $idUsuario;
    private $nome;
    private $matricula;
    private $empresa;
    private $cargo;
    private $login;
    private $senha;
    private $statusUsuario;

    function __construct($idUsuario, $nome, $matricula, $empresa, $cargo, $login, $senha, $statusUsuario){
        $this->setIdUsuario($idUsuario);
        $this->setNome($nome);
        $this->setMatricula($matricula);
        $this->setEmpresa($empresa);
        $this->setCargo($cargo);
        $this->setLogin($login);
        $this->setSenha($senha);
        $this->setStatusUsuario($statusUsuario);
    }

    function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    function setNome($nome){
        $this->nome = $nome;
    }

    function setMatricula($matricula){
        $this->matricula = $matricula;
    }

    function setEmpresa($empresa){
        $this->empresa = $empresa;
    }

    function setCargo($cargo){
        $this->cargo = $cargo;
    }

    function setLogin($login){
        $this->login = $login;
    }

    function setSenha($senha){
        $hashPassword = password_hash($senha, PASSWORD_DEFAULT);
        $this->senha = $hashPassword;
    }

    function setStatusUsuario($status){
        $this->statusUsuario = $status;
    }

    function getIdUsuario(){
        return $this->idUsuario;
    }

    function getNome(){
        return $this->nome;
    }

    function getMatricula(){
        return $this->matricula;
    }

    function getEmpresa(){
        return $this->empresa;
    }

    function getCargo(){
        return $this->cargo;
    }

    function getLogin(){
        return $this->login;
    } 

    function getSenha(){
        return $this->senha;
    }

    function getStatusUsuario(){
        return $this->statusUsuario;
    }
    
    function __toString(){
        return 
        "<br>ID Usuario: ".$this->getIdUsuario().
        "<br>Nome: ".$this->getNome().
        "<br>Matricula: ".$this->getMatricula().
        "<br>FK empresa: ".$this->getEmpresa().
        "<br>FK cargo: ".$this->getCargo().
        "<br>Login: ".$this->getLogin().
        "<br>Hash da senha: ".$this->getSenha().
        "<br>Flag de status do usuario: ".$this->getStatusUsuario()."<br>"; 
    }
}

?>