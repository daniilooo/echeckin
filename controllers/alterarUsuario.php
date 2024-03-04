<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');

session_start();
$sessionStatus = session_status();

if(!isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}

if($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']){    
    $idUsuario = $_SESSION['idUsuario'];
    $conexao = new Conexao();
    $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuario);

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $idUsuarioAlt = $_POST['idUsuarioAlt'];
        $nome = $_POST['nome'];
        $empresa = $_POST['empresa'];
        $cargo = $_POST['cargo'];
        $matricula = $_POST['matricula'];
        $login = $_POST['login'];
        $status = $_POST['status'];

        $usuario = new Usuario($idUsuarioAlt, $nome, $matricula, $empresa, $cargo, $login, null, $status);
        

        try{
            if($daoUsuario->atualizarUsuario($usuario) > 0){
                $daoLog = new DaoLog($conexao->conectar(), $idUsuario);
    
                $log = new Log(null, "Alteração no cadastro do usuário: ".$usuario->getIdUsuario(), (new DateTime())->format('Y-m-d H:i:s'), $idUsuario);
    
                if($daoLog->inserirLog($log)> 0){
                    header('Location: ../public/gerenciamentoUsuarios.php?altSucces=1');
                    exit;
                } else {
                    header('Location: ../public/gerenciamentoUsuarios.php?altSucces=1');
                    exit;
                }
            }

        } catch (Exception $e){
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "alterarUsuario.php", $dataHoraFormatada->format('Y-m-d H:i:s'), $idUsuario);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
            return -2;
        }

    }
}

?>