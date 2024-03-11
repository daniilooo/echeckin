<?php

include_once(__DIR__ .'/../DAO/DaoErro.php');
include_once(__DIR__ .'/../model/local.php');
include_once(__DIR__ .'/../model/tipoLocal.php');

class DaoLocal{
    private $TBL_LOCAIS = "TBL_LOCAIS";
    private $TBL_TIPOS_LOCAIS = "TBL_TIPOS_LOCAIS";

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

    function inserirLocal(Local $local){
        $fkEmpresa = $local->getFkEmpresa();
        $fkTipoLocal = $local->getFkTipoLocal();
        $descLocal = $local->getDescLocal();
        $statusLocal = $local->getStatusLocal();

        try{
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_LOCAIS} (FK_EMPRESA, FK_TIPO_LOCAL, DESC_LOCAL, STATUS_LOCAL) VALUES (?,?,?,?)");
            $stmt->bind_param("iisi", $fkEmpresa, $fkTipoLocal, $descLocal, $statusLocal);

            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return -1;
            }
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLocal.inserirLocal", $this->idUsuarioSessao);
            return -2;    
        }
    }

    function selecionarLocal($idLocal){
        try{
            $stmt = $this->conexao->prepare("SELECT FK_EMPRESA, FK_TIPO_LOCAL, DESC_LOCAL, STATUS_LOCAL FROM {$this->TBL_LOCAIS} WHERE ID_LOCAL = ?");
            $stmt->bind_param("i", $idLocal);

            $stmt->execute();
            $result = $stmt->get_result();

            $row = $result->fetch_assoc();

            if($row != null){
                return new Local($idLocal, $row['FK_EMPRESA'], $row['FK_TIPO_LOCAL'], $row['DESC_LOCAL'], $row['STATUS_LOCAL']);
            } else {
                return null;
            }
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLocal.selecionarLocal", $this->idUsuarioSessao);
            return -2;    
        }
    }

    function gerarListaDeLocaisPorEmpresa($idEmpresa){        
        $listaDeLocais = [];

        try{
            $stmt = $this->conexao->prepare("SELECT * FROM {$this->TBL_LOCAIS} WHERE FK_EMPRESA = ?");
            $stmt->bind_param("i", $idEmpresa);

            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $local = new Local($row['ID_LOCAL'], $row['FK_EMPRESA'], $row['FK_TIPO_LOCAL'], $row['DESC_LOCAL'], $row['STATUS_LOCAL']);
                $listaDeLocais[] = $local;
            }

            $result->close();

            return $listaDeLocais;            

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLocal.gerarListaDeLocaisPorEmpresa", $this->idUsuarioSessao);
            return -2;    
        }
    }

    function gerarListaDeLocais(){
        $listaDeLocais = [];
        try{
            $stmt = $this->conexao->prepare("SELECT * FROM {$this->TBL_LOCAIS}");
            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $local = new Local($row['ID_LOCAL'], $row['FK_EMPRESA'], $row['FK_TIPO_LOCAL'], $row['DESC_LOCAL'], $row['STATUS_LOCAL']);
                $listaDeLocais[] = $local;
            }

            return $listaDeLocais;
            
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLocal.gerarListaDeLocais", $this->idUsuarioSessao);
            return -2;    
        }
    }

    function gerarListaDeTIpos(){
        $tiposLocais = [];

        try{
            $stmt = $this->conexao->prepare("SELECT ID_TIPO_LOCAL, DESCRICAO_TIPOLOCAL, STATUS_TIPOLOCAL FROM {$this->TBL_TIPOS_LOCAIS}");

            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $tipoLocal = new TipoLocal($row['ID_TIPO_LOCAL'], $row['DESCRICAO_TIPOLOCAL'], $row['STATUS_TIPOLOCAL']);
                $tiposLocais[] = $tipoLocal;
            }

            return $tiposLocais;

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLocal.gerarListaDeTIpos", $this->idUsuarioSessao);
            return null;    
        }
    }

    function selecionarTipoLocal($idTipoLocal){
        try{
            $stmt = $this->conexao->prepare("SELECT DESCRICAO_TIPOLOCAL FROM {$this->TBL_TIPOS_LOCAIS} WHERE ID_TIPO_LOCAL = ?");
            $stmt->bind_param("i", $idTipoLocal);

            $stmt->execute();
            $result = $stmt->get_result();

            $row = $result->fetch_assoc();

            if($row != null){
                return $row['DESCRICAO_TIPOLOCAL'];
            } else {
                return "";
            }
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLocal.selecionarTipoLocal", $this->idUsuarioSessao);
            return null;    
        }
    }

    function alterarLocal(Local $local){
        $idLocal = $local->getIdLocal();
        $empresa = $local->getFkEmpresa();
        $tipo = $local->getFkTipoLocal();
        $descricao = $local->getDescLocal();
        $status = $local->getStatusLocal();

        try{
            $stmt = $this->conexao->prepare("UPDATE {this->TBL_LOCAIS} SET FK_EMPRESA = ?, FK_TIPO_LOCAL = ?, DESC_LOCAL = ?, STATUS_LOCAL = ? WHERE ID_LOCAL = ?");
            $stmt->bind_param("iisii", $empresa, $tipo, $descricao, $status, $idLocal);

            if($stmt->execute()){
                return $stmt->affected_rows;
            } else {
                return -2;
            }
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLocal.alterarLocal", $this->idUsuarioSessao);
            return -2;
        }
    }
}

?>