<?php

include_once(__DIR__ . '/../database/conexao.php');
include_once(__DIR__ . '/../model/erro.php');

class DaoErro
{
    private $TBL_ERRO = "TBL_ERRO";
    private $conexao;

    function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    function inserirErro(Erro $erroObj)
    {        
        $descricaoErro = $erroObj->getErro();
        $local = $erroObj->getLocal();
        $data = $erroObj->getData(); 

        $usuario = $erroObj->getUsuario();

        $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_ERRO} (DESC_ERRO, LOCAL, DATA, FK_USUARIO) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $descricaoErro, $local, $data, $usuario);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



    function gerarListaErros()
    {
        $listaErros = [];

        $stmt = $this->conexao->prepare("SELECT * FROM {$this->TBL_ERRO} ORDER By ID_ERRO desc LIMIT 10");
        $stmt->execute();

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $erro = new Erro($row['ID_ERRO'], $row['DESC_ERRO'], $row['LOCAL'], $row['DATA'], $row['FK_USUARIO']);
            $listaErros[] = $erro;
        }

        return $listaErros;
    }
}


?>