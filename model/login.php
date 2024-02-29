<?php

class Login{

    private $login;
    private $senha;

    function __construct($login, $senha){
        $this->setLogin($login);
        $this->setSenha($senha);
    }

    function setLogin($login){
        $this->login = $login;
    }

    function setSenha($senha){
        $this->senha = $senha;
    }

    function getLogin(){
        return $this->login;
    }

    function getSenha(){
        return $this->senha;
    }

    function __toString(){
        return
        "<br>Login: ".$this->getLogin().
        "<br>Senha: ".$this->getSenha()."<br>";
    }
}

?>