<?php

class Cargo{

    public $idCargo;
    public $descricaoCargo;
    public $statusCargo;
    public $nivelDeAcesso;

    function __construct($idCargo, $descricaoCargo, $statusCargo, $nivelAcesso){
        $this->idCargo = $idCargo;
        $this->descricaoCargo = $descricaoCargo;
        $this->statusCargo = $statusCargo;
        $this->nivelDeAcesso = $nivelAcesso;
    }

}

?>