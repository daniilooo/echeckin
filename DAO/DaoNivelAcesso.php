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
            $erro = new Erro(null, $e->getMessage(), "DaoNivelAcesso.inserirNivelAcesso", (new DateTime())->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $daoErro = new DaoErro((new Conexao)->conectar());
            $daoErro->inserirErro($erro);
            return -2;
        }
    }

    function gerarListaNiveisAcesso(){
        $listaNiveisAcesso =[];
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
            $erro = new Erro(null, $e->getMessage(), "DaoNivelAcesso.gerarListaNiveisAcesso", (new DateTime())->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $daoErro = new DaoErro((new Conexao)->conectar());
            $daoErro->inserirErro($erro);
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
            $erro = new Erro(null, $e->getMessage(), "DaoNivelAcesso.contarUsuariosPorCargo", (new DateTime())->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $daoErro = new DaoErro((new Conexao)->conectar());
            $daoErro->inserirErro($erro);
            return null;
        }
    }
}

?>