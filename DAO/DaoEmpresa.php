<?php

include_once(__DIR__ .'/DaoErro.php');
include_once(__DIR__ .'/../model/empresa.php');

class DaoEmpresa{
    private $TBL_EMPRESA = "TBL_EMPRESA";
    private $conexao;
    private $idUsuarioSessao;

    function __construct($conexao, $idUsuarioSessao){
        $this->conexao = $conexao;
        $this->idUsuarioSessao = $idUsuarioSessao;
    }

    function inserirEmpresa(Empresa $empresa){
        $razaoSocial = $empresa->getRazaoSocial();    
        $cnpj = $empresa->getCnpj();      
        $statusEmpresa = $empresa->getStatusEmpresa();

        try{

            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_EMPRESA} (RAZAO_SOCIAL, CNPJ, STATUS_EMPRESA) VALUES (?,?,?)");
            $stmt->bind_param("ssi", $razaoSocial, $cnpj, $statusEmpresa);

            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return -1;
            }

        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoEmpresa.inserirEmpresa", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return -2;    
        }
    }

    function selecionarEmpresa($idEmpresa){
        
        $razaoSocial = null;
        $cnpj = null;
        $statusEmpresa = null;
        $qtdLocais = null;       

        try{
            $stmt = $this->conexao->prepare("SELECT RAZAO_SOCIAL, CNPJ, STATUS_EMPRESA, QTD_LOCAIS FROM {$this->TBL_EMPRESA} WHERE ID_EMPRESA = ?");
            $stmt->bind_param("i", $idEmpresa);
            $stmt->execute();

            $stmt->bind_result($razaoSocial, $cnpj, $statusEmpresa, $qtdLocais);
            
            if($stmt->fetch()){
                return new Empresa($idEmpresa, $razaoSocial, $cnpj, $statusEmpresa, $qtdLocais);
            } else {
                return null;
            }

        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoEmpresa.selecionarEmpresa", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return null;    
        }
    }

    function alterarStatusEmpresa(Empresa $empresa){
        
        $idEmpresa = $empresa->getIdEmpresa();
        $statusEmpresa = $empresa->getStatusEmpresa();

        try{
            $stmt = $this->conexao->prepare("UPDATE {$this->TBL_EMPRESA} SET STATUS_EMPRESA = ? WHERE ID_EMPRESA = ?");
            $stmt->bind_param("ii", $statusEmpresa, $idEmpresa);

            if($stmt->execute()){
                return $stmt->affected_rows;
            } else {
                return -1;
            }

        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoEmpresa.alterarStatusEmpresa", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return -2;    
        }
    }

    function alterarEmpresa(Empresa $empresa){
        $idEmpresa = $empresa->getIdEmpresa();
        $razaoSocial = $empresa->getRazaoSocial();
        $cnpj = $empresa->getCnpj();
        $status = $empresa->getStatusEmpresa();

        try{
            $stmt = $this->conexao->prepare("UPDATE {$this->TBL_EMPRESA} SET RAZAO_SOCIAL = ?, CNPJ = ?, STATUS_EMPRESA = ? WHERE ID_EMPRESA = ?");
            $stmt->bind_param("ssii", $razaoSocial, $cnpj, $status, $idEmpresa);

            if($stmt->execute()){
                return $stmt->affected_rows;
            } else {
                return -1;
            }
            
        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoEmpresa.alterarStatusEmpresa", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return -2;    
        }
    }

    function gerarListaEmpresas(){
        $listaEmpresas = [];        

        try{
            $stmt = $this->conexao->prepare("SELECT * FROM {$this->TBL_EMPRESA}");
            $stmt->execute();           

            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $empresa = new Empresa($row['ID_EMPRESA'], $row['RAZAO_SOCIAL'], $row['CNPJ'], $row['STATUS_EMPRESA'], $row['QTD_LOCAIS']);
                $listaEmpresas[] = $empresa;
            }
            
            return $listaEmpresas;

        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoEmpresa.gerarListaEmpresas", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return -2;    
        }
    }
}

?>