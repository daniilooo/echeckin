<?php

include_once(__DIR__ . '/DaoErro.php');
include_once(__DIR__ . '/../model/checkin.php');

class DaoCheckin{
    private $TBL_CHECKIN = "TBL_CHECKIN";
    private $conexao;
    private $idUsuarioSessao;

    function __construct($conexao, $idUsuarioSessao){
        $this->conexao = $conexao;
        $this->idUsuarioSessao = $idUsuarioSessao;
    }

    private function inserirErro($erro, $localErro, $fkUsuario){
        $erro = new Erro(null, $erro, $localErro, (new DateTime)->format('Y-m-d H:i:s'), $fkUsuario);
        $daoErro = new DaoErro((new Conexao())->conectar());
        $daoErro->inserirErro($erro);
    }

    function inserirCheckin(Checkin $checkin){
        $fkLocal = $checkin->getFkLocal();
        $fkUsuario = $checkin->getFkUsuario();
        $dataHora = $checkin->getDataHora();

        try{
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_CHECKIN} (FK_LOCAL, FK_USUARIO, DATAHORA_CHECKIN) VALUES (?,?,?)");
            $stmt->bind_param("iis", $fkLocal, $fkUsuario, $dataHora);

            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return -1;
            }

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoCheckin.inserirCheckin", $this->idUsuarioSessao);
            return null;    
        }
    }

    function detalharCheckin($idCheckin){

        try{
            $stmt = $this->conexao->prepare("SELECT FK_LOCAL, FK_USUARIO, DATAHORA_CHECKIN FROM {$this->TBL_CHECKIN} WHERE ID_CHECKIN = ?");
            $stmt->bind_param("i", $idCheckin);

            $stmt->execute();
            $result = $stmt->get_result();

            $row = $result->fetch_assoc();
            
            if($row != null){
                return new Checkin($row['ID_CHECKIN'], $row['FK_LOCAL'], $row['FK_USUARIO'], $row['DATAHORA_CHECKIN']);
            } else {
                return null;
            }

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoCheckin.detalharCheckin", $this->idUsuarioSessao);
            return null;    
        }
    }

    function gerarListaCheckinPorLocal(Local $local){
        $idLocal = $local->getIdLocal();
        $listaDeCheckins = [];

        try{
            $stmt = $this->conexao->prepare("SELECT ID_CHECKIN, FK_LOCAL, FK_USUARIO, DATAHORA_CHECKIN FROM {$this->TBL_CHECKIN} WHERE FK_LOCAL = ?");
            $stmt->bind_param("i", $idLocal);

            $stmt->execute();

            $result = $stmt->get_result();
            
            while($row = $result->fetch_assoc()){
                $checkin = new Checkin($row['ID_CHECKIN'], $row['FK_LOCAL'], $row['FK_USUARIO'], $row['DATAHORA_CHECKIN']);
                $listaDeCheckins[] = $checkin;
            }

            return $listaDeCheckins;        
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoCheckin.gerarListaCheckinPorLocal", $this->idUsuarioSessao);
            return null;     
        }
    }

    /**
     * Método consulta a view CHECKIN_LOCAL_EMPRESA_USUARIO criadaa no BD
     */
    function gerarListaCheckinPorEmpresa($idEmpresa){
        $listaCheckins = [];
        try{
            $stmt = $this->conexao->prepare("SELECT ID_CHECKIN, FK_LOCAL, FK_EMPRESA, FK_USUARIO, OCORRENCIA FROM CHECKIN_LOCAL_EMPRESA_USUARIO WHERE FK_EMPRESA = ? ORDER BY OCORRENCIA DESC LIMIT 12");
            $stmt->bind_param("i", $idEmpresa);

            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $listaCheckins[] = [
                    'idCheckin' => $row['ID_CHECKIN'],
                    'fkLocal' => $row['FK_LOCAL'],
                    'fkUsuario' => $row['FK_USUARIO'],
                    'ocorrencia' => $row['OCORRENCIA']
                ];
            }

            return $listaCheckins;
            
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoCheckin.gerarListaCheckinPorEmpresa", $this->idUsuarioSessao);
            return null;
        }
    }

}

?>