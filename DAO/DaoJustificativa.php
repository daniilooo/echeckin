<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../model/justificativa.php');

class DaoJustificativa
{
    private $TBL_JUSTIFICATIVA = "tbl_justificativa";
    private $conexao;
    private $idUsuarioSessao;

    function __construct($conexao, $idUsuarioSessao)
    {
        $this->conexao = $conexao;
        $this->idUsuarioSessao = $idUsuarioSessao;
    }

    private function inserirErro($erro, $localErro, $fkUsuario){
        $erro = new Erro(null, $erro, $localErro, (new DateTime())->format('Y-m-d H:i:s'), $fkUsuario);
        $daoErro = new DaoErro((new Conexao())->conectar());
        $daoErro->inserirErro($erro);
    }

    function inserirJustificativa(Justificativa $justificativa)
    {
        $usuario = $justificativa->getIdUsuario();
        $local = $justificativa->getIdLocal();
        $motivo = $justificativa->getJustificativa();
        $dataHora = $justificativa->getDataHora();
        $evidencia = $justificativa->getEvidencia();

        try {
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_JUSTIFICATIVA} VALUES (null, ?,?,?,?,?)");
            $stmt->bind_param("iisss", $usuario, $local, $motivo, $dataHora, $evidencia);

            if ($stmt->execute()) {
                return $stmt->insert_id;
            } else {
                return -1;
            }
        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoJustificativa.inserirJustificativa", $this->idUsuarioSessao);
            return -2;
        }
    }

    function selecionarJustificativa($idJustificativa)
    {
        try {
            $stmt = $this->conexao->prepare("SELECT FK_USUARIO, FK_LOCAL, JUSTIFICATIVA, DATA_HORA FROM {$this->TBL_JUSTIFICATIVA} WHERE ID_JUSTIFICATIVA = ?");
            $stmt->bind_param("i", $idJustificativa);

            $stmt->execute();
            $result = $stmt->get_result();

            $row = $result->fetch_assoc();

            if ($row != null) {
                return new Justificativa($idJustificativa, $row['FK_USUARIO'], $row['FK_LOCAL'], $row['JUSTIFICATIVA'], $row['DATA_HORA'], null);
            } else {
                return null;
            }
        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoJustificativa.selecionarJustificativa", $this->idUsuarioSessao);
            return null;
        }
    }

    function gerarListaJustificativas()
    {
        $listaJustificativas = [];
        try {
            $stmt = $this->conexao->prepare("SELECT ID_JUSTIFICATIVA, FK_USUARIO, FK_LOCAL, JUSTIFICATIVA, DATA_HORA FROM {$this->TBL_JUSTIFICATIVA}");
            $stmt->execute();

            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $justificativa = new Justificativa($row['ID_JUSTIFICATIVA'], $row['FK_USUARIO'], $row['FK_LOCAL'], $row['JUSTIFICATIVA'], $row['DATA_HORA'], null);
                $listaJustificativas[] = $justificativa;
            }

            return $listaJustificativas;
        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoJustificativa.gerarListaJustificativas", $this->idUsuarioSessao);
            return null;
        }
    }

    function gerarListaJustificativasPorEmpresa($idEmpresa)
    {
        $listaDeJustificativas = [];
        try {
            $stmt = $this->conexao->prepare("SELECT ID_JUSTIFICATIVA, FK_USUARIO, FK_LOCAL, JUSTIFICATIVA, DATA_HORA FROM EMPRESA_LOCAL_JUSTIFICATIVA WHERE FK_EMPRESA = ?");
            $stmt->bind_param("i", $idEmpresa);

            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $justificativa = new Justificativa($row['ID_JUSTIFICATIVA'], $row['FK_USUARIO'], $row['FK_LOCAL'], $row['JUSTIFICATIVA'], $row['DATA_HORA'], null);
                $listaDeJustificativas[] = $justificativa;
            }

            $result->close();
            return $listaDeJustificativas;
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoJustificativa.gerarListaJustificativasPorEmpresa", $this->idUsuarioSessao);
            return null;
        }
    }
}


?>