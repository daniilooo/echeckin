<?php

class NivelAcesso{
    private $idNivelAcesso;
    private $descNivelAcesso;
    private $privilegios = [];

    function __construct($idNivelAcesso, $descNivelAcesso){
        $this->setIdNivelAcesso($idNivelAcesso);
        $this->setDescNivelAcesso($descNivelAcesso);
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

    function getIdNivelAcesso(){
        return $this->idNivelAcesso;
    }

    function getDescNivelAcesso(){
        return $this->descNivelAcesso;
    }

    function getPrivilegios(){
        return $this->privilegios;
    }

    function __toString(){
        return
        "<br>ID nivel de acesso: ".$this->getIdNivelAcesso().
        "<br>Desc nivel acesso: ".$this->getDescNivelAcesso()."<br>";
    }


}

?>