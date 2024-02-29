<?php

class Local{

    private $idLocal;
    private $fkEmpresa;
    private $fkTipoLocal;
    private $descLocal;
    private $statusLocal;

    function __construct($idLocal, $fkEmpresa, $fkTipoLocal, $descLocal, $statusLocal){
        $this->setIdLocal($idLocal);
        $this->setFkEmpresa($fkEmpresa);
        $this->setFkTipoLocal($fkTipoLocal);
        $this->setDescLocal($descLocal);
        $this->setStatusLocal($statusLocal);
    }

    function setIdLocal($idLocal){
        $this->idLocal = $idLocal;
    }

    function setFkEmpresa($fkEmpresa){
        $this->fkEmpresa = $fkEmpresa;
    }

    function setFkTipoLocal($fkTipoLocal){
        $this->fkTipoLocal = $fkTipoLocal;
    }

    function setDescLocal($descLocal){
        $this->descLocal = $descLocal;
    }

    function setStatusLocal($statusLocal){
        $this->statusLocal = $statusLocal;
    }

    function getIdLocal(){
        return $this->idLocal;
    }

    function getFkEmpresa(){
        return $this->fkEmpresa;
    }

    function getFkTipoLocal(){
        return $this->fkTipoLocal;
    }

    function getDescLocal(){
        return $this->descLocal;
    }

    function getStatusLocal(){
        return $this->statusLocal;
    }

    function __toString(){
        return
        "<br>ID do Local: ".$this->getIdLocal().
        "<br>FK Empresa: ".$this->getFkEmpresa().
        "<br>FK tipo do local: ".$this->getFkTipoLocal().
        "<br>Status do local: ".$this->getStatusLocal()."<br>";
    }

}

?>