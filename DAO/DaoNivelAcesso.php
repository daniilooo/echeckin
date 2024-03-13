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
        try{
            $stmt = $this->conexao->prepare("SELECT ID_NIVEL_ACESSO, DESC_NIVEL_ACESSO, STATUS_NIVELACESSO FROM {$this->TBL_NIVEIS_ACESSO}");
            $stmt->execute();
            $result = $stmt->get_result();
            
            while($row = $result->fetch_assoc()){
                $nivelAcesso = new NivelAcesso($row['ID_NIVEL_ACESSO'], $row['DESC_NIVEL_ACESSO'], $row['STATUS_NIVELACESSO']);
                $listaNiveisAcesso[] = $nivelAcesso;
            }

            return $listaNiveisAcesso;
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoNivelAcesso.gerarListaNiveisAcesso", $this->idUsuarioSessao);
            return null;
        }
    }
    
    function contagemUsuarioNivelAcesso(){
        try{
            $stmt = $this->conexao->prepare("SELECT NIVEL_ACESSO, COUNT(*) AS QUANT_USER FROM USUARIO_CARGO_ACESSO GROUP BY NIVEL_ACESSO");
            $stmt->execute();

            $result = $stmt->get_result();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $quantNivelAcesso[] = [
                        'idNivelAcesso' => $row['NIVEL_ACESSO'],
                        'quantUser' => $row['QUANT_USER']
                    ];
                }
            }

            return $quantNivelAcesso;
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoNivelAcesso.contagemUsuarioNivelAcesso", $this->idUsuarioSessao);
            return null;
        }
    }

}

?>
