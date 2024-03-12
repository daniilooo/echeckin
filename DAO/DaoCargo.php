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

    private function inserirErro($erro, $localErro, $idUsuario){
        $erro = new Erro(null, $erro, $localErro, (new DateTime())->format('Y-m-d H:i:s'), $idUsuario);
        $daoErro = new DaoErro((new Conexao())->conectar());
        $daoErro->inserirErro($erro);        
    }

    function inserirCargo(Cargo $cargo){

        $descricaoCargo = $cargo->descricaoCargo;
        $statusCargo = $cargo->statusCargo;
        $nivelAcesso = $cargo->nivelDeAcesso;

        try{
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_CARGOS} (DESCRICAO_CARGO, STATUS_CARGO, FK_NIVEL_ACESSO) VALUES (?,?,?)");
            $stmt->bind_param("sii", $descricaoCargo, $statusCargo, $nivelAcesso);

            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return -1;
            }
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoCargo.inserirCargo", $this->idUsuarioSessao);
            return null;    
        }

    }

    function selecionarCargo($idCargo){
        try{
            $stmt = $this->conexao->prepare("SELECT DESCRICAO_CARGO, STATUS_CARGO, FK_NIVEL_ACESSO FROM {$this->TBL_CARGOS} WHERE ID_CARGO = ?");
            $stmt->bind_param("i", $idCargo);

            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if($row != null){
                return new Cargo($idCargo, $row['DESCRICAO_CARGO'], $row['STATUS_CARGO'], $row['FK_NIVEL_ACESSO']);                
            } else {
                return null;
            }
                        
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoCargo.selecionarCargo", $this->idUsuarioSessao);
            return null;    
        }
    }

    function gerarListaCargo(){
        $listaDeCargos = [];
        try{
            $stmt = $this->conexao->prepare("SELECT ID_CARGO, DESCRICAO_CARGO, STATUS_CARGO, FK_NIVEL_ACESSO FROM {$this->TBL_CARGOS}");
            $stmt->execute();
            $result = $stmt->get_result();
            
            while($row = $result->fetch_assoc()){
                $cargo = new Cargo($row['ID_CARGO'], $row['DESCRICAO_CARGO'], $row['STATUS_CARGO'], $row['FK_NIVEL_ACESSO']);
                $listaDeCargos[] = $cargo;
            }

            return $listaDeCargos;

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoCargo.gerarListaCargo", $this->idUsuarioSessao);
            return null;    
        }
    }

    /*
    ESSE MÉTODO CONSULTA A VIEW QUANT_USUARIO_CARGO CRIADA NO BD.
    */

    function quantidadeUsuariosCargo($idCargo){
        try{
            $stmt = $this->conexao->prepare("SELECT ID_CARGO, DESCRICAO_CARGO, QUANTIDADE_USUARIOS_CARGO FROM QUANT_USUARIO_CARGO WHERE ID_CARGO = ?");
            $stmt->bind_param("i", $idCargo);

            $stmt->execute();
            $result = $stmt->get_result();    
            

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $quantUserCargo[] = [
                    'idCargo' => $row['ID_CARGO'],
                    'descCargo' => $row['DESCRICAO_CARGO'],
                    'quantUserCargo' => $row['QUANTIDADE_USUARIOS_CARGO']
                ];                                
            } else {
                $quantUserCargo[] = [
                    'idCargo' => $idCargo,
                    'descCargo' => 0,
                    'quantUserCargo' => 0
                ];
            }

            return $quantUserCargo;

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoCargo.quantidadeUsuariosCargo", $this->idUsuarioSessao);
            return null;
        }
    }

}

?>