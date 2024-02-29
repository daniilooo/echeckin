<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $idEmpresa = $_POST['idEmpresa'];
    $razaoSocial = $_POST['razaoSocial'];
    $cnpj = $_POST['cnpj'];
    $status = $_POST['status'];

    $empresa = new Empresa($idEmpresa, $razaoSocial, $cnpj, $status, null);

    $daoEmpresa = new DaoEmpresa((new Conexao())->conectar(), 1);

    $qtdLinhasAlteradas = $daoEmpresa->alterarEmpresa($empresa);

    if($qtdLinhasAlteradas > 0){
        $log = new Log(null, "Empresa alterada\nID Empresa alterada: ".$idEmpresa, (new DateTime())->format('Y-m-d H:i:s'), 1);
        $daoLog = new DaoLog((new Conexao())->conectar(), 1);
        $idLog = $daoLog->inserirLog($log);
    }

    if($qtdLinhasAlteradas > 0 && $idLog> 0){
        header("Location: ../public/gerenciamentoEmpresas.php?altSucces=1");
        exit;
    } else {
        header("Location: ../public/gerenciamentoEmpresas.php?altSucces=0");
        exit;
    }
    
}


?>