<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoLocal.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $empresa = $_POST['empresa'];
    $tipoLocal = $_POST['tipoLocal'];
    $descLocal = $_POST['descLocal'];
    $status = $_POST['status'];

    if ($empresa != null && $tipoLocal != null && $descLocal != null && $status != null) {

        $daoLocal = new DaoLocal((new Conexao())->conectar(), 1);

        $local = new Local(null, $empresa, $tipoLocal, $descLocal, $status);
        $idLocal = $daoLocal->inserirLocal($local);

        if ($idLocal > 0) {
            $log = new Log(null, "Novo local cadatrado.\nID do novo local: " . $idLocal, (new DateTime())->format('Y-m-d H:i:s'), 1);
            $daoLog = new DaoLog((new Conexao())->conectar(), 1);
            $idLog = $daoLog->inserirLog($log);
        }

        if ($idLocal > 0 && $idLog > 0) {
            header('Location: ../public/gerenciamentoEmpresas.php?isSuccess=1');
            exit; 
        }

    } else {

        echo "Algum dado não chegou, verifique o HTML";

    }

}

?>