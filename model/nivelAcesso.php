<?php

class NivelAcesso{
    private $idNivelAcesso;
    private $descNivelAcesso;
    private $privilegios = [];
    private $statusNivelAcesso;

    function __construct($idNivelAcesso, $descNivelAcesso, $status){
        $this->setIdNivelAcesso($idNivelAcesso);
        $this->setDescNivelAcesso($descNivelAcesso);
        $this->setStatusNivelAcesso($status);
    }

    function setIdNivelAcesso($idNivelAcesso){
        $this->idNivelAcesso = $idNivelAcesso;
    }

    function setDescNivelAcesso($descNivelAcesso){
        $this->descNivelAcesso = $descNivelAcesso;
    }

    function setPrivilegios($listaDePrivilegios){
        $this->privilegios = $listaDePrivilegios;
    }

    function setStatusNivelAcesso($status){
        $this->statusNivelAcesso = $status;
    }

    function getIdNivelAcesso(){
        return $this->idNivelAcesso;
    }

    function getDescNivelAcesso(){
        return $this->descNivelAcesso;
    }

    function getPrivilegios(){
        return $this->privilegios;
    }

    function getStatusNivelAcesso(){
        return $this->statusNivelAcesso;
    }

    function __toString(){
        return
        "<br>ID nivel de acesso: ".$this->getIdNivelAcesso().
        "<br>Desc nivel acesso: ".$this->getDescNivelAcesso().
        "<br>Status do nivel de acesso: ".$this->getStatusNivelAcesso()."<br>";
    }


}

?>