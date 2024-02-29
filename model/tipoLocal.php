<?php

class TipoLocal{    
    public $idTipoLocal;
    public $descLocal;
    public $statusLocal;

    function __construct($idTipoLocal, $descLocal, $statusLocal){
        $this->idTipoLocal = $idTipoLocal;
        $this->descLocal = $descLocal;
        $this->statusLocal = $statusLocal;
    }
}

?>