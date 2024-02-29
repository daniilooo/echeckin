<?php

class Log{

    private $idLog;
    private $regLog;
    private $dataHora;
    private $idUsuario;
    
    function __construct($idLog, $regLog, $dataHora, $idUsuario){
        $this->setIdLog($idLog);
        $this->setRegLog($regLog);
        $this->setDataHora($dataHora);
        $this->setIdUsuario($idUsuario);
    }
    
    function setIdLog($idLog){
        $this->idLog = $idLog;
    }

    function setRegLog($regLog){
        $this->regLog = $regLog;
    }

    /*function setDataHora($dataHora){
        $objDataHora = new DateTime($dataHora);
        $this->dataHora = $objDataHora;
    }*/

    function setDataHora($dataHora){
        $this->dataHora = $dataHora;
    }

    function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    function getIdLog(){
        return $this->idLog;
    }

    function getRegLog(){
        return $this->regLog;
    }

    function getDataHora(){
        return $this->dataHora;
    }

    function getIdUsuario(){
        return $this->idUsuario;
    }

    function __toString(){        

        if ($this->getDataHora() instanceof DateTime) {
            $dataFormatada = $this->getDataHora()->format('d/m/Y H:m:s');
        } else {
            $dataFormatada = $this->getDataHora();            
        }

        return
        "<br>ID Log: ".$this->getIdLog().
        "<br>Desc log: ".$this->getRegLog().
        "<br>Data e hora do log: ".$dataFormatada.
        "<br>ID do Usuario: ".$this->getIdUsuario()."<br>"; 
    }
}

?>