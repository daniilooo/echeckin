<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoLocal.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');

if (isset($_GET['idEmpresa'])) {

    $idEmpresa = $_GET['idEmpresa'];

    $conexao = new Conexao();
    $daoLocal = new DaoLocal($conexao->conectar(), 1);
    $daoEmpresa = new DaoEmpresa($conexao->conectar(), 1);

    $empresa = $daoEmpresa->selecionarEmpresa($idEmpresa);

    $listaDeLocais = $daoLocal->gerarListaDeLocaisPorEmpresa($empresa);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCheckin - Gerenciamento de locais cadastrados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php
    include_once(__DIR__ . '/header.php');
    ?>
    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th>Tipo do local</th>
                    <th>Descrição do local</th>
                    <th>Status do local</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listaDeLocais as $local) {
                    ?>
                    <tr>
                        <th>
                            <?php echo $local->getFkTipoLocal() ?>
                        </th>
                        <th>
                            <?php echo $local->getDescLocal() ?>
                        </th>
                        <th>
                            <?php echo $local->getStatusLocal() ?>
                        </th>
                        <th>
                            <button class="btn btn-danger">Alterar status do local</button>
                            <button class="btn btn-primary">Gerar relatório do local</button>
                            <button class="btn btn-secondary" onclick="gerarCheckPoint(<?php echo $local->getIdLocal() ?>)">Gerar checkpoint</button>
                        </th>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function gerarCheckPoint(idLocal){
            window.location.href = "../public/checkPoint.php?idLocal="+idLocal;
        }
    </script>
    
</body>

</html>