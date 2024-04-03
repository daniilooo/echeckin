<?php

class Justificativa{
    private $idJustificativa;
    private $idUsuario;
    private $idLocal;
    private $justificativa;
    private $dataHora;
    private $evidencia;

    function __construct($idJustificativa, $idUsuario, $idLocal, $justificativa, $dataHora, $evidencia){
        $this->setIdJustificativa($idJustificativa);
        $this->setIdUsuario($idUsuario);
        $this->setIdLocal($idLocal);
        $this->setJustificativa($justificativa);
        $this->setDataHora($dataHora);
        $this->setEvidencia($evidencia);
    }

    function setIdJustificativa($idJustificativa){
        $this->idJustificativa = $idJustificativa;
    }

    function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    function setIdLocal($idLocal){
        $this->idLocal = $idLocal;
    }

    function setJustificativa($justificativa){
        $this->justificativa = $justificativa;
    }

    function setDataHora($dataHora){
        $this->dataHora = $dataHora;
    }

    function setEvidencia($evidencia){
        $this->evidencia = $evidencia;
    }

    function getIdJustificativa(){
        return $this->idJustificativa;
    }

    function getIdUsuario(){
        return $this->idUsuario;
    }

    function getIdLocal(){
        return $this->idLocal;
    }

    function getJustificativa(){
        return $this->justificativa;
    }

    function getDataHora(){
        return $this->dataHora;
    }

    function getEvidencia(){
        return $this->evidencia;
    }

    function __toString(){
        
        $data = (new DateTime($this->getDataHora()))->format('d/m/Y');
        $hora = (new DateTime($this->getDataHora()))->format('H:i:s');

        return
        "<br>ID da Justificativa: ".$this->getIdJustificativa().
        "<br>ID do Usuário: ".$this->getIdUsuario().
        "<br>ID Local: ".$this->getIdLocal().
        "<br>Justificativa: ".$this->getJustificativa().
        "<br>Data: ".$data.
        "<br>Hora: ".$hora."<br>";
    }
}

?>