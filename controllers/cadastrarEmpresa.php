<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $razaoSocial = $_POST['razaoSocial'];
    $cnpj = $_POST['cnpj'];
    $status = $_POST['status'];

    if($razaoSocial != null && $cnpj != null && $status != null){
        
        $empresa = new Empresa(null, $razaoSocial, $cnpj, $status, null);
        $daoEmpresa = new DaoEmpresa((new Conexao())->conectar(), 1);
        
        $idEmpresaCadastrada = $daoEmpresa->inserirEmpresa($empresa);

        if($idEmpresaCadastrada > 0){            
            $log = new Log(null, "Nova empresa cadastrada.\nID da empresa cadastrada: ".$idEmpresaCadastrada, (new DateTime())->format('Y-m-d H:i:s'), 1);
            $daoLog = new DaoLog((new Conexao())->conectar(), 1);
            
            $idLog = $daoLog->inserirLog($log);
        }

        if($idEmpresaCadastrada > 0 && $idLog >0){
            header("Location: ../public/gerenciamentoEmpresas.php?addEmp=1");
            exit;
        } else {
            header("Location: ../public/gerenciamentoEmpresas.php?addEmp=0");
            exit;
        }        

    } else {
        echo "Algum dado não chegou, verifique a requisiçao";
    }

}

?>