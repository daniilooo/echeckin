<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../model/justificativa.php');

class DaoJustificativa{
    private $TBL_JUSTIFICATIVA = "TBL_JUSTIFICATIVA";
    private $conexao;
    private $idUsuarioSessao;

    function __construct($conexao, $idUsuarioSessao){
        $this->conexao = $conexao;
        $this->idUsuarioSessao = $idUsuarioSessao;
    }

    function inserirJustificativa(Justificativa $justificativa){
        $usuario = $justificativa->getIdUsuario();
        $local = $justificativa->getIdLocal();
        $motivo = $justificativa->getJustificativa();
        $dataHora = $justificativa->getDataHora();

        try{
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_JUSTIFICATIVA} VALUES (null, ?,?,?,?)");
            $stmt->bind_param("iiss", $usuario, $local, $motivo, $dataHora);

            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return -1;
            }
        } catch (Exception $e){
            $erro = new Erro(null, $e->getMessage(), "DaoJustificativa.inserirJustificativa", (new DateTime())->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $daoErro = new DaoErro((new Conexao())->conectar());
            $daoErro->inserirErro($erro);
            return -2;
        }
    }

    function selecionarJustificativa($idJustificativa){
        try{
            $stmt = $this->conexao->prepare("SELECT FK_USUARIO, FK_LOCAL, JUSTIFICATIVA, DATA_HORA FROM {$this->TBL_JUSTIFICATIVA} WHERE ID_JUSTIFICATIVA = ?");
            $stmt->bind_param("i", $idJustificativa);

            $stmt->execute();
            $result = $stmt->get_result();

            $row = $result->fetch_assoc();

            if($row != null){
                return new Justificativa($idJustificativa, $row['FK_USUARIO'], $row['FK_LOCAL'], $row['JUSTIFICATIVA'], $row['DATA_HORA']);
            } else {
                return null;
            }
        } catch (Exception $e){
            $erro = new Erro(null, $e->getMessage(), "DaoJustificativa.selecionarJustificativa", (new DateTime())->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $daoErro = new DaoErro((new Conexao())->conectar());
            $daoErro->inserirErro($erro);
            return null;
        }
    }

    function gerarListaJustificativas(){
        $listaJustificativas = [];
        try{
            $stmt = $this->conexao->prepare("SELECT FK_USUARIO, FK_LOCAL, JUSTIFICATIVA, DATA_HORA FROM {$this->TBL_JUSTIFICATIVA}");
            $stmt->execute();
            
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $justificativa = new Justificativa($row['ID_JUSTIFICATIVA'], $row['FK_USUARIO'], $row['FK_LOCAL'], $row['JUSTIFICATIVA'], $row['DATA_HORA']);
                $listaJustificativas [] = $justificativa;
            }

            return $listaJustificativas;
        } catch (Exception $e){
            $erro = new Erro(null, $e->getMessage(), "DaoJustificativa.gerarListaJustificativas", (new DateTime())->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $daoErro = new DaoErro((new Conexao())->conectar());
            $daoErro->inserirErro($erro);
            return null;
        }
    }
}

?>