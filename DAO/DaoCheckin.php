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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoCheckin.inserirCheckin", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoCheckin.detalharCheckin", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoCheckin.detalharCheckin", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return null;    
        }
    }

}

?>