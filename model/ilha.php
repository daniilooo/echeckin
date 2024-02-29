<?php

class Ilha{
    private $idIlha;
    private $idEmpresa;
    private $descIlha;
    private $statusIlha;

    function __construct($idIlha, $idEmpresa, $descIlha, $statusilha){
        $this->setIdIlha($idIlha);
        $this->setIdEmpresa($idEmpresa);
        $this->setDescIlha($descIlha);
        $this->setStatusIlha($statusilha);
    }

    function setIdIlha($idIlha){
        $this->idIlha = $idIlha;
    }

    function setIdEmpresa($idEmpresa){
        $this->idEmpresa = $idEmpresa;
    }

    function setDescIlha($descIlha){
        $this->descIlha = $descIlha;
    }

    function setStatusIlha($statusIlha){
        $this->statusIlha = $statusIlha;
    }

    function getIdIlha(){
        return $this->idIlha;
    }

    function getIdEmpresa(){
        return $this->idEmpresa;
    }

    function getDescIlha(){
        return $this->descIlha;
    }

    function getStatusIlha(){
        return $this->statusIlha;
    }

    function __toString(){
        return
        "<br>ID ilha: ".$this->getIdIlha().
        "<br>ID empresa: ".$this->getIdEMpresa().
        "<br>Descrição empresa: ".$this->getDescIlha().
        "<br>Status empresa: ".$this->getStatusIlha()."<br>";
    }
}

?>