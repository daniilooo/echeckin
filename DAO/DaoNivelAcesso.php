<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../model/nivelAcesso.php');

class DaoNivelAcesso{

    private $TBL_NIVEIS_ACESSO = "TBL_NIVEIS_ACESSO";
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

    function inserirNivelAcesso(NivelAcesso $nivelAcesso){
        $descNivelAcesso = $nivelAcesso->getDescNivelAcesso();

        try{
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_NIVEIS_ACESSO} VALUES(null, ?)");
            $stmt->bind_param("s", $descNivelAcesso);

            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return null;
            }

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoNivelAcesso.inserirNivelAcesso", $this->idUsuarioSessao);
            return -2;
        }
    }

    function gerarListaNiveisAcesso(){
        $listaNivelAcesso[] =[];
        try{
            $stmt = $this->conexao->prepare("SELECT * FROM {$this->TBL_NIVEIS_ACESSO}");
            $stmt->execute();

            $result = $stmt->get_result();
            
            while($row = $result->fetch_assoc()){
                $nivelAcesso = new NivelAcesso($row['ID_NIVEL_ACESSO'], $row['DESC_NIVEL_ACESSO'], $row['STATUS_NIVELACESSO']);
                $listaNivelAcesso[] = $nivelAcesso;
            }

            return $listaNivelAcesso;
        } catch(Exception $e){
            $this->inserirErro($e->getMessage(), "DaoNivelAcesso.gerarListaNiveisAcesso", $this->idUsuarioSessao);
            return null;
        }
    }

    function contarUsuariosPorCargo(){
        $listaContagem = [];
        try{
            $stmt = $this->conexao->prepare("SELECT C.ID_CARGO, COUNT(U.ID_USUARIO) AS QUANTIDADE
                                            FROM TBL_CARGOS C
                                            INNER JOIN TBL_USUARIO U ON C.ID_CARGO = U.CARGO
                                            GROUP BY C.ID_CARGO");
            
            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $idCargo = $row['ID_CARGO'];
                $quantidade = $row['QUANTIDADE'];
                
                $listaContagem[] =[
                    'idCargo' => $idCargo,
                    'quantidade' => $quantidade
                ];
            }

            return $listaContagem;

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoNivelAcesso.contarUsuariosPorCargo", $this->idUsuarioSessao);
            return null;
        }
    }
}

?>