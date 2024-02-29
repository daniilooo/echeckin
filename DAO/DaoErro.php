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
        $idErro = 0;
        $descricaoErro = $erroObj->getErro();
        $local = $erroObj->getLocal();

        // Formatando o objeto DateTime como uma string
        $data = $erroObj->getData()->format('Y-m-d H:i:s');

        $usuario = $erroObj->getUsuario();

        $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_ERRO} (DESC_ERRO, LOCAL, DATA, FK_USUARIO) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $descricaoErro, $local, $data, $usuario);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    function gerarListaDeErros()
    {
        $erros = [];
        $idErro = null;
        $descErro = null;
        $localErro = null;
        $dataHora = null;
        $usuario = null;

        $stmt = $this->conexao->prepare("SELECT * FROM {$this->TBL_ERRO} order by ID_ERRO DESC");
        $stmt->execute();
        $stmt->bind_result($idErro, $descErro, $localErro, $dataHora, $usuario);

        while ($stmt->fetch()) {
            $erro = new Erro($idErro, $descErro, $localErro, $dataHora, $usuario);
            $erros[] = $erro;
        }

        $stmt->close();
        return $erros;
    }
}


?>