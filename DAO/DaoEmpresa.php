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

    private function inserirErro($erro, $localErro, $fkUsuario){
        $erro = new Erro(null, $erro, $localErro, (new DateTime())->format('Y-m-d H:i:s'), $fkUsuario);
        $daoErro = new DaoErro((new Conexao())->conectar());
        $daoErro->inserirErro($erro);
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
            $this->inserirErro($e->getMessage(), "DaoEmpresa.inserirEmpresa", $this->idUsuarioSessao);
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
            $this->inserirErro($e->getMessage(), "DaoEmpresa.selecionarEmpresa", $this->idUsuarioSessao);
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
            $this->inserirErro($e->getMessage(), "DaoEmpresa.alterarStatusEmpresa", $this->idUsuarioSessao);
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
            $this->inserirErro($e->getMessage(), "DaoEmpresa.alterarEmpresa", $this->idUsuarioSessao);
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
            $this->inserirErro($e->getMessage(), "DaoEmpresa.gerarListaEmpresas", $this->idUsuarioSessao);
            return -2;    
        }
    }
}

?>