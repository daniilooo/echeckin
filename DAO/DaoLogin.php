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

    private function inserirErro($erro, $localErro, $fkUsuario){
        $erro = new Erro(null, $erro, $localErro, (new DateTime())->format('Y-m-d H:i:s'), $fkUsuario);
        $daoErro = new DaoErro((new Conexao())->conectar());
        $daoErro->inserirErro($erro);
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
            $this->inserirErro($e->getMessage(), "DaoLogin.login", 0);
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
            $this->inserirErro($e->getMessage(), "DaoLogin.retornarUsuario", 0);
            return -2;    
        }
    
    }
    
}


?>