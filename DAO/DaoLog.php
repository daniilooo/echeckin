<?php

include_once(__DIR__ . '/DaoErro.php');
include_once(__DIR__ . '/../model/log.php');

class DaoLog{

    private $TBL_LOG = "TBL_LOG";
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


    function inserirLog(Log $log){
        $regLog = $log->getRegLog();
        $dataHora = $log->getDataHora();
        $idUsuario = $log->getIdUsuario();

        try{
            $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_LOG} (REGLOG, DATAHORA, ID_USUARIO) VALUES (?,?,?)");
            $stmt->bind_param("ssi", $regLog, $dataHora, $idUsuario);
            
            if($stmt->execute()){
                return $stmt->insert_id;
            } else {
                return -1;
            }
        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLog.inserirLog", $this->idUsuarioSessao);
            return -2;
        }
    }

    function gerarListaLog(){
        $listaLog = [];
        $idLog = null;
        $regLog = null;
        $dataHora = null;
        $idUsuario = null;

        try{
            $stmt = $this->conexao->prepare("SELECT * FROM {$this->TBL_LOG} ORDER By ID_LOG desc");
            $stmt->execute();

            $stmt->bind_result($idLog, $regLog, $dataHora, $idUsuario);

            while($stmt->fetch()){
                $log = new Log($idLog, $regLog, $dataHora, $idUsuario);
                $listaLog[] = $log;
            }

            $stmt->close();
            return $listaLog;

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLog.gerarListaLog", $this->idUsuarioSessao);
            return -2;
        }
    }

    function recuperarUltimoLog(){
        try{
            $stmt = $this->conexao->prepare("SELECT ID_LOG, REGLOG, DATAHORA, ID_USUARIO FROM {$this->TBL_LOG} ORDER BY ID_LOG DESC LIMIT 1");
            $stmt->execute();

            $result = $stmt->get_result();
            
            $row = $result->fetch_assoc();

            if($row != null){
                return new Log($row['ID_LOG'], $row['REGLOG'], (new DateTime($row['DATAHORA']))->format('d/m/Y H:i:s'), $row['ID_USUARIO']);
            } else {
                return null;
            }

        } catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoLog.recuperarUltimoLog", $this->idUsuarioSessao);
            return -2;
        }
    }
    

}

?>