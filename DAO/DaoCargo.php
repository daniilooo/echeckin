<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../model/cargo.php');

class DaoCargo{

    private $TBL_CARGOS = "TBL_CARGOS";
    private $conexao;
    private $idUsuarioSessao;

    function __construct($conexao, $idUsuarioSessao){
        $this->conexao = $conexao;
        $this->idUsuarioSessao = $idUsuarioSessao;
    }

    function inserirCargo(Cargo $cargo){

        $descricaoCargo = $cargo->descricaoCargo;
        $statusCargo = $cargo->statusCargo;
        $nivelAcesso = $cargo->nivelDeAcesso;

        try{
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_CARGOS} (DESCRICAO_CARGO, STATUS_CARGO, NIVEL_ACESSO) VALUES (?,?,?)");
            $stmt->bind_param("sii", $descricaoCargo, $statusCargo, $nivelAcesso);

            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return -1;
            }
        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoCargo.inserirCargo", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return null;    
        }

    }

    function selecionarCargo($idCargo){
        try{
            $stmt = $this->conexao->prepare("SELECT DESCRICAO_CARGO, STATUS_CARGO, NIVEL_ACESSO FROM {$this->TBL_CARGOS} WHERE ID_CARGO = ?");
            $stmt->bind_param("i", $idCargo);

            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if($row != null){
                return new Cargo($idCargo, $row['DESCRICAO_CARGO'], $row['STATUS_CARGO'], $row['NIVEL_ACESSO']);                
            } else {
                return null;
            }            
        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoCargo.selecionarCargo", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return null;    
        }
    }

    function gerarListaCargo(){
        $listaDeCargos = [];
        try{
            $stmt = $this->conexao->prepare("SELECT ID_CARGO, DESCRICAO_CARGO, STATUS_CARGO, NIVEL_ACESSO FROM {$this->TBL_CARGOS}");
            $stmt->execute();
            $result = $stmt->get_result();
            
            while($row = $result->fetch_assoc()){
                $cargo = new Cargo($row['ID_CARGO'], $row['DESCRICAO_CARGO'], $row['STATUS_CARGO'], $row['FK_NIVEL_ACESSO']);
                $listaDeCargos[] = $cargo;
            }

            return $listaDeCargos;

        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoCargo.gerarListaCargo", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return null;    
        }
    }


}

?>