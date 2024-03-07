<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../model/nivelAcesso.php');

class DaoNivelAcesso{

    private $TBL_NIVEIS_ACESSO = "TBL_NIVEIS_ACESSO2";
    private $conexao;
    private $idUsuarioSessao;

    function __construct($conexao, $idUsuarioSessao){
        $this->conexao = $conexao;
        $this->idUsuarioSessao = $idUsuarioSessao;
    }

    function inserirNivelAcesso(NivelAcesso $nivelAcesso){
        $descNivelAcesso = $nivelAcesso->getDescNivelAcesso();

        try{
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_NIVEIS_ACESSO} VALUES(null, ?)");
            $stmt->bind_params("s", $descNivelAcesso);

            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return null;
            }

        } catch (Exception $e){
            $erro = new Erro(null, $e->getMessage(), "DaoNivelAcesso.inserirNivelAcesso", (new DateTime())->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $daoErro = new DaoErro((new Conexao)->conectar());
            $daoErro->inserirErro($erro);
            return -2;
        }
    }
}

$nivelAcesso = new NivelAcesso(null, "Teste");
$conexao = new Conexao();
$daoNivelAcesso = new DaoNivelAcesso($conexao->conectar(), 1);

$daoNivelAcesso->inserirNivelAcesso($nivelAcesso);


?>