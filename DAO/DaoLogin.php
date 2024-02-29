<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');
include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../model/login.php');


class DaoLogin{

    private $TBL_USUARIO = "TBL_USUARIO";
    private $conexao;

    function __construct($conexao){
        $this->conexao = $conexao;
    }

    function login(Login $acesso){

        $login = $acesso->getLogin();
        $senha = $acesso->getSenha();

        try{
            $stmt = $this->conexao->prepare("SELECT SENHA FROM {$this->TBL_USUARIO} WHERE LOGIN = ?");
            $stmt->bind_param("s", $login);
            
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if($row != null){
                $senhaBd = $row['SENHA'];
                return password_verify($senha, $senhaBd);                
            }  

            return false;

        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoLogin.login", $dataHoraFormatada->format('Y-m-d H:i:s'), 0);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return -2;    
        }
    }

    function retornarUsuario(Login $acesso){

        $login = $acesso->getLogin();
    
        try{
            $stmt = $this->conexao->prepare("SELECT ID_USUARIO FROM {$this->TBL_USUARIO} WHERE LOGIN = ?");
            $stmt->bind_param("s", $login);

            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if($row != null){
                return $row['ID_USUARIO'];
            }

            return null;
        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0,$e->getMessage(), "DaoLogin.retornarUsuario", $dataHoraFormatada->format('Y-m-d H:i:s'), 0);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());            
            $daoErro->inserirErro($erro);
            return -2;    
        }
    
    }
    
}


?>