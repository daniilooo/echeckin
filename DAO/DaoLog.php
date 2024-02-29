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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoLog.InserirLog", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
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
            $stmt = $this->conexao->prepare("SELECT * FROM {$this->TBL_LOG}");
            $stmt->execute();

            $stmt->bind_result($idLog, $regLog, $dataHora, $idUsuario);

            while($stmt->fetch()){
                $log = new Log($idLog, $regLog, $dataHora, $idUsuario);
                $listaLog[] = $log;
            }

            $stmt->close();
            return $listaLog;

        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoLog.gerarListaLog", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
            return -2;
        }
    }
    

}

?>