<?php

class Checkin{

    private $idCheckin;
    private $fkLocal;
    private $fkUsuario;
    private $dataHora;

    function __construct($idCheckin, $fkLocal, $fkUsuario, $dataHora){
        $this->setIdCheckin($idCheckin);
        $this->setfkLocal($fkLocal);
        $this->setFkUsuario($fkUsuario);
        $this->setDataHora($dataHora);
    }

    function setIdCheckin($idCheckin){
        $this->idCheckin = $idCheckin;
    }

    function setFkLocal($fkLocal){
        $this->fkLocal = $fkLocal;
    }

    function setfkUsuario($fkUsuario){
        $this->fkUsuario = $fkUsuario;
    }

    function setDataHora($dataHora){
        if($dataHora instanceof DateTime){
            $this->dataHora = $dataHora;
        } else {
            $dataHora = (new DateTime())->format('Y-m-d H:i:s');
        }
    }
    
    function getIdCheckin(){
        return $this->idCheckin;
    }

    function getFkLocal(){
        return $this->fkLocal;
    }

    function getFkUsuario(){
        return $this->fkUsuario;
    }

    function getDataHora(){
        return $this->dataHora;
    }

    function __toString(){
        return
        "<br>ID Checkin: ".$this->getIdCheckin().
        "<br>FK Local: ".$this->getFkLocal().
        "<br>FK Usuario: ".$this->getFkUsuario().
        "<br>Data e hora do checkin: ".$this->getDataHora()."<br>";
    }


}

?>