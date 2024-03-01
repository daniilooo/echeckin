<?php

class Erro
{
    private $idErro;
    private $erro;
    private $local;
    private $data;
    private $usuario;

    function __construct($idErro, $erro, $local, $data, $usuario)
    {
        $this->setIdErro($idErro);
        $this->setErro($erro);
        $this->setLocal($local);
        $this->setData($data);
        $this->setUsuario($usuario);
    }

    function setIdErro($idErro)
    {
        $this->idErro = $idErro;
    }

    function setErro($erro)
    {
        $this->erro = $erro;
    }

    function setLocal($local)
    {
        $this->local = $local;
    }

    function setData($data)
    {
        $this->data = new DateTime($data);
    }

    function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    function getIdErro()
    {
        return $this->idErro;
    }

    function getErro()
    {
        return $this->erro;
    }

    function getLocal()
    {
        return $this->local;
    }

    function getData()
    {
        $dataHora = $this->data;
        return $dataHora->format('d/m/Y H:i:s');
    }

    function getUsuario()
    {
        return $this->usuario;
    }

    function __toString()
    {
        

        return "<br>
                ID erro: " . $this->getIdErro() . "<br>
                Erro: " . $this->getErro() . "<br>
                Local: " . $this->getLocal() . "<br>
                Data e hora da ocorrência: " . $this->getData() . "<br>
                Usuario: " . $this->getUsuario();
    }

}

?>