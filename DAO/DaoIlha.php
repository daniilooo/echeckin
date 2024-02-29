<?php

include_once(__DIR__ .'/DaoErro.php');
include_once(__DIR__ .'/../model/ilha.php');

class DaoIlha{
    private $TBL_ILHA = "TBL_ILHAS";
    private $conexao;
    private $idUsuarioSessao;

    function __construct($conexao, $idUsuarioSessao){
        $this->conexao = $conexao;
        $this->idUsuarioSessao = $idUsuarioSessao;
    }

    function inserirIlha(Ilha $ilha){
        $idEmpresa = $ilha->getIdEmpresa();
        $descIlha = $ilha->getDescIlha();
        $statusIlha = $ilha->getStatusIlha();

        try{
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_ILHA} (ID_EMPRESA, DESC_ILHA, STATUS_ILHA) VALUES (?,?,?)");
            $stmt->bind_param("isi", $idEmpresa, $descIlha, $statusIlha);

            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return -1;
            }
        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoIlha.inserirIlha", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return null;    
        }
    }

    function selecionarIlha($idIlha){

        $idEmpresa = null;
        $descIlha = null;
        $statusIlha = null;

        try{
            $stmt = $this->conexao->prepare("SELECT ID_EMPRESA, DESC_ILHA, STATUS_ILHA FROM {$this->TBL_ILHA} WHERE ID_ILHA = ?");
            $stmt->bind_param("i", $idIlha);

            $stmt->execute();
            $stmt->bind_result($idEmpresa, $descIlha, $statusIlha);

            if($stmt->fetch()){
                return new Ilha($idIlha, $idEmpresa, $descIlha, $statusIlha);
            } else {
                return null;
            }

        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoIlha.selecionarIlha", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return null;    
        }
    }

    function alterarStatusIlha(Ilha $ilha){
        $idIlha = $ilha->getIdIlha();
        $statusIlha = $ilha->getStatusIlha();

        try{
            $stmt = $this->conexao->prepare("UPDATE {$this->TBL_ILHA} SET STATUS_ILHA = ? WHERE ID_ILHA = ?");
            $stmt->bind_param("ii", $statusIlha, $idIlha);

            if($stmt->execute()){
                return $stmt->affected_rows;
            } else {
                return -1;
            }
        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoIlha.alterarStatusIlha", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return null;    
        }
    }

    function gerarListaIlhas($idEmpresa){
        $listaDeIlhas = [];
        $idIlha = null;
        $descIlha = null;
        $statusIlha = null;

        try{
            $stmt = $this->conexao->prepare("SELECT ID_ILHA, DESC_ILHA, STATUS_ILHA WHERE ID_EMPRESA = ?");
            $stmt->bind_param("i", $idEmpresa);

            $stmt->execute();
            $stmt->bind_result($idIlha, $descIlha, $statusIlha);

            while($stmt->fetch()){
                $ilha = new Ilha($idIlha, $idEmpresa, $descIlha, $statusIlha);
                $listaDeIlhas[] = $ilha;
            }

            $stmt->close();
            return $listaDeIlhas;
            
        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoIlha.gerarListaIlhas", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return null;    
        }
    }
}

?>